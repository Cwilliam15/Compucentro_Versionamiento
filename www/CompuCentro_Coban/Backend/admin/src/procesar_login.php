<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once __DIR__ . '/conexiondb.php';

// Verificar campos
if (!isset($_POST['usuario']) || !isset($_POST['contrasena'])) {
    die("⚠️ Campos incompletos.");
}

$usuario = trim($_POST['usuario']);
$contrasenaIngresada = trim($_POST['contrasena']);

$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = ? LIMIT 1");
$stmt->execute([$usuario]);
$userData = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$userData) {
    // Usuario no existe
    $_SESSION['error_login'] = "El usuario no existe.";
    header("Location: ../login.php");
    exit;
}

$stored = $userData['contrasena'] ?? '';

$login_ok = false;

// Detectar si el stored parece SHA-512 hex (128 chars hex, solo 0-9a-f)
if (is_string($stored) && preg_match('/^[0-9a-f]{128}$/i', $stored)) {
    // Comparar SHA-512
    if (hash('sha512', $contrasenaIngresada) === strtolower($stored) || hash('sha512', $contrasenaIngresada) === strtoupper($stored)) {
        $login_ok = true;

        // Migrar a password_hash() (mejor algoritmo) — actualizamos la DB
        $newHash = password_hash($contrasenaIngresada, PASSWORD_DEFAULT);
        if ($newHash) {
            $update = $pdo->prepare("UPDATE usuarios SET contrasena = ? WHERE id_usuario = ?");
            $update->execute([$newHash, $userData['id_usuario']]);
            // ahora la fila contiene password_hash
        }
    }
} else {
    // Suponemos que es un hash creado por password_hash()
    if (password_verify($contrasenaIngresada, $stored)) {
        $login_ok = true;

        // Si el algoritmo cambió, rehash (opcional)
        if (password_needs_rehash($stored, PASSWORD_DEFAULT)) {
            $rehashed = password_hash($contrasenaIngresada, PASSWORD_DEFAULT);
            $update = $pdo->prepare("UPDATE usuarios SET contrasena = ? WHERE id_usuario = ?");
            $update->execute([$rehashed, $userData['id_usuario']]);
        }
    }
}

if (!$login_ok) {
    $_SESSION['error_login'] = "Usuario o contraseña incorrectos.";
    header("Location: ../login.php");
    exit;
}

// Login exitoso
// Login exitoso
$_SESSION['admin'] = [
    'id_usuario' => $userData['id_usuario'],
    'nombre1'   => $userData['nombre1'],
    'apellido1' => $userData['apellido1'],
    'usuario'   => $userData['usuario'],
    'correo'    => $userData['correo']
];

$_SESSION['ultimo_acceso'] = time();

header("Location: ../dashboard.php");
exit;
?>