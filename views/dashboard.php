<?php
session_start();
include '../config/conexion.php';

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: index.php");
    exit();
}

$nombre_admin  = $_SESSION['usuario'];
$inicial       = strtoupper(substr($nombre_admin, 0, 1));
$primer_nombre = explode(" ", $nombre_admin)[0];

$cats_result = $conexion->query("SELECT * FROM categorias ORDER BY nombre ASC");
$categorias  = $cats_result->fetch_all(MYSQLI_ASSOC);

$productos_result = $conexion->query("
    SELECT p.*, c.nombre AS categoria_nombre
    FROM productos p
    INNER JOIN categorias c ON p.categoria_id = c.id
    ORDER BY p.id ASC
");
$productos = $productos_result->fetch_all(MYSQLI_ASSOC);

$pedidos_result = $conexion->query("
    SELECT ped.*, u.nombre AS nombre_cliente
    FROM pedidos ped
    JOIN usuarios u ON ped.usuario_id = u.id
    ORDER BY ped.fecha DESC
");
$pedidos = $pedidos_result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control — Octava Café</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link rel="stylesheet" href="../assets/css/dashboard_extra.css">
</head>
<body>

<!-- ===== HEADER ===== -->
<header class="header">
    <span class="header-marca">
        OCTAVA <span>CAFÉ</span>
        <small class="header-sub">· PANEL ADMIN</small>
    </span>
    <div class="header-right">
        <a href="index.php" class="btn_regresar">← Volver al inicio</a>
        <div class="user-menu">
            <div class="user-info">
                <div class="avatar"><?php echo $inicial; ?></div>
                <span><?php echo $primer_nombre; ?></span>
            </div>
            <div class="dropdown">
                <a href="cuenta.php">Mi cuenta</a>
                <a href="../controllers/logout.php" class="btn_salir">Cerrar sesión</a>
            </div>
        </div>
    </div>
</header>

<!-- ===== TABS NAV ===== -->
<nav class="tabs_nav">
    <button class="tab_btn" data-tab="agregar" onclick="cambiarTab(this,'agregar')">
        <span class="tab_icon">➕</span> Agregar
    </button>
    <button class="tab_btn" data-tab="productos" onclick="cambiarTab(this,'productos')">
        <span class="tab_icon">📦</span> Productos
    </button>
    <button class="tab_btn" data-tab="pedidos" onclick="cambiarTab(this,'pedidos')">
        <span class="tab_icon">🧾</span> Pedidos
    </button>
    <!-- Tab editar: oculto hasta que se haga clic en Editar -->
    <button class="tab_btn" id="tab_btn_editar" data-tab="editar" onclick="cambiarTab(this,'editar')">
        <span class="tab_icon">✏️</span> Editando
    </button>
</nav>

<!-- ===== CONTENEDOR ===== -->
<div class="container">

    <!-- ===== BIENVENIDA (gato) ===== -->
    <div id="bienvenida" class="bienvenida">
        <svg class="gato_svg" viewBox="0 0 260 300" xmlns="http://www.w3.org/2000/svg">
            <!-- Orejas -->
            <polygon points="55,80 40,35 80,65"  fill="#6D4C41"/>
            <polygon points="205,80 220,35 180,65" fill="#6D4C41"/>
            <polygon points="57,76 46,48 76,67"  fill="#A1887F"/>
            <polygon points="203,76 214,48 184,67" fill="#A1887F"/>
            <!-- Cabeza -->
            <ellipse cx="130" cy="115" rx="75" ry="70" fill="#8D6E63"/>
            <!-- Ojos -->
            <ellipse cx="103" cy="105" rx="12" ry="14" fill="#3E2723"/>
            <ellipse cx="157" cy="105" rx="12" ry="14" fill="#3E2723"/>
            <circle cx="107" cy="101" r="4" fill="white"/>
            <circle cx="161" cy="101" r="4" fill="white"/>
            <!-- Nariz -->
            <ellipse cx="130" cy="128" rx="6" ry="4" fill="#C67D53"/>
            <!-- Bigotes -->
            <line x1="80"  y1="125" x2="118" y2="130" stroke="#3E2723" stroke-width="1.5" stroke-linecap="round"/>
            <line x1="80"  y1="132" x2="118" y2="132" stroke="#3E2723" stroke-width="1.5" stroke-linecap="round"/>
            <line x1="142" y1="130" x2="180" y2="125" stroke="#3E2723" stroke-width="1.5" stroke-linecap="round"/>
            <line x1="142" y1="132" x2="180" y2="132" stroke="#3E2723" stroke-width="1.5" stroke-linecap="round"/>
            <!-- Boca -->
            <path d="M122 138 Q130 146 138 138" fill="none" stroke="#3E2723" stroke-width="1.8" stroke-linecap="round"/>
            <!-- Cuerpo -->
            <ellipse cx="130" cy="235" rx="68" ry="60" fill="#8D6E63"/>
            <!-- Brazos sujetando la taza -->
            <ellipse cx="67"  cy="222" rx="22" ry="13" fill="#8D6E63" transform="rotate(-25 67 222)"/>
            <ellipse cx="193" cy="222" rx="22" ry="13" fill="#8D6E63" transform="rotate(25 193 222)"/>
            <ellipse cx="54"  cy="234" rx="13" ry="10" fill="#A1887F"/>
            <ellipse cx="206" cy="234" rx="13" ry="10" fill="#A1887F"/>
            <!-- Taza -->
            <rect x="93" y="228" width="74" height="52" rx="9" fill="#FDFBF7" stroke="#C67D53" stroke-width="2.5"/>
            <path d="M167 239 Q190 253 167 268" fill="none" stroke="#C67D53" stroke-width="3.5" stroke-linecap="round"/>
            <rect x="99" y="234" width="62" height="22" rx="5" fill="#6D4C41"/>
            <!-- Platito -->
            <ellipse cx="130" cy="281" rx="48" ry="7" fill="#E0D6CC"/>
            <!-- Vapor animado -->
            <path d="M112 222 Q116 212 112 203" fill="none" stroke="#C8A27C" stroke-width="2.2" stroke-linecap="round">
                <animate attributeName="d" values="M112 222 Q116 212 112 203;M112 222 Q108 212 112 203;M112 222 Q116 212 112 203" dur="2s" repeatCount="indefinite"/>
                <animate attributeName="opacity" values="0.8;0.1;0.8" dur="2s" repeatCount="indefinite"/>
            </path>
            <path d="M130 218 Q134 206 130 197" fill="none" stroke="#C8A27C" stroke-width="2.2" stroke-linecap="round">
                <animate attributeName="d" values="M130 218 Q134 206 130 197;M130 218 Q126 206 130 197;M130 218 Q134 206 130 197" dur="2.5s" repeatCount="indefinite"/>
                <animate attributeName="opacity" values="0.6;0.1;0.6" dur="2.5s" repeatCount="indefinite"/>
            </path>
            <path d="M148 222 Q144 212 148 203" fill="none" stroke="#C8A27C" stroke-width="2.2" stroke-linecap="round">
                <animate attributeName="d" values="M148 222 Q144 212 148 203;M148 222 Q152 212 148 203;M148 222 Q144 212 148 203" dur="1.8s" repeatCount="indefinite"/>
                <animate attributeName="opacity" values="0.7;0.1;0.7" dur="1.8s" repeatCount="indefinite"/>
            </path>
            <!-- Cola -->
            <path d="M188 268 Q235 252 224 216 Q218 196 202 207" fill="none" stroke="#8D6E63" stroke-width="15" stroke-linecap="round"/>
            <path d="M188 268 Q235 252 224 216 Q218 196 202 207" fill="none" stroke="#A1887F" stroke-width="7"  stroke-linecap="round"/>
        </svg>
        <h2 class="bienvenida_titulo">¡Hola, <?php echo $primer_nombre; ?>! ☕</h2>
        <p class="bienvenida_sub">Selecciona una pestaña para gestionar tu cafetería</p>
    </div>

    <!-- ========== PANEL AGREGAR ========== -->
    <div id="panel_agregar" class="panel">
        <div class="card">
            <div class="card-titulo"><h3>➕ Agregar nuevo producto</h3></div>
            <div class="card-body open">
                <form id="form_agregar" action="../controllers/insertar.php" method="POST"
                      onsubmit="confirmarGuardarProducto(event)">
                    <div class="form_grid">
                        <div class="grupo">
                            <label for="nombre">Nombre</label>
                            <input type="text" id="nombre" name="nombre" placeholder="Ej. Cappuccino" required>
                        </div>
                        <div class="grupo">
                            <label for="precio">Precio ($)</label>
                            <input type="number" id="precio" name="precio" step="0.01" placeholder="0.00" required>
                        </div>
                        <div class="grupo full">
                            <label for="descripcion">Descripción</label>
                            <input type="text" id="descripcion" name="descripcion" placeholder="Describe el producto..." required>
                        </div>
                        <div class="grupo">
                            <label for="categoria_id">Categoría</label>
                            <div class="select-wrap">
                                <select id="categoria_id" name="categoria_id" required>
                                    <option value="">Selecciona una categoría</option>
                                    <?php foreach ($categorias as $cat): ?>
                                        <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['nombre']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="grupo" style="justify-content:flex-end;">
                            <label>&nbsp;</label>
                            <button type="submit" class="btn_primario" style="height:44px;">💾 Guardar producto</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ========== PANEL PRODUCTOS ========== -->
    <div id="panel_productos" class="panel">
        <div class="card">
            <div class="card-titulo">
                <h3>📋 Lista de productos <span id="count_productos" class="contador"></span></h3>
            </div>
            <div class="card-body open">
                <div class="toolbar">
                    <input type="text" class="buscador_input" id="buscar_productos"
                           placeholder="🔍 Buscar por nombre o descripción..."
                           oninput="filtrarProductos()">
                    <div class="select-wrap">
                        <select class="filtro_select" id="filtro_cat" onchange="filtrarProductos()">
                            <option value="">Todas las categorías</option>
                            <?php foreach ($categorias as $cat): ?>
                                <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['nombre']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <p class="resultados_count" id="msg_productos"></p>
                <div class="tabla-wrap">
                    <table id="tabla_productos">
                        <thead>
                            <tr>
                                <th>ID</th><th>Nombre</th><th>Descripción</th>
                                <th>Precio</th><th>Categoría</th><th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($productos as $p): ?>
                            <tr data-id="<?php echo $p['id']; ?>"
                                data-nombre="<?php echo strtolower(htmlspecialchars($p['nombre'])); ?>"
                                data-desc="<?php echo strtolower(htmlspecialchars($p['descripcion'])); ?>"
                                data-cat="<?php echo $p['categoria_id']; ?>">
                                <td>#<?php echo $p['id']; ?></td>
                                <td><strong><?php echo htmlspecialchars($p['nombre']); ?></strong></td>
                                <td><?php echo htmlspecialchars($p['descripcion']); ?></td>
                                <td>$<?php echo number_format($p['precio'], 2); ?></td>
                                <td><?php echo htmlspecialchars($p['categoria_nombre']); ?></td>
                                <td>
                                    <div class="td-acciones">
                                        <button class="btn_accion btn-edit"
                                            onclick="abrirEditar(
                                                <?php echo $p['id']; ?>,
                                                '<?php echo addslashes(htmlspecialchars($p['nombre'])); ?>',
                                                '<?php echo addslashes(htmlspecialchars($p['descripcion'])); ?>',
                                                <?php echo $p['precio']; ?>,
                                                <?php echo $p['categoria_id']; ?>
                                            )">✏️ Editar</button>
                                        <button class="btn_accion btn-delete"
                                            onclick="confirmarEliminar(<?php echo $p['id']; ?>, '<?php echo addslashes(htmlspecialchars($p['nombre'])); ?>')">
                                            🗑️ Eliminar
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="empty-msg" id="empty_productos" style="display:none;">
                        No se encontraron productos con ese criterio.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ========== PANEL EDITAR (temporal) ========== -->
    <div id="panel_editar" class="panel">
        <div class="card">
            <div class="card-titulo">
                <h3>✏️ Editar producto</h3>
            </div>
            <div class="card-body open">
                <form id="form_editar" action="../controllers/actualizar.php" method="POST"
                      onsubmit="confirmarEditarProducto(event)">
                    <input type="hidden" id="edit_id" name="id">
                    <div class="form_grid">
                        <div class="grupo">
                            <label for="edit_nombre">Nombre</label>
                            <input type="text" id="edit_nombre" name="nombre" placeholder="Nombre del producto" required>
                        </div>
                        <div class="grupo">
                            <label for="edit_precio">Precio ($)</label>
                            <input type="number" id="edit_precio" name="precio" step="0.01" placeholder="0.00" required>
                        </div>
                        <div class="grupo full">
                            <label for="edit_descripcion">Descripción</label>
                            <input type="text" id="edit_descripcion" name="descripcion" placeholder="Descripción..." required>
                        </div>
                        <div class="grupo">
                            <label for="edit_categoria_id">Categoría</label>
                            <div class="select-wrap">
                                <select id="edit_categoria_id" name="categoria_id" required>
                                    <option value="">Selecciona una categoría</option>
                                    <?php foreach ($categorias as $cat): ?>
                                        <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['nombre']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="grupo" style="justify-content:flex-end; gap:10px; flex-direction:row; align-items:flex-end;">
                            <button type="button" class="btn_cancelar_edicion" onclick="cerrarEditar()">✕ Cancelar</button>
                            <button type="submit" class="btn_primario" style="height:44px;">✏️ Guardar cambios</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ========== PANEL PEDIDOS ========== -->
    <div id="panel_pedidos" class="panel">
        <div class="card">
            <div class="card-titulo">
                <h3>🧾 Pedidos de clientes <span id="count_pedidos" class="contador"></span></h3>
            </div>
            <div class="card-body open">
                <div class="toolbar">
                    <input type="text" class="buscador_input" id="buscar_pedidos"
                           placeholder="🔍 Buscar por cliente o ID..."
                           oninput="filtrarPedidos()">
                    <div class="select-wrap">
                        <select class="filtro_select" id="filtro_estado" onchange="filtrarPedidos()">
                            <option value="">Todos los estados</option>
                            <option value="pendiente">Pendiente</option>
                            <option value="en_proceso">En proceso</option>
                            <option value="entregado">Entregado</option>
                            <option value="cancelado">Cancelado</option>
                        </select>
                    </div>
                </div>
                <p class="resultados_count" id="msg_pedidos"></p>
                <div class="tabla-wrap">
                    <table id="tabla_pedidos">
                        <thead>
                            <tr>
                                <th>ID</th><th>Cliente</th><th>Fecha</th>
                                <th>Total</th><th>Estado</th><th>Cambiar estado</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($pedidos as $ped):
                            $estado = $ped['estado'] ?? 'pendiente';
                        ?>
                            <tr data-cliente="<?php echo strtolower(htmlspecialchars($ped['nombre_cliente'])); ?>"
                                data-id="<?php echo $ped['id']; ?>"
                                data-estado="<?php echo $estado; ?>">
                                <td><strong>#<?php echo $ped['id']; ?></strong></td>
                                <td><?php echo htmlspecialchars($ped['nombre_cliente']); ?></td>
                                <td><?php echo date('d/m/Y H:i', strtotime($ped['fecha'])); ?></td>
                                <td>$<?php echo number_format($ped['total'], 2); ?></td>
                                <td>
                                    <span class="badge badge-<?php echo $estado; ?>">
                                        <?php echo ucfirst(str_replace('_',' ',$estado)); ?>
                                    </span>
                                </td>
                                <td>
                                    <form action="../controllers/pedido/actualizar_estado.php" method="POST"
                                          style="display:flex;gap:8px;align-items:center;"
                                          onsubmit="confirmarCambioEstado(event, this)">
                                        <input type="hidden" name="pedido_id" value="<?php echo $ped['id']; ?>">
                                        <div class="select-wrap">
                                            <select name="nuevo_estado" class="select-estado">
                                                <option value="pendiente"  <?php echo $estado==='pendiente'  ?'selected':'';?>>Pendiente</option>
                                                <option value="en_proceso" <?php echo $estado==='en_proceso' ?'selected':'';?>>En proceso</option>
                                                <option value="entregado"  <?php echo $estado==='entregado'  ?'selected':'';?>>Entregado</option>
                                                <option value="cancelado"  <?php echo $estado==='cancelado'  ?'selected':'';?>>Cancelado</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn_accion btn-save">✓ Guardar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="empty-msg" id="empty_pedidos" style="display:none;">
                        No se encontraron pedidos con ese criterio.
                    </div>
                </div>
            </div>
        </div>
    </div>

</div><!-- /container -->

<script src="../assets/js/dashboard.js"></script>
</body>
</html>