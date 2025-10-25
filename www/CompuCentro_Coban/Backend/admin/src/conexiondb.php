<?php
// Cargar variables del archivo .env (está 3 niveles arriba, junto a docker-compose.yml)
$envPath = __DIR__ . '/../../../.env';

if (!file_exists($envPath)) {
    die("❌ No se encontró el archivo .env en: $envPath");
}

// Leer .env en formato KEY=VALUE
$env = parse_ini_file($envPath);

$host = $env['MYSQL_HOST'] ?? 'db';
$dbname = $env['MYSQL_DATABASE'] ?? 'compucentro';
$user = $env['MYSQL_USER'];
$pass = $env['MYSQL_PASSWORD'];

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("❌ Error al conectar a la base de datos: " . $e->getMessage());
}

date_default_timezone_set('America/Guatemala');
?>