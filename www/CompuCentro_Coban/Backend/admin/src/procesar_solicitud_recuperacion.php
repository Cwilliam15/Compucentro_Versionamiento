<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once __DIR__ . '/conexiondb.php';
require_once __DIR__ . '/mailer_config.php';
use PHPMailer\PHPMailer\PHPMailer;

if (!isset($_POST['correo'])) {
    $_SESSION['reset_msg'] = "Ingresa un correo.";
    header("Location: ../login.php");
    exit;
}

$correo = trim($_POST['correo']);

$stmt = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE correo = ? LIMIT 1");
$stmt->execute([$correo]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    $_SESSION['reset_msg'] = "No existe ninguna cuenta con ese correo.";
    header("Location: ../login.php");
    exit;
}

$idUsuario = $user['id_usuario'];

$token = bin2hex(random_bytes(32));
$expira = date('Y-m-d H:i:s', strtotime('+1 hour'));

$stmt = $pdo->prepare("INSERT INTO recuperaciones_password (id_usuario, token, expiracion) VALUES (?, ?, ?)");
$stmt->execute([$idUsuario, $token, $expira]);

$enlace = "http://localhost:8081/Backend/admin/restablecer.php?token=$token";

try {
    $mail = crearMailer();

    $mail->CharSet = 'UTF-8';
    $mail->Encoding = 'base64';

    $mail->addAddress($correo);
    $mail->Subject = "Recuperación de contraseña - CompuCentro Cobán";
    $mail->Body = "Hola, \n\nHiciste una solicitud para recuperar tu contraseña.\nHaz clic en el siguiente enlace para restablecerla (válido por 1 hora):\n$enlace\n\nSi no solicitaste este cambio, ignora este mensaje.\n\nCompuCentro Cobán";
    $mail->send();

    $_SESSION['reset_msg'] = "✅ Te hemos enviado un correo con el enlace de recuperación.";
} catch (Exception $e) {
    die("<pre><strong>❌ ERROR SMTP:</strong> " . $mail->ErrorInfo . "</pre>");
}

header("Location: ../login.php");
exit;
?>