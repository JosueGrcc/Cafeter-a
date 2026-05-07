<?php 
session_start();

if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin') {
    header("Location: dashboard.php");
    exit();
}

include '../config/conexion.php';

$primer_nombre = isset($_SESSION['usuario']) ? explode(" ", $_SESSION['usuario'])[0] : '';
$inicial       = isset($_SESSION['usuario']) ? strtoupper(substr($_SESSION['usuario'], 0, 1)) : '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú - Octava Café</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/estilo_productos.css?v=<?php echo time(); ?>">
</head>
<body>

    <header class="header">
        <span class="header-marca">OCTAVA <span>CAFÉ</span>
            <small class="header-sub">· MENÚ</small>
        </span>
        <div class="header-right">
            <a href="index.php" class="btn_regresar">← Volver al inicio</a>

            <?php if (isset($_SESSION['usuario'])): ?>
                <div class="user-menu">
                    <div class="user-info">
                        <div class="avatar-sm"><?php echo $inicial; ?></div>
                        <span><?php echo $primer_nombre; ?></span>
                    </div>
                    <div class="header-dropdown">
                        <a href="cuenta.php">Mi Cuenta</a>
                        <a href="mis_pedidos.php">Mis Pedidos</a>
                        <a href="../controllers/logout.php" class="btn_salir">Cerrar Sesión</a>
                    </div>
                </div>
            <?php else: ?>
                <a href="login.html" class="btn_login_header">Iniciar Sesión</a>
            <?php endif; ?>
        </div>
    </header>

    <div class="contenedor_principal">
        <aside class="barra_lateral">
            <h3>Categorías</h3>
            <button class="btn_cat active" onclick="filtrar('todas')">Todo el Menú</button>
            <?php
            $sql_cat = "SELECT * FROM categorias";
            $res_cat = mysqli_query($conexion, $sql_cat);
            while ($cat = mysqli_fetch_assoc($res_cat)) {
                echo "<button class='btn_cat' onclick=\"filtrar('cat-{$cat['id']}')\">{$cat['nombre']}</button>";
            }
            ?>
        </aside>

        <div class="area_principal">
            <input type="text" id="buscador_productos" class="buscador_input"
                placeholder="Buscar en esta categoría..."
                onkeyup="aplicarFiltros()">

            <main class="grid_productos">
                <?php
                $sql_prod = "SELECT p.*, c.nombre as cat_nombre FROM productos p 
                             JOIN categorias c ON p.categoria_id = c.id";
                $res_prod = mysqli_query($conexion, $sql_prod);
                while ($prod = mysqli_fetch_assoc($res_prod)):
                ?>
                    <div class="tarjeta_producto cat-<?php echo $prod['categoria_id']; ?>">
                        <div class="info_producto">
                            <h3><?php echo $prod['nombre']; ?></h3>
                            <p class="descripcion"><?php echo $prod['descripcion']; ?></p>
                            <span class="precio">$<?php echo number_format($prod['precio'], 2); ?></span>
                        </div>
                        <button class="btn_agregar"
                            onclick="agregarAlCarrito('<?php echo addslashes($prod['nombre']); ?>', <?php echo $prod['precio']; ?>)">
                            + Agregar
                        </button>
                    </div>
                <?php endwhile; ?>
            </main>
        </div>
    </div>

    <div class="barra_pedido">
        <div class="info_carrito">
            <strong>Tu Pedido:</strong>
            <span id="lista_items">Vacío</span>
        </div>
        <div class="total_accion">
            <span class="total_texto">Total: $<span id="total_pago">0.00</span></span>
            <button class="btn_confirmar" onclick="abrirCarrito()">Ver Pedido</button>
        </div>
    </div>

    <div id="modal_carrito" class="modal_oculto">
        <div class="contenido_modal">
            <div class="header_modal">
                <h2>Detalle de tu Pedido</h2>
                <button class="btn_cerrar" onclick="cerrarCarrito()">X</button>
            </div>
            <div id="lista_carrito_detalles"></div>
            <div class="footer_modal">
                <h3>Total: $<span id="modal_total">0.00</span></h3>
                <button class="btn_confirmar" onclick="enviarPedido()">Confirmar Pedido</button>
            </div>
        </div>
    </div>

    <script src="../script_menu.js"></script>
</body>
</html>