<?php
require 'config.php';
session_start();

$correo = $_POST['correo'] ?? '';
$pass = $_POST['contrasena'] ?? '';

$stmt = $pdo->prepare("SELECT * FROM Usuarios WHERE correo = ? LIMIT 1");
$stmt->execute([$correo]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if ($usuario && password_verify($pass, $usuario['contrasena'])) {
    $_SESSION['admin'] = [
        'id' => $usuario['id_usuario'],
        'nombre' => $usuario['nombre'],
        'correo' => $usuario['correo'],
        'rol' => $usuario['rol']
    ];

    registrar_log($pdo, $usuario['id_usuario'], 'login', 'Inicio de sesión exitoso');
    header("Location: ../dashboard.php");
    exit;
} else {
    registrar_log($pdo, null, 'login_fallido', "Intento fallido con $correo");
    $_SESSION['error'] = "Credenciales incorrectas.";
    header("Location: ../login.php");
    exit;
}