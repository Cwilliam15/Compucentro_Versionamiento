<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'PHPMailer/PHPMailer.php';
require_once 'PHPMailer/SMTP.php';
require_once 'PHPMailer/Exception.php';

/**
 * Configuración general del correo para notificaciones
 * de formularios (contacto, preinscripción, etc.)
 */
function crearMailer(): PHPMailer {
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'tutyose77@gmail.com'; // Tu correo
    $mail->Password = 'ivskowvscglgksef'; // clave de aplicación (no la normal)
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;
    $mail->setFrom('tutyose77@gmail.com', 'Formulario Web CompuCentro');
    return $mail;
}
?>
