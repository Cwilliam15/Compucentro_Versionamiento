<?php
session_start();

if (!isset($_SESSION['admin']) || empty($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit;
}

// Cierre de sesión tras 30 minutos de inactividad
if (isset($_SESSION['ultimo_acceso']) && (time() - $_SESSION['ultimo_acceso'] > 1800)) {
    session_destroy();
    header("Location: .../login.php");
    exit;
}
$_SESSION['ultimo_acceso'] = time();
