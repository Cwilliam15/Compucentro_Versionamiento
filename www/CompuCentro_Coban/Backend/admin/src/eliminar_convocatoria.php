<?php
require_once "conexiondb.php";

$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM convocatorias WHERE id_convocatoria = ?");
$stmt->execute([$id]);

header("Location: ../convocatorias.php");
exit;
?>