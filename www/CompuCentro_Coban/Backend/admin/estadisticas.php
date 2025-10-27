<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'src/auth.php';
require_once 'src/conexiondb.php';

// =======================
// 1) Interesados por Curso
// =======================
$queryCursos = $pdo->prepare("
    SELECT c.nombre AS curso, COUNT(p.id_preinscripcion) AS total
    FROM preinscripciones p
    INNER JOIN oferta_cursos o ON p.id_oferta = o.id_oferta
    INNER JOIN cursos c ON o.id_curso = c.id_curso
    GROUP BY c.id_curso, c.nombre
    ORDER BY total DESC
");
$queryCursos->execute();
$dataCursos = $queryCursos->fetchAll(PDO::FETCH_ASSOC);

// =======================
// 2) Interesados por Mes (Filtrable)
// =======================
$anio = $_GET['anio'] ?? date('Y');
$mes = $_GET['mes'] ?? '';

$sqlMes = "
    SELECT 
        DATE_FORMAT(MIN(p.fecha), '%b') AS mes,
        COUNT(*) AS total
    FROM preinscripciones p
    WHERE YEAR(p.fecha) = ?
";

$params = [$anio];

if ($mes != '') {
    $sqlMes .= " AND MONTH(p.fecha) = ? ";
    $params[] = $mes;
}

$sqlMes .= "
    GROUP BY YEAR(p.fecha), MONTH(p.fecha)
    ORDER BY MONTH(p.fecha)
";

$queryMes = $pdo->prepare($sqlMes);
$queryMes->execute($params);
$dataMes = $queryMes->fetchAll(PDO::FETCH_ASSOC);

// =======================
// 3) Interesados por Jornada
// =======================
$queryJornada = $pdo->prepare("
    SELECT j.nombre AS jornada, COUNT(p.id_preinscripcion) AS total
    FROM preinscripciones p
    INNER JOIN oferta_cursos o ON p.id_oferta = o.id_oferta
    INNER JOIN jornadas j ON o.id_jornada = j.id_jornada
    GROUP BY j.id_jornada, j.nombre
");
$queryJornada->execute();
$dataJornada = $queryJornada->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estadísticas | CompuCentro</title>

    <link rel="stylesheet" href="assets/css/modulos.css">
    <link rel="stylesheet" href="assets/css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        .charts { padding: 20px; }
        .chart-box {
            background: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            margin-bottom: 25px;
            height: 400px;
        }
        .filtros select, .filtros button {
            padding: 8px 12px;
            margin-right: 8px;
        }
    </style>
</head>
<body>

<?php include 'includes/sidebar.php'; ?>
<main class="main-content">
<?php include 'includes/header.php'; ?>

<h2 style="margin-left:20px;">📊 Estadísticas Generales</h2>

<form method="GET" class="filtros" style="margin: 10px 20px;">
    <label>Año:</label>
    <select name="anio">
        <?php
        $anioActual = date('Y');
        for($i = $anioActual; $i >= $anioActual-5; $i--) {
            echo "<option value='$i' ".(($i==$anio)?'selected':'').">$i</option>";
        }
        ?>
    </select>

    <label>Mes:</label>
    <select name="mes">
        <option value="">Todos</option>
        <?php
        for($m=1; $m<=12; $m++){
            $nombreMes = date("F", mktime(0,0,0,$m,1));
            echo "<option value='$m' ".(($m==$mes)?'selected':'').">$nombreMes</option>";
        }
        ?>
    </select>

    <button type="submit" class="btn">Filtrar</button>
</form>

<div class="chart-box">
    <h3>Interesados por Jornada</h3>
    <canvas id="chartJornada"></canvas>
</div>

<div class="charts">
    <div class="chart-box">
        <h3>Interesados por Curso</h3>
        <canvas id="chartCursos"></canvas>
    </div>

    <div class="chart-box">
        <h3>Interesados por Mes</h3>
        <canvas id="chartMes"></canvas>
    </div>
</div>

<div style="margin:20px;">
    <a href="exportar_excel.php" class="btn">Descargar Excel</a>
    <a href="exportar_pdf.php" class="btn">Descargar PDF</a>
</div>

<?php include 'includes/footer.php'; ?>
</main>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// Cursos
new Chart(document.getElementById('chartCursos'), {
    type: 'bar',
    data: {
        labels: <?= json_encode(array_column($dataCursos, 'curso')); ?>,
        datasets: [{ data: <?= json_encode(array_column($dataCursos, 'total')); ?>, backgroundColor: '#1A73E8' }]
    }
});

// Meses
new Chart(document.getElementById('chartMes'), {
    type: 'line',
    data: {
        labels: <?= json_encode(array_column($dataMes, 'mes')); ?>,
        datasets: [{ data: <?= json_encode(array_column($dataMes, 'total')); ?>, borderColor: '#FF6A03', borderWidth: 3, fill: false }]
    }
});

// Jornada
new Chart(document.getElementById('chartJornada'), {
    type: 'pie',
    data: {
        labels: <?= json_encode(array_column($dataJornada, 'jornada')); ?>,
        datasets: [{ data: <?= json_encode(array_column($dataJornada, 'total')); ?>, backgroundColor: ['#1A73E8','#FF6A03','#34A853'] }]
    }
});
</script>

</body>
</html>
