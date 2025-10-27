<?php
require_once "conexiondb.php";

$id = $_POST['id_convocatoria'];
$titulo = $_POST['titulo'];
$descripcion = $_POST['descripcion'];
$fecha_inicio = $_POST['fecha_inicio'];
$fecha_fin = $_POST['fecha_fin'] ?: NULL;
$estado = $_POST['estado'];

// Obtener convocatoria actual
$stmt = $pdo->prepare("SELECT imagen FROM convocatorias WHERE id_convocatoria = ?");
$stmt->execute([$id]);
$conv = $stmt->fetch(PDO::FETCH_ASSOC);
$imagen = $conv['imagen'];

// Si el usuario sube nueva imagen → reemplazar
if(isset($_FILES['imagen']) && $_FILES['imagen']['size'] > 0){
    $nombreImg = time() . "_" . $_FILES['imagen']['name'];
    move_uploaded_file($_FILES['imagen']['tmp_name'], "../assets/uploads/convocatorias/" . $nombreImg);
    $imagen = $nombreImg;
}

$update = $pdo->prepare("UPDATE convocatorias SET titulo=?, descripcion=?, fecha_inicio=?, fecha_fin=?, estado=?, imagen=? WHERE id_convocatoria=?");
$update->execute([$titulo, $descripcion, $fecha_inicio, $fecha_fin, $estado, $imagen, $id]);

header("Location: ../convocatorias.php");
exit;
?>