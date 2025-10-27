<?php
require_once 'src/auth.php';
require_once 'src/conexiondb.php';

// Obtener usuarios
$stmt = $pdo->query(" 
   SELECT id_usuario,
          CONCAT(nombre1,' ',apellido1) AS nombre,
          usuario,
          correo,
          rol,
          COALESCE(ultimo_login, '—') AS ultimo_login
   FROM usuarios
   ORDER BY id_usuario DESC
");
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

include 'includes/sidebar.php';
?>
<main class="main-content">
<?php include 'includes/header.php'; ?>

<h2><i class="fa-solid fa-user-gear"></i> Gestión de Usuarios</h2>

<div style="text-align:right; margin-bottom:15px;">
    <a href="usuario_nuevo.php" class="btn" style="background:#063B70;color:#fff;padding:8px 14px;border-radius:6px;">+ Nuevo Usuario</a>
</div>

<table class="table">
<thead>
<tr>
    <th>#</th>
    <th>Nombre</th>
    <th>Usuario</th>
    <th>Correo</th>
    <th>Rol</th>
    <th>Último acceso</th>
    <th>Acciones</th>
</tr>
</thead>
<tbody>
<?php $i=1; foreach ($usuarios as $u): ?>
<tr>
    <td><?= $i++ ?></td>
    <td><?= $u['nombre'] ?></td>
    <td><?= $u['usuario'] ?></td>
    <td><?= $u['correo'] ?></td>
    <td><?= ucfirst($u['rol']) ?></td>
    <td><?= $u['ultimo_login'] ?></td>
    <td>
        <a href="usuario_editar.php?id=<?= $u['id_usuario'] ?>" class="btn-edit">✏️</a>
        <a href="usuario_reset.php?id=<?= $u['id_usuario'] ?>" class="btn-reset">🔄</a>
        <a href="usuario_eliminar.php?id=<?= $u['id_usuario'] ?>" class="btn-del" onclick="return confirm('¿Eliminar este usuario?')">🗑️</a>
    </td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

<?php include 'includes/footer.php'; ?>
</main>
