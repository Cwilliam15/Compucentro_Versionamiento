<?php
require_once 'src/auth.php';
require_once 'src/conexiondb.php';

$id = $_GET['id'];

$pdo->prepare("DELETE FROM usuarios WHERE id_usuario=?")->execute([$id]);

header("Location: usuarios.php");
exit;
?>
