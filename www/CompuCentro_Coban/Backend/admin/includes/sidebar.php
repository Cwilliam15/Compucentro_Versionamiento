<aside class="sidebar">
  <div class="logo">
    <img src="assets/img/logo_compucentr.png" alt="Logo CompuCentro">
    <h2>CompuCentro</h2>
  </div>
  <nav>
    <ul>
      <li><a href="dashboard.php" class="<?= basename($_SERVER['PHP_SELF']) === 'dashboard.php' ? 'active' : '' ?>"><i class="fa-solid fa-house"></i> Inicio</a></li>
      <li><a href="cursos.php" class="<?= basename($_SERVER['PHP_SELF']) === 'cursos.php' ? 'active' : '' ?>"><i class="fa-solid fa-book"></i> Cursos</a></li>
      <li><a href="galeria.php"><i class="fa-solid fa-image"></i> Galería</a></li>
      <li><a href="convocatorias.php"><i class="fa-solid fa-bullhorn"></i> Convocatorias</a></li>
      <li><a href="contenido.php"><i class="fa-solid fa-pen-nib"></i> Contenido</a></li>
      <li><a href="usuarios.php"><i class="fa-solid fa-user-gear"></i> Usuarios</a></li>
      <li><a href="salir.php" class="logout"><i class="fa-solid fa-right-from-bracket"></i> Cerrar sesión</a></li>
    </ul>
  </nav>
</aside>
