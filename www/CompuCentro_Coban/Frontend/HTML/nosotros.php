<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Conexión a la BD del panel admin
require_once __DIR__ . '/../Backend/admin/src/conexiondb.php';

$stmt = $pdo->query("SELECT seccion, titulo, descripcion, imagen FROM contenido");
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

$mision = $vision = $historia = $valores = null;

foreach ($result as $row) {
    switch ($row['seccion']) {
        case 'mision':
            $mision = $row;
            break;
        case 'vision':
            $vision = $row;
            break;
        case 'historia':
            $historia = $row;
            break;
        case 'valores':
            $valores = $row;
            break;
    }
}

// Valores por defecto si faltan
$mision   = $mision   ?? ['titulo' => 'Misión', 'descripcion' => 'Contenido no disponible'];
$vision   = $vision   ?? ['titulo' => 'Visión', 'descripcion' => 'Contenido no disponible'];
$historia = $historia ?? ['titulo' => 'Historia', 'descripcion' => 'Contenido no disponible'];
$valores  = $valores  ?? ['titulo' => 'Valores', 'descripcion' => "No hay valores registrados aún"];


// Convertir valores a lista (evitando warning)
$listaValores = array_filter(array_map('trim', explode("\n", $valores['descripcion'] ?? '')));
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Nosotros - CompuCentro</title>

  <link rel="icon" href="../IMG/logo_compucentr.png" type="image/png">
  <link rel="stylesheet" href="../CSS/style.css">
  <link rel="stylesheet" href="../CSS/nosotros.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<header>
  <div class="logo">
    <img src="../IMG/logo_compucentr.png" alt="Logo CompuCentro" class="logo-img">
    <span class="brand"><b>Compu</b><span class="color-naranja">Centro</span></span>
  </div>
  <nav id="nav">
    <ul>
      <li><a href="../index.html">Inicio</a></li>
      <li><a href="nosotros.php" class="active">Nosotros</a></li>
      <li><a href="cursos.php">Cursos</a></li>
      <li><a href="convocatorias.html">Convocatorias</a></li>
      <li><a href="preinscripcion.html">Preinscríbete</a></li>
      <li><a href="galeria.html">Galería</a></li>
      <li><a href="contacto.html">Contacto</a></li>
    </ul>
  </nav>
</header>

<!-- PRESENTACIÓN -->
<section class="hero">
  <div class="hero-contenido">
    <h1>Conoce a <span>CompuCentro</span></h1>
    <p>Formando líderes tecnológicos con excelencia, innovación y compromiso.</p>
  </div>
</section>

<!-- MISIÓN Y VISIÓN -->
<section class="cards reveal">
  <div class="card">
    <h2><?= htmlspecialchars($mision['titulo']) ?></h2>
    <p><?= nl2br(htmlspecialchars($mision['descripcion'])) ?></p>
  </div>

  <div class="card">
    <h2><?= htmlspecialchars($vision['titulo']) ?></h2>
    <p><?= nl2br(htmlspecialchars($vision['descripcion'])) ?></p>
  </div>
</section>

<!-- VALORES -->
<section class="valores reveal">
  <h2><?= htmlspecialchars($valores['titulo']) ?></h2>
  <div class="grid-valores">
    <?php foreach ($listaValores as $valor): ?>
      <div class="valor"><i class="fas fa-check-circle"></i> <?= htmlspecialchars($valor) ?></div>
    <?php endforeach; ?>
  </div>
</section>

<!-- HISTORIA -->
<section class="historia reveal">
  <h2><i class="fas fa-book-open"></i> <?= htmlspecialchars($historia['titulo']) ?></h2>

  <div class="historia-contenido">
    <div class="texto">
      <p><?= nl2br(htmlspecialchars($historia['descripcion'])) ?></p>
    </div>
    <div class="imagen">
      <img src="../IMG/computadoras.jpg" alt="Historia de CompuCentro">
    </div>
  </div>
</section>

<!-- EQUIPO (más adelante lo haremos dinámico) -->
<section class="equipo reveal">
  <h2>Conoce a Nuestro Equipo</h2>
  <div class="cards-equipo">
    <div class="miembro"><img src="../IMG/Nosotros/19.jpg"><h3>Directora Académico</h3></div>
    <div class="miembro"><img src="../IMG/Nosotros/2.jpg"><h3>Administradora educativa</h3></div>
    <div class="miembro"><img src="../IMG/Nosotros/3.jpg"><h3>Instructor</h3></div>
    <div class="miembro"><img src="../IMG/Nosotros/IMG_9657.JPG"><h3>Instructora</h3></div>
  </div>
</section>

<script src="../JS/layout.js"></script>
<script src="../JS/nosotros.js"></script>
</body>
</html>
