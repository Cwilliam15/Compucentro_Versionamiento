<?php
require_once 'src/auth.php';
require_once 'src/conexiondb.php';

if($_POST){
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $usuario = $_POST['usuario'];
    $correo = $_POST['correo'];
    $rol = $_POST['rol'];
    $pass = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO usuarios(nombre1,apellido1,usuario,correo,contrasena,rol) VALUES(?,?,?,?,?,?)");
    $stmt->execute([$nombre,$apellido,$usuario,$correo,$pass,$rol]);

    header("Location: usuarios.php?ok=1");
    exit;
}
?>

<h2>Crear Usuario</h2>
<form method="POST">
<label>Nombre:</label>
<input type="text" name="nombre" required>

<label>Apellido:</label>
<input type="text" name="apellido" required>

<label>Usuario:</label>
<input type="text" name="usuario" required>

<label>Correo:</label>
<input type="email" name="correo" required>

<label>Contraseña:</label>
<input type="password" name="contrasena" required>

<label>Rol:</label>
<select name="rol">
  <option value="admin">Administrador</option>
  <option value="editor">Editor</option>
</select>

<button type="submit" class="btn">Guardar</button>
<a href="usuarios.php" class="btn-cancel">Cancelar</a>
</form>
