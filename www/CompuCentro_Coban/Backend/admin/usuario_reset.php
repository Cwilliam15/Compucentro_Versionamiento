<?php
require_once 'src/auth.php';
require_once 'src/conexiondb.php';

$id = $_GET['id'];
$newPass = substr(str_shuffle("ABCDEFGHJKMNPQRSTUVWXYZ23456789"),0,8);
$hash = password_hash($newPass, PASSWORD_DEFAULT);

$stmt = $pdo->prepare("UPDATE usuarios SET contrasena=? WHERE id_usuario=?");
$stmt->execute([$hash,$id]);

echo "<script>alert('Nueva contraseña para el usuario: $newPass');location='usuarios.php';</script>";
?>
