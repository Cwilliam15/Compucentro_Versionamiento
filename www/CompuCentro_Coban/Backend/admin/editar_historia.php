<?php
require_once __DIR__ . '/src/auth.php';
require_once __DIR__ . '/src/conexiondb.php';

$seccion = 'historia';

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
    <h2>Editar Historia</h2>

    <form action="src/guardar_contenido.php" method="POST" enctype="multipart/form-data" class="form-contenido">

        <input type="hidden" name="seccion" value="historia">

        <label>Título:</label>
        <input type="text" name="titulo" value="<?= htmlspecialchars($data['titulo']) ?>" required>

        <label>Descripción:</label>
        <textarea name="descripcion" rows="6" required><?= htmlspecialchars($data['descripcion']) ?></textarea>

        <p>Imagen actual (opcional):</p>
        <?php if($data['imagen']): ?>
            <img src="/IMG/CONTENIDO/<?= $data['imagen'] ?>" class="preview-edit">
        <?php else: ?>
            <p><i>No hay imagen guardada</i></p>
        <?php endif; ?>

        <label>Subir nueva imagen (opcional):</label>
        <input type="file" name="imagen" accept="image/*">

        <button type="submit" class="btn-guardar">Guardar Cambios</button>
        <a href="index.php" class="btn-cancelar">Cancelar</a>
    </form>
</div>

<?php include_once __DIR__ . '/includes/footer.php'; ?>
