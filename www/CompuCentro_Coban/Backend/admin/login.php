<!DOCTYPE html>
<html lang="es"></html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Página de inicio de sesión</title>
</head>

<body>
<?php if (isset($_GET['logout'])): ?>
  <div class="alert success" id="logout-msg" style="margin:16px auto;max-width:760px;background:#F2F2F2;border-left:4px solid #1AA1D9;padding:10px 14px;border-radius:8px;color:#0D0D0D;">
    Has cerrado sesión correctamente.
  </div>
<?php endif; ?>
    <div class="container" id="container">
        <div class="form-container sign-up">
            <form action="src/procesar_solicitud_recuperacion.php" method="POST">
                <h1>Recuperar cuenta</h1>
                <span>Ingresa tu correo electrónico y te enviaremos un enlace para restablecerla.</span>
                
                <input type="email" name="correo" placeholder="Correo electrónico" required>
                <button type="submit">Enviar enlace</button>

                <?php 
                session_start();
                if (isset($_SESSION['reset_msg'])) {
                    echo "<p style='color:#F29727; font-size:14px; margin-top:10px;'>" . $_SESSION['reset_msg'] . "</p>";
                    unset($_SESSION['reset_msg']);
                }
                ?>
            </form>
        </div>
        <div class="form-container sign-in">
            <form action="src/procesar_login.php" method="POST">
                <h1>Iniciar sesión</h1>
                <span>utilizando el usuario y contraseña proporcionado</span>
                <img src="assets/img/logo.jpg" alt="logo CompuCentro">
                <input type="text" name="usuario" placeholder="Usuario" required>
                <input type="password" name="contrasena" placeholder="Contraseña" required>
                <button type="submit">Iniciar sesión</button>
            </form>
        </div>

        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>¡Bienvenido de nuevo!</h1>
                    <p>Ingresa tus datos personales para usar todas las funciones del sitio</p>
                    <button class="hidden" id="login">Iniciar sesión</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>¡Hola! ¿Olvidaste tu contraseña?</h1>
                    <p>No te preocupes, todos la olvidamos alguna vez, aprovecha para crear una contraseña más fuerte y segura.</p>
                    <button class="hidden" id="register">REESTABLECER CONTRASEÑA</button>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/script.js"></script>
</body>
<script>
document.addEventListener("DOMContentLoaded", () => {
    const msg = document.getElementById("logout-msg");
    if (msg) {
        setTimeout(() => {
            msg.style.opacity = "0";
            msg.style.transition = "opacity 1s ease";
            setTimeout(() => msg.remove(), 1000);
        }, 3000); // 3 segundos
    }
});
</script>
</html>