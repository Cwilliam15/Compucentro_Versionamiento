<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require __DIR__ . '/src/conexiondb.php';

// 1. Obtener token de la URL
$token = $_GET['token'] ?? null;

if (!$token) {
    die("Enlace inválido.");
}

// 2. Validar token
$stmt = $pdo->prepare("SELECT id_usuario, expiracion FROM recuperaciones_password WHERE token = ? LIMIT 1");
$stmt->execute([$token]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$data || strtotime($data['expiracion']) < time()) {
    die("El enlace no es válido o ha expirado.");
}

$idUsuario = $data['id_usuario'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Restablecer contraseña</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="container">
    <div class="form-container sign-in" style="width:100%; position:relative;">
        <form action="src/procesar_cambio_password.php" method="POST">
            <h1>Restablecer contraseña</h1>
            <input type="hidden" name="id_usuario" value="<?php echo $idUsuario; ?>">
            <input type="password" name="nueva_contrasena" placeholder="Nueva contraseña" required>
            <input type="password" name="confirmar_contrasena" placeholder="Confirmar contraseña" required>
            <button type="submit">Cambiar contraseña</button>
        </form>
    </div>
</div>

</body>
</html>
