<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/conexiondb.php';

$seccion = $_POST['seccion'];
$titulo = $_POST['titulo'];
$descripcion = $_POST['descripcion'];

// Obtener la imagen actual
$stmt = $pdo->prepare("SELECT imagen FROM contenido WHERE seccion = ?");
$stmt->execute([$seccion]);
$imagenActual = $stmt->fetchColumn();

// Si se sube imagen, reemplazar
if(!empty($_FILES['imagen']['name'])){
    $nombreImagen = time() . "_" . basename($_FILES['imagen']['name']);
    $rutaDestino = __DIR__ . '/../../../Frontend/IMG/CONTENIDO/' . $nombreImagen;

    if(move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)){
        // eliminar imagen anterior si existe
        if($imagenActual && file_exists($rutaDestino)){
            @unlink($rutaDestino);
        }
    }
} else {
    $nombreImagen = $imagenActual; // dejar igual si no se cambia
}

$update = $pdo->prepare("UPDATE contenido SET titulo=?, descripcion=?, imagen=? WHERE seccion=?");
$update->execute([$titulo, $descripcion, $nombreImagen, $seccion]);

header("Location: ../editar_$seccion.php?s=ok");
exit;
?>