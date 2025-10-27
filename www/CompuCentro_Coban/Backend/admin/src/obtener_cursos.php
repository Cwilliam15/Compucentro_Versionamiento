<?php
require_once '../../src/conexiondb.php';

$stmt = $pdo->query("SELECT id_curso, nombre FROM cursos WHERE estado = 'activo'");
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
?>