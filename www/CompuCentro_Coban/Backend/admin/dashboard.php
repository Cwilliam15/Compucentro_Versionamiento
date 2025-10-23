<?php require 'auth.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard | CompuCentro</title>

  <!-- Estilos -->
  <link rel="stylesheet" href="assets/css/modulos.css">
  <link rel="stylesheet" href="assets/css/dashboard.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>
  <?php include 'includes/sidebar.php'; ?>

  <main class="main-content">
    <?php include 'includes/header.php'; ?>

    <section class="resumen">
      <div class="card">
        <h3><i class="fa-solid fa-user-graduate"></i> Interesados</h3>
        <p>45 registrados</p>
      </div>
      <div class="card">
        <h3><i class="fa-solid fa-book"></i> Cursos activos</h3>
        <p>8 cursos</p>
      </div>
      <div class="card">
        <h3><i class="fa-solid fa-bullhorn"></i> Convocatorias</h3>
        <p>2 vigentes</p>
      </div>
      <div class="card">
        <h3><i class="fa-solid fa-chart-line"></i> Estadísticas</h3>
        <p>Ver más →</p>
      </div>
    </section>

    <section class="charts">
      <h2>📊 Estadísticas de Interés</h2>
      <canvas id="chartCursos"></canvas>
    </section>

    <?php include 'includes/footer.php'; ?>
  </main>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="assets/js/dashboard.js"></script>
</body>
</html>