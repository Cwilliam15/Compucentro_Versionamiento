<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require 'conexiondb.php';

if (!isset($_POST['id_usuario'], $_POST['nueva_contrasena'], $_POST['confirmar_contrasena'])) {
    die("Solicitud inválida.");
}

$id = $_POST['id_usuario'];
$pass1 = $_POST['nueva_contrasena'];
$pass2 = $_POST['confirmar_contrasena'];

if ($pass1 !== $pass2) {
    die("Las contraseñas no coinciden.");
}

// Cifrar contraseña (SHA2)
$hash = hash('sha512', $pass1);

// Actualizar contraseña
$stmt = $pdo->prepare("UPDATE usuarios SET contrasena = ? WHERE id_usuario = ?");
$stmt->execute([$hash, $id]);

// Borrar token usado
$pdo->prepare("DELETE FROM recuperaciones_password WHERE id_usuario = ?")->execute([$id]);

echo "<script>alert('Contraseña actualizada correctamente. Ahora puedes iniciar sesión.'); window.location='../login.php';</script>";
?>