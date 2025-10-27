<?php
require_once __DIR__ . '/src/auth.php';
require_once __DIR__ . '/src/conexiondb.php';
include_once __DIR__ . '/includes/header.php';
include_once __DIR__ . '/includes/sidebar.php';

// Obtener imágenes
$stmt = $pdo->query("SELECT * FROM galeria ORDER BY fecha DESC");
$galeria = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<link rel="stylesheet" href="assets/css/galeria.css">

<div class="content">

    <h2 class="titulo-seccion">Galería - Administrar Imágenes</h2>

    <!-- Formulario para subir imágenes -->
    <form action="src/procesar_galeria.php" method="POST" enctype="multipart/form-data" class="form-upload">
        <input type="hidden" name="accion" value="agregar">
        
        <input type="text" name="titulo" placeholder="Título" required>
        <textarea name="descripcion" placeholder="Descripción (opcional)"></textarea>
        <input type="file" name="imagen" accept="image/*" required>

        <button type="submit" class="btn-guardar">+ Agregar Imagen</button>
    </form>

    <hr>

    <!-- Mostrar imágenes existentes -->
    <div class="galeria-grid">
        <?php if (count($galeria) === 0): ?>
            <p class="no-data">No hay imágenes registradas aún.</p>
        <?php endif; ?>

        <?php foreach ($galeria as $foto): ?>
        <div class="galeria-card">
                <img src="/IMG/GALERIA/<?= htmlspecialchars($foto['imagen']) ?>">

                <h4><?= htmlspecialchars($foto['titulo']) ?></h4>
                <p><?= htmlspecialchars($foto['descripcion']) ?></p>

                <form action="editar_galeria.php" method="GET">
                    <input type="hidden" name="id_foto" value="<?= $foto['id_foto'] ?>">
                    <button type="submit" class="btn-editar">Editar</button>
                </form>

                <form action="src/procesar_galeria.php" method="POST" onsubmit="return confirm('¿Eliminar esta imagen?')">
                    <input type="hidden" name="accion" value="eliminar">
                    <input type="hidden" name="id_foto" value="<?= $foto['id_foto'] ?>">
                    <button type="submit" class="btn-eliminar">Eliminar</button>
                </form>
        </div>

        <?php endforeach; ?>
    </div>

</div>

<?php include_once __DIR__ . '/includes/footer.php'; ?>
