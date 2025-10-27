<?php
session_start();
require_once __DIR__ . '/conexiondb.php';

$token = $_POST['token'];
$nueva = password_hash($_POST['nueva'], PASSWORD_DEFAULT);

$stmt = $pdo->prepare("SELECT id_usuario FROM recuperaciones_password WHERE token = ? AND usado = 0 AND expiracion > NOW()");
$stmt->execute([$token]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$data) {
    die("Token no válido.");
}

$idUsuario = $data['id_usuario'];

$pdo->prepare("UPDATE usuarios SET contrasena = ? WHERE id_usuario = ?")->execute([$nueva, $idUsuario]);
$pdo->prepare("UPDATE recuperaciones_password SET usado = 1 WHERE token = ?")->execute([$token]);

$_SESSION['reset_msg'] = "✅ Contraseña actualizada correctamente.";
header("Location: ../login.php");
exit;
?>