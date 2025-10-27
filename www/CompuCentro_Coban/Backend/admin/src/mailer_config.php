<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../../src/PHP/PHPMailer/PHPMailer.php';
require __DIR__ . '/../../src/PHP/PHPMailer/SMTP.php';
require __DIR__ . '/../../src/PHP/PHPMailer/Exception.php';

// ✅ Cargar .env correctamente
$envPath = $_SERVER['DOCUMENT_ROOT'] . '/.env';

if (!file_exists($envPath)) {
    die("❌ ERROR: No se encontró el archivo .env en: $envPath");
}

$env = parse_ini_file($envPath);

function crearMailer() {
    global $env;
    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host       = $env['MAIL_HOST'];
    $mail->SMTPAuth   = true;
    $mail->Username   = $env['MAIL_USERNAME'];
    $mail->Password   = $env['MAIL_PASSWORD'];
    $mail->SMTPSecure = 'tls'; 
    $mail->Port       = $env['MAIL_PORT'];

    $mail->setFrom($env['MAIL_FROM'], $env['MAIL_FROM_NAME']);

    // Debug temporal
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;
    $mail->Debugoutput = 'html';

    return $mail;
}
?>