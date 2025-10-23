<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel Administrativo | CompuCentro</title>

  <!-- Estilos globales -->
  <link rel="stylesheet" href="assets/css/modulos.css">

  <!-- Font Awesome (iconos) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- CSS dinámico según módulo -->
  <?php
  $pagina = basename($_SERVER['PHP_SELF']);
  if ($pagina === 'dashboard.php') {
    echo '<link rel="stylesheet" href="assets/css/dashboard.css">';
  } elseif ($pagina === 'cursos.php') {
    echo '<link rel="stylesheet" href="assets/css/cursos.css">';
  }
  ?>
</head>
<body>
<header class="header">
  <h1>Panel Administrativo</h1>
  <div class="user-info">
    <span>Hola, <?= htmlspecialchars($_SESSION['admin']['nombre']); ?></span>
  </div>
</header>
