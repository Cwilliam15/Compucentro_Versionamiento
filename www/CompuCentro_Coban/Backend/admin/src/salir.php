<?php
require 'config.php';
session_start();

if (isset($_SESSION['admin']['id'])) {
    registrar_log($pdo, $_SESSION['admin']['id'], 'logout', 'Cierre de sesión');
}

session_destroy();
header("Location: ../login.php");
exit;
