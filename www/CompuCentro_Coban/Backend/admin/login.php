<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel Administrativo | CompuCentro</title>
  <link rel="stylesheet" href="assets/css/login.css">
</head>
<body>
  <main class="tarjeta">
    <h1>Panel Administrativo</h1>
    <?php if(isset($_SESSION['error'])): ?>
      <p class="error"><?= $_SESSION['error']; unset($_SESSION['error']); ?></p>
    <?php endif; ?>
    <form action="procesar_login.php" method="POST">
      <div class="campo">
        <input type="email" name="correo" placeholder=" " required>
        <label>Correo institucional</label>
      </div>
      <div class="campo">
        <input type="password" name="contrasena" placeholder=" " required>
        <label>Contraseña</label>
      </div>
      <button class="btn" type="submit">Ingresar</button>
    </form>
  </main>
</body>
</html>