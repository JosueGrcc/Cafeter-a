<?php include '../config/conexion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú - Octava Café</title>
    <link rel="stylesheet" href="../assets/css/estilo_productos.css">
</head>
<body>
    <header class="header_menu">
        <h1>OCTAVA CAFÉ</h1>
        <p>Selecciona tus favoritos y haz tu pedido</p>
    </header>

    <div class="contenedor_principal">
        <aside class="barra_lateral">
            <h3>Categorías</h3>
            <button class="btn_cat active" onclick="filtrar('todas')">Todo el Menú</button>
            <?php
            $sql_cat = "SELECT * FROM categorias";
            $res_cat = mysqli_query($conexion, $sql_cat);
            while($cat = mysqli_fetch_assoc($res_cat)) {
                echo "<button class='btn_cat' onclick=\"filtrar('cat-{$cat['id']}')\">{$cat['nombre']}</button>";
            }
            ?>
        </aside>

        <main class="grid_productos">
            <?php
            $sql_prod = "SELECT p.*, c.nombre as cat_nombre FROM productos p 
                         JOIN categorias c ON p.categoria_id = c.id";
            $res_prod = mysqli_query($conexion, $sql_prod);

            while($prod = mysqli_fetch_assoc($res_prod)) {
            ?>
                <div class="tarjeta_producto cat-<?php echo $prod['categoria_id']; ?>">
                    <div class="info_producto">
                        <h3><?php echo $prod['nombre']; ?></h3>
                        <p class="descripcion"><?php echo $prod['descripcion']; ?></p>
                        <span class="precio">$<?php echo number_format($prod['precio'], 2); ?></span>
                    </div>
                    <button class="btn_agregar" 
                            onclick="agregarAlCarrito('<?php echo $prod['nombre']; ?>', <?php echo $prod['precio']; ?>)">
                        + Agregar
                    </button>
                </div>
            <?php } ?>
        </main>
    </div>

    <div class="barra_pedido">
        <div class="info_carrito">
            <strong>Tu Pedido:</strong>
            <span id="lista_items">Vacío</span>
        </div>
        <div class="total_accion">
            <span class="total_texto">Total: $<span id="total_pago">0.00</span></span>
            <button class="btn_confirmar">Solicitar Pedido</button>
        </div>
    </div>

    <script src="../script_menu.js"></script>
</body>
</html>