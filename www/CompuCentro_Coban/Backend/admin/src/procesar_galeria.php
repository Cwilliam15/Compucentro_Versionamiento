<?php
require_once __DIR__ . '/conexiondb.php';
require_once __DIR__ . '/auth.php';

$accion = $_POST['accion'] ?? null;

// RUTA REAL donde están guardadas las imágenes (sin acentos)
$rutaBase = __DIR__ . '/../../../IMG/GALERIA/';


// =============================================================
//  AGREGAR IMAGEN
// =============================================================
if ($accion === 'agregar') {

    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'] ?? '';
    $archivo = $_FILES['imagen'];

    // Generar nombre único
    $nombreArchivo = time() . "_" . basename($archivo['name']);
    $rutaDestino = $rutaBase . $nombreArchivo;

    if (move_uploaded_file($archivo['tmp_name'], $rutaDestino)) {
        $stmt = $pdo->prepare("INSERT INTO galeria (titulo, descripcion, imagen) VALUES (?, ?, ?)");
        $stmt->execute([$titulo, $descripcion, $nombreArchivo]);
    }

    header("Location: ../galeria.php");
    exit;
}



// =============================================================
//  ELIMINAR IMAGEN
// =============================================================
if ($accion === 'eliminar') {

    $id = $_POST['id_foto'];

    $stmt = $pdo->prepare("SELECT imagen FROM galeria WHERE id_foto = ?");
    $stmt->execute([$id]);
    $imagen = $stmt->fetchColumn();

    if ($imagen && file_exists($rutaBase . $imagen)) {
        @unlink($rutaBase . $imagen);
    }

    $pdo->prepare("DELETE FROM galeria WHERE id_foto = ?")->execute([$id]);

    header("Location: ../galeria.php");
    exit;
}



// =============================================================
//  EDITAR IMAGEN (Título / Descripción / Imagen opcional)
// =============================================================
if ($accion === 'editar') {

    $id = $_POST['id_foto'];
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'] ?? '';

    // Obtener imagen actual
    $stmt = $pdo->prepare("SELECT imagen FROM galeria WHERE id_foto = ?");
    $stmt->execute([$id]);
    $imagenActual = $stmt->fetchColumn();

    // Si se subió una nueva imagen
    if (!empty($_FILES['imagen']['name'])) {
        $archivo = $_FILES['imagen'];
        $nuevoNombre = time() . "_" . basename($archivo['name']);
        $nuevaRuta = $rutaBase . $nuevoNombre;

        if (move_uploaded_file($archivo['tmp_name'], $nuevaRuta)) {
            // borrar imagen anterior
            if ($imagenActual && file_exists($rutaBase . $imagenActual)) {
                @unlink($rutaBase . $imagenActual);
            }
            $imagenActual = $nuevoNombre;
        }
    }

    // Actualizar registro
    $stmt = $pdo->prepare("UPDATE galeria SET titulo = ?, descripcion = ?, imagen = ? WHERE id_foto = ?");
    $stmt->execute([$titulo, $descripcion, $imagenActual, $id]);

    header("Location: ../galeria.php");
    exit;
}

?>