<?php
require_once __DIR__ . '/src/auth.php';
require_once __DIR__ . '/src/conexiondb.php';

$seccion = 'valores';

// Obtener contenido actual
$stmt = $pdo->prepare("SELECT * FROM contenido WHERE seccion = ?");
$stmt->execute([$seccion]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$data){
    die("No existe contenido para esta sección.");
}
?>

<?php include_once __DIR__ . '/includes/header.php'; ?>
<?php include_once __DIR__ . '/includes/sidebar.php'; ?>
<link rel="stylesheet" href="assets/css/contenido.css">

<div class="content">
    <h2>Editar Valores</h2>

    <div class="form-contenido">

        <form action="src/guardar_contenido.php" method="POST" enctype="multipart/form-data">

            <input type="hidden" name="seccion" value="valores">

            <!-- GRID de Título y Descripción -->
            <div class="form-grid">

                <div>
                    <label>Título:</label>
                    <input type="text" name="titulo" value="<?= htmlspecialchars($data['titulo']) ?>" required>
                </div>

                <div>
                    <label>Valores (uno por línea):</label>
                    <textarea name="descripcion" rows="6" placeholder="Ejemplo:
Honestidad
Responsabilidad
Trabajo en equipo
Servicio de calidad" required><?= htmlspecialchars($data['descripcion']) ?></textarea>
                </div>

            </div>

            <br>

            <label>Imagen actual (opcional):</label>
            <?php if($data['imagen']): ?>
                <img src="/IMG/CONTENIDO/<?= $data['imagen'] ?>" class="preview-edit">
            <?php else: ?>
                <p><i>No hay imagen guardada</i></p>
            <?php endif; ?>

            <label>Subir nueva imagen (opcional):</label>
            <input type="file" name="imagen" accept="image/*">

            <div class="botones-acciones">
                <button type="submit" class="btn-guardar">Guardar Cambios</button>
                <a href="index.php" class="btn-cancelar">Cancelar</a>
            </div>

        </form>

    </div>
</div>

<?php include_once __DIR__ . '/includes/footer.php'; ?>
