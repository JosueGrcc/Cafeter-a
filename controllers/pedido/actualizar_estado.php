<?php
session_start();
include '../../config/conexion.php';

header('Content-Type: application/json');

if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin' && isset($_POST['pedido_id'])) {
    $id     = intval($_POST['pedido_id']);
    $estado = mysqli_real_escape_string($conexion, $_POST['nuevo_estado']);

    $stmt = $conexion->prepare("UPDATE pedidos SET estado = ? WHERE id = ?");
    $stmt->bind_param("si", $estado, $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'mensaje' => $conexion->error]);
    }
} else {
    echo json_encode(['success' => false, 'mensaje' => 'No autorizado.']);
}