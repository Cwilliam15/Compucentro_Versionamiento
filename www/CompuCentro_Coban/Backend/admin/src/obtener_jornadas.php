<?php
require_once '../../src/conexiondb.php';

$stmt = $pdo->query("SELECT id_jornada, nombre FROM jornadas");
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
?>