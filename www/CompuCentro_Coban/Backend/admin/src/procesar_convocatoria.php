<?php
require_once 'conexiondb.php';

$titulo = $_POST['titulo'];
$descripcion = $_POST['descripcion'];
$fecha_inicio = $_POST['fecha_inicio'];
$fecha_fin = $_POST['fecha_fin'] ?: null;
$estado = $_POST['estado'];

$imagen = null;
if (!empty($_FILES['imagen']['name'])) {
    $nombre = time() . "_" . $_FILES['imagen']['name'];
    $ruta = "../assets/uploads/convocatorias/" . $nombre;
    move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta);
    $imagen = $nombre;
}

$stmt = $pdo->prepare("INSERT INTO convocatorias (titulo, descripcion, fecha_inicio, fecha_fin, estado, imagen) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->execute([$titulo, $descripcion, $fecha_inicio, $fecha_fin, $estado, $imagen]);

header("Location: ../convocatorias.php");
exit;
?>