<?php
include '../config/conexion.php'; 
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.html");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

$query = "SELECT * FROM pedidos WHERE usuario_id = $usuario_id ORDER BY fecha DESC";
$resultado = mysqli_query($conexion, $query);

if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conexion));
}

$estados_label = [
    'pendiente'  => 'PENDIENTE',
    'en_proceso' => 'EN PROCESO',
    'entregado'  => 'ENTREGADO',
    'cancelado'  => 'CANCELADO',
];

$primer_nombre = isset($_SESSION['usuario']) ? explode(" ", $_SESSION['usuario'])[0] : '';
$inicial       = isset($_SESSION['usuario']) ? strtoupper(substr($_SESSION['usuario'], 0, 1)) : '?';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Pedidos - Octava Café</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Montserrat:wght@400;500;600;700&family=Pangolin&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/estilo_pedidos.css">
</head>
<body>

    <header class="header">
        <span class="header-marca">OCTAVA <span>CAFÉ</span></span>
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
                        <a href="productos.php">Ver Menú</a>
                        <a href="../controllers/logout.php" class="btn_salir">Cerrar Sesión</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </header>

    <main class="contenedor_pedidos">
        <header class="encabezado_seccion">
            <h1 class="titulo_pedidos">Tu Historial de Antojos</h1>
        </header>

        <section class="lista_pedidos">
            <?php 
            if (mysqli_num_rows($resultado) > 0):
                while ($fila = mysqli_fetch_assoc($resultado)):
                    $estado    = $fila['estado'] ?? 'pendiente';
                    $label     = $estados_label[$estado] ?? strtoupper($estado);
                    $fecha_fmt = date('d/m/Y H:i', strtotime($fila['fecha']));
            ?>
                <article class="tarjeta_pedido estado-<?php echo $estado; ?>">
                    <div class="cuerpo_pedido">
                        <div class="info_texto">
                            <span class="id_pedido">ID: #TC-<?php echo $fila['id']; ?></span>
                            <p class="detalles">Pedido realizado con éxito</p>
                            <span class="fecha"><?php echo $fecha_fmt; ?></span>
                        </div>
                        <div class="info_pago">
                            <span class="etiqueta_estado estado-badge-<?php echo $estado; ?>"><?php echo $label; ?></span>
                            <p class="precio">$<?php echo number_format($fila['total'], 2); ?></p>
                        </div>
                    </div>
                </article>
            <?php 
                endwhile;
            else:
            ?>
                <p style="text-align:center; margin-top: 40px;">Aún no has realizado pedidos. ¡Ve por un café!</p>
            <?php endif; ?>
        </section>
    </main>

</body>
</html>