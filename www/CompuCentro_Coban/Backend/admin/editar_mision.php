<?php
require_once __DIR__ . '/src/auth.php';
require_once __DIR__ . '/src/conexiondb.php';

$seccion = 'mision';

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
    <h2>Editar Misión</h2>

    <form action="src/guardar_contenido.php" method="POST" enctype="multipart/form-data" class="form-contenido">

        <input type="hidden" name="seccion" value="mision">

        <div class="form-grid">
    <div>
        <label>Título:</label>
        <input type="text" name="titulo" value="<?= htmlspecialchars($data['titulo']) ?>" required>
    </div>

    <div>
        <label>Descripción:</label>
        <textarea name="descripcion" required><?= htmlspecialchars($data['descripcion']) ?></textarea>
    </div>
</div>


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
            <a href="nosotros_mision.php" class="btn-cancelar">Cancelar</a>
        </div>
    </form>
</div>

<?php include_once __DIR__ . '/includes/footer.php'; ?>
