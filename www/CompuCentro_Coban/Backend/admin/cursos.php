<?php
require_once 'src/auth.php';
require_once 'src/config.php';

// Obtener cursos
$stmt = $pdo->query("SELECT * FROM Cursos ORDER BY id_curso DESC");
$cursos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestión de Cursos | CompuCentro</title>

  <!-- Estilos -->
  <link rel="stylesheet" href="assets/css/modulos.css">
  <link rel="stylesheet" href="assets/css/cursos.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>
  <?php include 'includes/sidebar.php'; ?>

  <main class="main-content">
    <?php include 'includes/header.php'; ?>

    <div class="container-admin">
      <h1 class="titulo-admin">Gestión de Cursos</h1>


<form class="form-curso" action="src/procesar_curso.php" method="POST" enctype="multipart/form-data">

  <div class="campo">
    <label>Nombre del curso:</label>
    <input type="text" name="nombre" required placeholder="Ejemplo: Técnico en Reparación de Computadoras">
  </div>

  <div class="campo">
    <label>Subtítulo (opcional):</label>
    <input type="text" name="subtitulo" placeholder="Ejemplo: Aprende a dominar las herramientas digitales">
  </div>

  <div class="campo">
    <label>Descripción:</label>
    <textarea name="descripcion" rows="3" required placeholder="Describe brevemente el contenido del curso..."></textarea>
  </div>

  <div class="campo">
    <label>Duración:</label>
    <input type="text" name="duracion" placeholder="Ejemplo: 12 a 16 meses">
  </div>

  <div class="campo">
    <label>Modalidad:</label>
    <input type="text" name="modalidad" placeholder="Ejemplo: Presencial 4 horas diarias">
  </div>

  <div class="campo">
    <label>Jornada:</label>
    <select name="id_jornada">
      <option value="">-- Selecciona jornada --</option>
      <?php
        $jornadas = $pdo->query("SELECT * FROM jornadas ORDER BY nombre ASC")->fetchAll(PDO::FETCH_ASSOC);
        foreach ($jornadas as $j) {
          echo "<option value='{$j['id_jornada']}'>{$j['nombre']} ({$j['hora_inicio']} - {$j['hora_fin']})</option>";
        }
      ?>
    </select>
  </div>

  <!-- Campo visible para escribir o elegir los días -->
  <div class="campo">
    <label>Días de la semana:</label>
    <input type="text" name="dia_semana" placeholder="Ejemplo: Lunes a Viernes o Sábado y Domingo" required>
  </div>

  <div class="campo">
    <label>Imagen del curso:</label>
    <input type="file" name="imagen" accept="image/*" required>
  </div>

  <div class="campo">
    <label>Estado:</label>
    <select name="estado" required>
      <option value="activo">Activo</option>
      <option value="inactivo">Inactivo</option>
    </select>
  </div>

  <button type="submit" class="btn-guardar">Guardar Curso</button>
</form>
      <hr class="division">

    </div>

          <section class="tabla-cursos">
  <h2 class="subtitulo">Cursos Registrados</h2>

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Subtítulo</th>
        <th>Descripción</th>
        <th>Duración</th>
        <th>Modalidad</th>
        <th>Imagen</th>
        <th>Estado</th>
        <th>Jornada</th>
        <th>Días</th>
      </tr>
    </thead>
    <tbody>
      <?php
        // Trae los datos del curso junto con jornada y días si existen
        $stmt = $pdo->query("
          SELECT c.*, j.nombre AS jornada, oc.dia_semana
          FROM Cursos c
          LEFT JOIN oferta_cursos oc ON c.id_curso = oc.id_curso
          LEFT JOIN jornadas j ON oc.id_jornada = j.id_jornada
          ORDER BY c.id_curso DESC
        ");
        $cursos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($cursos as $c):
      ?>
        <tr>
          <td><?= $c['id_curso'] ?></td>
          <td><?= htmlspecialchars($c['nombre']) ?></td>
          <td><?= htmlspecialchars($c['subtitulo'] ?? '-') ?></td>
          <td><?= htmlspecialchars($c['descripcion']) ?></td>
          <td><?= htmlspecialchars($c['duracion'] ?? '-') ?></td>
          <td><?= htmlspecialchars($c['modalidad'] ?? '-') ?></td>
          <td><img src="assets/uploads/<?= htmlspecialchars($c['imagen']) ?>" width="100" alt="Imagen del curso"></td>
          <td><?= ucfirst($c['estado']) ?></td>
          <td><?= htmlspecialchars($c['jornada'] ?? '—') ?></td>
          <td><?= htmlspecialchars($c['dia_semana'] ?? '—') ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</section>

    <?php include 'includes/footer.php'; ?>
  </main>
</body>
</html>
