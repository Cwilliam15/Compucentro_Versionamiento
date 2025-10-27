<?php
require 'src/conexiondb.php';

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=reporte_preinscripciones.xls");

$query = $pdo->query("
    SELECT p.fecha, i.nombre1, i.apellido1, c.nombre AS curso, j.nombre AS jornada
    FROM preinscripciones p
    INNER JOIN interesados i ON p.id_interesado = i.id_interesado
    INNER JOIN oferta_cursos o ON p.id_oferta = o.id_oferta
    INNER JOIN cursos c ON o.id_curso = c.id_curso
    INNER JOIN jornadas j ON o.id_jornada = j.id_jornada
");
echo "<table border=1>";
echo "<tr><th>Fecha</th><th>Nombre</th><th>Curso</th><th>Jornada</th></tr>";
while($row = $query->fetch(PDO::FETCH_ASSOC)){
    echo "<tr>
        <td>{$row['fecha']}</td>
        <td>{$row['nombre1']} {$row['apellido1']}</td>
        <td>{$row['curso']}</td>
        <td>{$row['jornada']}</td>
    </tr>";
}
echo "</table>";
?>