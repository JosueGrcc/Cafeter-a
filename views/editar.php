<?php
include("../config/conexion.php");
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: index.php");
    exit();
}

$id = intval($_GET['id']);
$result = $conexion->query("SELECT p.*, c.nombre as cat_nombre FROM productos p JOIN categorias c ON p.categoria_id = c.id WHERE p.id = $id");
$row = $result->fetch_assoc();

$cats = $conexion->query("SELECT * FROM categorias ORDER BY nombre ASC")->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto — Octava Café</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <style>
        .pagina_editar {
            min-height: 100vh;
            background: var(--crema);
            display: flex;
            flex-direction: column;
        }
        .editar_container {
            width: 92%;
            max-width: 600px;
            margin: 40px auto 60px;
        }
        .editar_container h2 {
            font-family: 'Playfair Display', serif;
            color: var(--cafe-oscuro);
            margin-bottom: 24px;
            font-size: 1.4rem;
        }
        .preview_wrap {
            margin-top: 10px;
        }
        .preview_wrap img {
            height: 130px;
            border-radius: 10px;
            object-fit: cover;
            border: 2px solid var(--crema-oscura);
        }
    </style>
</head>
<body class="pagina_editar">

<header class="header">
    <span class="header-marca">OCTAVA <span>CAFÉ</span> <small class="header-sub">· EDITAR PRODUCTO</small></span>
    <div class="header-right">
        <a href="dashboard.php" class="btn_regresar">← Volver al panel</a>
    </div>
</header>

<div class="editar_container">
    <h2>✏️ Editando: <?php echo htmlspecialchars($row['nombre']); ?></h2>

    <div class="card">
        <div class="card-body open">
            <form action="../controllers/actualizar.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

                <div class="form_grid">
                    <div class="grupo">
                        <label>Nombre</label>
                        <input type="text" name="nombre" value="<?php echo htmlspecialchars($row['nombre']); ?>" required>
                    </div>
                    <div class="grupo">
                        <label>Precio ($)</label>
                        <input type="number" name="precio" step="0.01" value="<?php echo $row['precio']; ?>" required>
                    </div>
                    <div class="grupo full">
                        <label>Descripción</label>
                        <input type="text" name="descripcion" value="<?php echo htmlspecialchars($row['descripcion']); ?>" required>
                    </div>
                    <div class="grupo full">
                        <label>Categoría</label>
                        <div class="select-wrap">
                            <select name="categoria_id" required>
                                <?php foreach ($cats as $cat): ?>
                                    <option value="<?php echo $cat['id']; ?>" <?php echo $cat['id'] == $row['categoria_id'] ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($cat['nombre']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="grupo full">
                        <label>URL de imagen <span style="font-weight:400;text-transform:none;color:#b1a099;">(opcional)</span></label>
                        <input type="url" id="imagen" name="imagen"
                               value="<?php echo htmlspecialchars($row['imagen'] ?? ''); ?>"
                               placeholder="https://images.unsplash.com/...">
                        <div class="preview_wrap" id="preview_wrap" style="<?php echo !empty($row['imagen']) ? '' : 'display:none;'; ?>">
                            <img id="img_preview" src="<?php echo htmlspecialchars($row['imagen'] ?? ''); ?>" alt="Preview">
                        </div>
                    </div>
                    <div class="grupo full" style="align-items:flex-end;">
                        <button type="submit" class="btn_primario" style="width:100%;padding:13px;justify-content:center;">
                            💾 Guardar cambios
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('imagen').addEventListener('input', function() {
    const url = this.value.trim();
    const wrap = document.getElementById('preview_wrap');
    const img  = document.getElementById('img_preview');
    if (url.startsWith('http')) {
        img.src = url;
        wrap.style.display = 'block';
        img.onerror = () => { wrap.style.display = 'none'; };
    } else {
        wrap.style.display = 'none';
    }
});
</script>
</body>
</html>