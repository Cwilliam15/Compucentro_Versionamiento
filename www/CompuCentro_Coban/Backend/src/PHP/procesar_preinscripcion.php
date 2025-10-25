<?php 
require_once '../../admin/src/config.php';
require_once 'mailer_config.php';

use PHPMailer\PHPMailer\Exception;

/**
 * Divide un nombre completo en nombre1 y nombre2 automáticamente.
 */
function separarNombres($cadena) {
    $partes = preg_split('/\s+/', trim($cadena));
    $nombre1 = $partes[0] ?? null;
    $nombre2 = null;
    if (count($partes) > 1) {
        $nombre2 = implode(' ', array_slice($partes, 1));
    }
    return [$nombre1, $nombre2];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // === 1️⃣ Recibir y limpiar datos ===
        $nombreCompleto   = trim($_POST['nombre'] ?? '');
        $apellidoCompleto = trim($_POST['apellido'] ?? '');
        $fechaNac         = trim($_POST['fecha_nacimiento'] ?? '');
        $telefono         = trim($_POST['telefono'] ?? '');
        $idGenero         = trim($_POST['genero'] ?? '');
        $idOferta         = trim($_POST['curso_preferencia'] ?? ''); // id de oferta_cursos
        $jornada          = trim($_POST['jornada'] ?? '');
        $whatsapp         = trim($_POST['whatsapp'] ?? '');

        // Datos del encargado
        $nombreEnc        = trim($_POST['nombre_encargado'] ?? '');
        $apellidoEnc      = trim($_POST['apellido_encargado'] ?? '');
        $telefonoEnc      = trim($_POST['telefono_encargado'] ?? '');

        if (empty($nombreCompleto) || empty($apellidoCompleto) || empty($telefono) || empty($idOferta)) {
            throw new Exception("Por favor completa los campos obligatorios del interesado.");
        }

        // === 2️⃣ Separar nombres y apellidos ===
        [$nombre1, $nombre2] = separarNombres($nombreCompleto);
        [$apellido1, $apellido2] = separarNombres($apellidoCompleto);
        [$nombre1Enc, $nombre2Enc] = separarNombres($nombreEnc);
        [$apellido1Enc, $apellido2Enc] = separarNombres($apellidoEnc);

        // === 3️⃣ Iniciar transacción ===
        $pdo->beginTransaction();

        // === 4️⃣ Registrar encargado (si aplica) ===
        $idEncargado = null;
        if (!empty($nombreEnc) || !empty($telefonoEnc)) {
            $stmtEnc = $pdo->prepare("
                INSERT INTO encargados (nombre1, nombre2, apellido1, apellido2, telefono)
                VALUES (?, ?, ?, ?, ?)
            ");
            $stmtEnc->execute([$nombre1Enc, $nombre2Enc, $apellido1Enc, $apellido2Enc, $telefonoEnc]);
            $idEncargado = $pdo->lastInsertId();
        }

        // === 5️⃣ Registrar interesado ===
        $stmtInt = $pdo->prepare("
            INSERT INTO interesados (id_encargado, id_genero, nombre1, nombre2, apellido1, apellido2, fecha_nacimiento, telefono)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmtInt->execute([
            $idEncargado,
            $idGenero ?: null,
            $nombre1,
            $nombre2,
            $apellido1,
            $apellido2,
            $fechaNac ?: null,
            $telefono
        ]);
        $idInteresado = $pdo->lastInsertId();

        // === 6️⃣ Validar que la oferta exista ===
        $stmtVerif = $pdo->prepare("SELECT COUNT(*) FROM oferta_cursos WHERE id_oferta = ?");
        $stmtVerif->execute([$idOferta]);
        if ($stmtVerif->fetchColumn() == 0) {
            throw new Exception("La oferta seleccionada no existe o ha sido eliminada.");
        }

        // === 7️⃣ Crear preinscripción ===
        $stmtPre = $pdo->prepare("
            INSERT INTO preinscripciones (id_interesado, id_oferta, fuente)
            VALUES (?, ?, 'sitio_web')
        ");
        $stmtPre->execute([$idInteresado, $idOferta]);

        // === 8️⃣ Guardar notificación en BD ===
        $mensaje = "Nueva preinscripción de $nombre1 $apellido1 en oferta #$idOferta (Jornada: $jornada)";
        $stmtNotif = $pdo->prepare("
            INSERT INTO notificaciones (tipo, destino, asunto, mensaje)
            VALUES ('preinscripcion', 'tutyose77@gmail.com', 'Nueva preinscripción', ?)
        ");
        $stmtNotif->execute([$mensaje]);

        // === 9️⃣ Confirmar transacción ===
        $pdo->commit();

        // === 🔟 Enviar correo al administrador ===
        try {
            $mail = crearMailer();
            $mail->addAddress('tutyose77@gmail.com');
            $mail->isHTML(true);
            $mail->Subject = '📩 Nueva Preinscripción Recibida';
            $mail->Body = "
                <h2>📋 Nueva Preinscripción</h2>
                <p><b>Interesado:</b> $nombre1 $nombre2 $apellido1 $apellido2</p>
                <p><b>Teléfono:</b> $telefono</p>
                <p><b>Curso (ID oferta):</b> $idOferta</p>
                <p><b>Jornada:</b> $jornada</p>
                <p><b>WhatsApp:</b> $whatsapp</p>
            ";
            $mail->send();
        } catch (Exception $mailError) {
            error_log("Error al enviar correo: " . $mailError->getMessage());
        }

        // === ✅ Confirmar al usuario ===
        echo "<script>
            alert('✅ Tu preinscripción se envió correctamente.');
            window.location.href='../../../Frontend/HTML/preinscripcion.html';
        </script>";

    } catch (Exception $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }

        echo "<script>
            alert('❌ Error al procesar la preinscripción: " . addslashes($e->getMessage()) . "');
            window.history.back();
        </script>";
    }
}
?>
