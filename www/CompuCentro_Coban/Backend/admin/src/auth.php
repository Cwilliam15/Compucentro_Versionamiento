<?php
session_start();

if (!isset($_SESSION['admin']['id_usuario'])) {
    header("Location: login.php");
    exit;
}

// Expiración por inactividad (30 min)
if (isset($_SESSION['ultimo_acceso']) && (time() - $_SESSION['ultimo_acceso'] > 1800)) {
    session_unset();
    session_destroy();
    header("Location: login.php?timeout=1");
    exit;
}

$_SESSION['ultimo_acceso'] = time();

?>