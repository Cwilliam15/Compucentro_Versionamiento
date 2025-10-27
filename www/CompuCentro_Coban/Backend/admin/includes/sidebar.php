<aside class="sidebar">
  <div class="logo-area">
    <img src="assets/img/logo_compucentr.png" class="logo-img" alt="Logo">
    <span class="logo-text"><b>Compu</b><span class="naranja">Centro</span></span>
  </div>

  <nav class="menu">
    <ul>

      <li><a href="dashboard.php" class="<?= basename($_SERVER['PHP_SELF']) === 'dashboard.php' ? 'active' : '' ?>"><i class="fa-solid fa-house"></i> Inicio</a></li>

      <li><a href="cursos.php" class="<?= basename($_SERVER['PHP_SELF']) === 'cursos.php' ? 'active' : '' ?>"><i class="fa-solid fa-book-open"></i> Cursos</a></li>

      <li><a href="galeria.php" class="<?= basename($_SERVER['PHP_SELF']) === 'galeria.php' ? 'active' : '' ?>"><i class="fa-solid fa-image"></i> Galería</a></li>

      <li><a href="convocatorias.php" class="<?= basename($_SERVER['PHP_SELF']) === 'convocatorias.php' ? 'active' : '' ?>"><i class="fa-solid fa-bullhorn"></i> Convocatorias</a></li>

      <li><a href="usuarios.php" class="<?= basename($_SERVER['PHP_SELF']) === 'usuarios.php' ? 'active' : '' ?>"><i class="fa-solid fa-user-gear"></i> Usuarios</a></li>

      <hr>

      <li class="titulo-seccion">Nosotros</li>

      <li><a href="editar_mision.php" class="<?= basename($_SERVER['PHP_SELF']) === 'editar_mision.php' ? 'active' : '' ?>">Misión</a></li>
      <li><a href="editar_vision.php" class="<?= basename($_SERVER['PHP_SELF']) === 'editar_vision.php' ? 'active' : '' ?>">Visión</a></li>
      <li><a href="editar_historia.php" class="<?= basename($_SERVER['PHP_SELF']) === 'editar_historia.php' ? 'active' : '' ?>">Historia</a></li>
      <li><a href="editar_valores.php" class="<?= basename($_SERVER['PHP_SELF']) === 'editar_valores.php' ? 'active' : '' ?>">Valores</a></li>

      <hr>

      <li><a href="src/salir.php" class="logout"><i class="fa-solid fa-right-from-bracket"></i> Cerrar sesión</a></li>
    </ul>
  </nav>
</aside>
