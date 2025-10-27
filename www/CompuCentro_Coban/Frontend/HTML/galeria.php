<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/../Backend/admin/src/conexiondb.php';

// Obtener imágenes de la base de datos
$stmt = $pdo->query("SELECT * FROM galeria ORDER BY fecha DESC");
$imagenes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Galería - CompuCentro</title>

  <link rel="icon" href="../IMG/logo_compucentr.png" type="image/png">
  <link rel="stylesheet" href="../CSS/style.css">
  <link rel="stylesheet" href="../CSS/galeria.css">
</head>
<body>

<!-- Header -->
  <header>
    <div class="logo">
      <img src="../IMG/logo_compucentr.png" alt="Logo CompuCentro" class="logo-img">
      <span class="brand"><b>Compu</b><span class="color-naranja">Centro</span></span>
    </div>
    <nav id="nav">
      <ul>
        <li><a href="../index.html">Inicio</a></li>
        <li><a href="nosotros.html">Nosotros</a></li>
        <li><a href="cursos.php">Cursos</a></li>
        <li><a href="convocatorias.html">Convocatorias</a></li>
        <li><a href="preinscripcion.html">Preinscríbete</a></li>
        <li><a href="galeria.html" class="active">Galería</a></li>
        <li><a href="contacto.html">Contacto</a></li>
      </ul>
    </nav>
    <div class="menu-toggle" id="menu-toggle">☰</div>
  </header>
<main>
<section class="galeria">
  <h2 class="titulo">Nuestra Galería</h2>
  <div class="grid-galeria">

    <?php foreach ($imagenes as $foto): ?>
      <div class="item" data-title="<?= htmlspecialchars($foto['titulo']) ?>">
        <img src="../IMG/GALERIA/<?= htmlspecialchars($foto['imagen']) ?>" alt="<?= htmlspecialchars($foto['titulo']) ?>">
      </div>
    <?php endforeach; ?>

  </div>
</section>
</main>

<footer class="footer-elegante">
  <!-- tu footer tal como lo tienes -->
</footer>

<script src="../JS/layout.js"></script>
<script src="../JS/galeria.js"></script>
</body>
</html>
