<?php
require 'src/config.php';

$nombre = 'Administrador';
$correo = 'espvaneles@gmail.com';
$contrasena = 'AdminSegura#2025';
$hash = password_hash($contrasena, PASSWORD_DEFAULT);

$stmt = $pdo->prepare("INSERT INTO Usuarios (nombre, correo, contrasena, rol) VALUES (?, ?, ?, 'admin')");
$stmt->execute([$nombre, $correo, $hash]);

echo "✅ Usuario administrador creado con éxito.<br>";
echo "Correo: $correo<br>";
echo "Contraseña: $contrasena<br>";
echo "<b>Después de crear el usuario, borra este archivo por seguridad.</b>";
