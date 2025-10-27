<?php
require_once '../../admin/src/conexiondb.php';

$id_curso = $_GET['curso'] ?? 0;

$stmt = $pdo->prepare("
    SELECT o.id_jornada, j.nombre
    FROM oferta_cursos o
    INNER JOIN jornadas j ON o.id_jornada = j.id_jornada
    WHERE o.id_curso = ?
");
$stmt->execute([$id_curso]);
$jornadas = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($jornadas);
?>