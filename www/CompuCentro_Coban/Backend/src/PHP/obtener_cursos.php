<?php
require_once '../../admin/src/conexiondb.php';

$stmt = $pdo->query("SELECT id_curso, nombre FROM cursos WHERE estado='activo'");
$cursos = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($cursos);

?>
