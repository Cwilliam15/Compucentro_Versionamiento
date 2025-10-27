<?php
require_once '../../admin/src/conexiondb.php';

// Obtener datos del interesado
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$fecha_nacimiento = $_POST['fecha_nacimiento'];
$telefono = $_POST['telefono'];
$genero = $_POST['genero'];

// Obtenemos curso y jornada seleccionados
$id_curso = $_POST['curso_preferencia'];
$id_jornada = $_POST['jornada'];

// ✅ 1) Obtener id_oferta correspondiente
$stmt = $pdo->prepare("
    SELECT id_oferta 
    FROM oferta_cursos 
    WHERE id_curso = ? AND id_jornada = ?
    LIMIT 1
");
$stmt->execute([$id_curso, $id_jornada]);
$id_oferta = $stmt->fetchColumn();

if (!$id_oferta) {
    die("❌ No existe oferta para ese curso en esa jornada.");
}

// Datos del encargado (opcional)
$nombre_enc = $_POST['nombre_encargado'] ?? null;
$apellido_enc = $_POST['apellido_encargado'] ?? null;
$telefono_enc = $_POST['telefono_encargado'] ?? null;

$id_encargado = null;

// ✅ 2) Insertar encargado solo si escribió algo
if (!empty($nombre_enc) || !empty($apellido_enc) || !empty($telefono_enc)) {
    $stmt = $pdo->prepare("INSERT INTO encargados(nombre1, apellido1, telefono) VALUES (?, ?, ?)");
    $stmt->execute([$nombre_enc, $apellido_enc, $telefono_enc]);
    $id_encargado = $pdo->lastInsertId();
}

// ✅ 3) Registrar interesado
$stmt = $pdo->prepare("
    INSERT INTO interesados (id_encargado, id_genero, nombre1, apellido1, fecha_nacimiento, telefono)
    VALUES (?, ?, ?, ?, ?, ?)
");
$stmt->execute([$id_encargado, $genero, $nombre, $apellido, $fecha_nacimiento, $telefono]);
$id_interesado = $pdo->lastInsertId();

// ✅ 4) Registrar preinscripción
$stmt = $pdo->prepare("INSERT INTO preinscripciones (id_interesado, id_oferta) VALUES (?, ?)");
$stmt->execute([$id_interesado, $id_oferta]);

// ✅ Redirección exitosa
header("Location: /HTML/preinscripcion.html?ok=1");
exit;
?>