<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Incluir PHPMailer
require_once __DIR__ . '/PHPMailer/PHPMailer.php';
require_once __DIR__ . '/PHPMailer/SMTP.php';
require_once __DIR__ . '/PHPMailer/Exception.php';

// Crear una instancia
$mail = new PHPMailer(true);

try {
    // Configuración del servidor
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';      // Servidor SMTP de Gmail
    $mail->SMTPAuth   = true;
    $mail->Username   = 'tutyose77@gmail.com'; // ←el correo de envío
    $mail->Password   = 'ivskowvscglgksef'; // ←clave de aplicación
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Destinatarios
    $mail->setFrom('tutyose77@gmail.com', 'Formulario Contacto Web CompuCentro');// ← pon aquí el correo de envío
    $mail->addAddress('tutyose77@gmail.com'); // ← correo donde llegará el mensaje
    $mail->addReplyTo($_POST['correo'], $_POST['nombre']); // donde responderás
    
    // Contenido del mensaje
    $nombre  = $_POST['nombre'] ?? '';
    $correo  = $_POST['correo'] ?? '';
    $mensaje = $_POST['mensaje'] ?? '';

    $mail->isHTML(true);
    $mail->Subject = "Nuevo mensaje de contacto CompuCentro Cobán";
    $mail->Body    = "
        <h2>📩 Nuevo mensaje recibido</h2>
        <p><b>Nombre:</b> {$nombre}</p>
        <p><b>Correo:</b> {$correo}</p>
        <p><b>Mensaje:</b><br>{$mensaje}</p>
    ";

    // Enviar
    $mail->send();
    echo "<script>alert('✅ ¡Tu mensaje se envió correctamente!'); window.history.back();</script>";

} catch (Exception $e) {
    echo "<script>alert('❌ Error al enviar el mensaje: {$mail->ErrorInfo}'); window.history.back();</script>";
}
?>

