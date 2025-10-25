<?php
require_once '../../admin/src/conexiondb.php'; // Ajusta la ruta según tu estructura

header('Content-Type: application/json; charset=utf-8');

try {
    $sql = "SELECT 
                oc.id_oferta,
                c.nombre AS nombre_curso,
                j.nombre AS jornada
            FROM oferta_cursos oc
            INNER JOIN cursos c ON oc.id_curso = c.id_curso
            INNER JOIN jornadas j ON oc.id_jornada = j.id_jornada
            WHERE c.estado = 'activo'
            ORDER BY c.nombre ASC";

    $stmt = $pdo->query($sql);
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "success" => true,
        "data" => $resultados
    ]);
} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "error" => $e->getMessage()
    ]);
}
?>
