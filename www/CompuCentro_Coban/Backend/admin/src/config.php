<?php
try {
    // Datos de conexión para Docker
    $pdo = new PDO(
        'mysql:host=db;dbname=compucentro;charset=utf8mb4',
        'root',       // o 'admin' si prefieres usar el usuario normal
        'root'        // contraseña configurada en docker-compose.yml o .env
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("❌ Error al conectar a la base de datos: " . $e->getMessage());
}

date_default_timezone_set('America/Guatemala');

// Función para registrar logs (acciones del admin)
function registrar_log($pdo, $idUsuario, $accion, $descripcion = '') {
    $stmt = $pdo->prepare("INSERT INTO Logs (id_usuario, accion, descripcion, fecha) VALUES (?, ?, ?, NOW())");
    $stmt->execute([$idUsuario, $accion, $descripcion]);
}
