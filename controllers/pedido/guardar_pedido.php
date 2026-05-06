<?php
include '../../config/conexion.php'; 
session_start();

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode([
        'success' => false, 
        'error' => 'SESION_NO_INICIADA',
        'mensaje' => 'Debes iniciar sesión para realizar un pedido.'
    ]);
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

$datos = json_decode(file_get_contents('php://input'), true);

if (!$datos || empty($datos['items'])) {
    echo json_encode(['success' => false, 'error' => 'CARRITO_VACIO', 'mensaje' => 'El carrito está vacío.']);
    exit;
}

$total = $datos['total'];

mysqli_begin_transaction($conexion);

try {
    $query_pedido = "INSERT INTO pedidos (usuario_id, total) VALUES ($usuario_id, $total)";
    mysqli_query($conexion, $query_pedido);
    $pedido_id = mysqli_insert_id($conexion);

    foreach ($datos['items'] as $nombre => $item) {
        $precio = $item['precio'];
        $cantidad = $item['cantidad'];
        $subtotal = $precio * $cantidad;

        $query_detalle = "INSERT INTO detalles_pedido (pedido_id, producto_nombre, cantidad, precio_unitario, subtotal) 
                          VALUES ($pedido_id, '$nombre', $cantidad, $precio, $subtotal)";
        mysqli_query($conexion, $query_detalle);
    }

    mysqli_commit($conexion);
    echo json_encode(['success' => true, 'pedido_id' => $pedido_id]);

} catch (Exception $e) {
    mysqli_rollback($conexion);
    echo json_encode(['success' => false, 'error' => 'DB_ERROR', 'mensaje' => $e->getMessage()]);
}
?>