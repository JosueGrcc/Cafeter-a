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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Pedidos - Octava Café</title>
    <link rel="stylesheet" href="../assets/css/estilo_pedidos.css">
    <link href="https://fonts.googleapis.com/css2?family=Pangolin&display=swap" rel="stylesheet">
</head>
<body>
    <main class="contenedor_pedidos">
        <header class="encabezado_seccion">
            <h1 class="titulo_pedidos">Tu Historial de Antojos</h1>
        </header>

        <section class="lista_pedidos">
            <?php 
            // 4. Ahora sí, el ciclo funcionará porque $resultado ya tiene datos
            if (mysqli_num_rows($resultado) > 0): 
                while($fila = mysqli_fetch_assoc($resultado)): 
            ?>
                <article class="tarjeta_pedido estado-entregado">
                    <div class="cuerpo_pedido">
                        <div class="info_texto">
                            <span class="id_pedido">ID: #TC-<?php echo $fila['id']; ?></span>
                            <p class="detalles">Pedido realizado con éxito</p>
                            <span class="fecha"><?php echo $fila['fecha']; ?></span>
                        </div>
                        <div class="info_pago">
                            <span class="etiqueta_estado">COMPLETADO</span>
                            <p class="precio">$<?php echo number_format($fila['total'], 2); ?></p>
                        </div>
                    </div>
                </article>
            <?php 
                endwhile; 
            else: 
            ?>
                <p style="text-align:center;">Aún no has realizado pedidos. ¡Ve por un café!</p>
            <?php endif; ?>
        </section>

        <div style="text-align: center; margin-top: 30px;">
            <a href="index.php" style="text-decoration: none; color: #8D6E63; font-weight: 700;">← Volver al inicio</a>
        </div>
    </main>
</body>
</html>