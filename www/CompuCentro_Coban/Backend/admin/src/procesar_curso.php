<?php
require_once 'config.php';
require_once 'auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // --- Sanitización y validaciones básicas ---
    $nombre      = trim($_POST['nombre'] ?? '');
    $subtitulo   = trim($_POST['subtitulo'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $duracion    = trim($_POST['duracion'] ?? '');
    $modalidad   = trim($_POST['modalidad'] ?? '');
    $estado      = $_POST['estado'] ?? 'activo';
    $id_jornada  = !empty($_POST['id_jornada']) ? $_POST['id_jornada'] : null;
    $dia_semana  = trim($_POST['dia_semana'] ?? '');

    if (empty($nombre) || empty($descripcion)) {
        echo "<script>alert('⚠️ El nombre y la descripción son obligatorios.'); window.history.back();</script>";
        exit;
    }

    // --- Manejo de imagen ---
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $nombreArchivo = time() . '_' . basename($_FILES['imagen']['name']);
        $rutaDestino = __DIR__ . '/../assets/uploads/' . $nombreArchivo;

        // Verificar que la carpeta exista
        if (!is_dir(dirname($rutaDestino))) {
            mkdir(dirname($rutaDestino), 0777, true);
        }

        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {
            try {
                $pdo->beginTransaction();

                // --- Insertar curso principal ---
                $stmt = $pdo->prepare("
                    INSERT INTO Cursos (nombre, subtitulo, descripcion, imagen, duracion, modalidad, estado)
                    VALUES (?, ?, ?, ?, ?, ?, ?)
                ");
                $stmt->execute([$nombre, $subtitulo, $descripcion, $nombreArchivo, $duracion, $modalidad, $estado]);

                $idCurso = $pdo->lastInsertId();

                // --- Si hay jornada o días, insertarlos en oferta_cursos ---
                if ($id_jornada || $dia_semana) {
                    $stmtOferta = $pdo->prepare("
                        INSERT INTO oferta_cursos (id_curso, id_jornada, dia_semana)
                        VALUES (?, ?, ?)
                    ");
                    $stmtOferta->execute([$idCurso, $id_jornada, $dia_semana]);
                }

                // --- Confirmar cambios ---
                $pdo->commit();

                // --- Registrar log ---
                registrar_log($pdo, $_SESSION['admin']['id_usuario'] ?? 1, 'Agregar curso', "Curso agregado: $nombre");

                echo "<script>
                    alert('✅ Curso agregado correctamente.');
                    window.location.href='../cursos.php';
                </script>";

            } catch (Exception $e) {
                $pdo->rollBack();
                echo "<script>alert('❌ Error al guardar el curso: " . addslashes($e->getMessage()) . "'); window.history.back();</script>";
            }
        } else {
            echo "<script>alert('❌ Error al subir la imagen al servidor.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('⚠️ Debes seleccionar una imagen válida.'); window.history.back();</script>";
    }
}
?>