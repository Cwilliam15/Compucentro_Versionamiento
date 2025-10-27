<?php
require_once 'src/auth.php';
require_once 'src/conexiondb.php';

// Obtener ID del usuario
$id = intval($_GET['id']);

// Consultar datos actuales
$stmt = $pdo->prepare("
    SELECT nombre1, apellido1, usuario, correo, rol
    FROM usuarios
    WHERE id_usuario = ?
");
$stmt->execute([$id]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

// Si no existe, redirigir
if (!$usuario) {
    header("Location: usuarios.php");
    exit;
}

// Guardar cambios
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $user = $_POST['usuario'];
    $correo = $_POST['correo'];
    $rol = $_POST['rol'];

    $update = $pdo->prepare("
        UPDATE usuarios
        SET nombre1=?, apellido1=?, usuario=?, correo=?, rol=?
        WHERE id_usuario=?
    ");
    $update->execute([$nombre, $apellido, $user, $correo, $rol, $id]);

    header("Location: usuarios.php?edit=1");
    exit;
}

include 'includes/sidebar.php';
?>
<main class="main-content">
<?php include 'includes/header.php'; ?>

<h2><i class="fa-solid fa-user-pen"></i> Editar Usuario</h2>

<form method="POST" class="form-box">

    <label>Nombre:</label>
    <input type="text" name="nombre" value="<?= $usuario['nombre1'] ?>" required>

    <label>Apellido:</label>
    <input type="text" name="apellido" value="<?= $usuario['apellido1'] ?>" required>

    <label>Usuario:</label>
    <input type="text" name="usuario" value="<?= $usuario['usuario'] ?>" required>

    <label>Correo electrónico:</label>
    <input type="email" name="correo" value="<?= $usuario['correo'] ?>">

    <label>Rol del Usuario:</label>
    <select name="rol">
        <option value="admin" <?= ($usuario['rol']=="admin"?"selected":"") ?>>Administrador</option>
        <option value="editor" <?= ($usuario['rol']=="editor"?"selected":"") ?>>Editor</option>
    </select>

    <div class="btn-group">
        <button type="submit" class="btn">Guardar Cambios</button>
        <a href="usuarios.php" class="btn-cancel">Cancelar</a>
    </div>

</form>

<?php include 'includes/footer.php'; ?>
</main>

<style>
.form-box {
  background:#fff;
  padding:25px;
  border-radius:12px;
  box-shadow:0 3px 10px rgba(0,0,0,0.1);
  max-width:500px;
}
.form-box input, .form-box select {
  width:100%;
  padding:8px;
  margin-bottom:12px;
  border-radius:6px;
  border:1px solid #ccc;
}
.btn-group { margin-top:15px; }
.btn { background:#063B70;color:white;padding:8px 14px;border-radius:6px;text-decoration:none;border:none;cursor:pointer; }
.btn-cancel { padding:8px 14px;border-radius:6px;text-decoration:none;background:#ccc;color:#333; }
.btn:hover { opacity:.85; }
</style>
