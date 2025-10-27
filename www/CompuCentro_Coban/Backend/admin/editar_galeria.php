<?php
require_once __DIR__ . '/src/auth.php';
require_once __DIR__ . '/src/conexiondb.php';

$id = $_GET['id_foto'] ?? null;

$stmt = $pdo->prepare("SELECT * FROM galeria WHERE id_foto = ?");
$stmt->execute([$id]);
$foto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$foto) {
    die("Imagen no encontrada.");
}

include_once __DIR__ . '/includes/header.php';
include_once __DIR__ . '/includes/sidebar.php';
?>

<link rel="stylesheet" href="assets/css/galeria.css">

<div class="content">
    <h2 class="titulo-seccion">Editar Imagen de la Galería</h2>

    <form action="src/procesar_galeria.php" method="POST" enctype="multipart/form-data" class="form-upload">

        <input type="hidden" name="accion" value="editar">
        <input type="hidden" name="id_foto" value="<?= $foto['id_foto'] ?>">

        <div class="form-grid">

            <div class="form-group">
                <label>Título:</label>
                <input type="text" name="titulo" value="<?= htmlspecialchars($foto['titulo']) ?>" required>
            </div>

            <div class="form-group">
                <label>Descripción (opcional):</label>
                <textarea name="descripcion"><?= htmlspecialchars($foto['descripcion']) ?></textarea>
            </div>

            <div class="form-group">
                <label>Imagen actual:</label>
                <img src="/IMG/GALERIA/<?= htmlspecialchars($foto['imagen']) ?>" class="preview-img">
            </div>

            <div class="form-group">
                <label>Seleccionar nueva imagen (opcional):</label>
                <input type="file" name="imagen" accept="image/*">
            </div>

        </div>

        <div class="btn-group">
            <button type="submit" class="btn-guardar">Guardar Cambios</button>
            <a href="galeria.php" class="btn-cancelar">Cancelar</a>
        </div>
    </form>
</div>

<?php include_once __DIR__ . '/includes/footer.php'; ?>
