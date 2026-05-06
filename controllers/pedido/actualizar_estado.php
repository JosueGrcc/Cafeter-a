<?php
include '../../config/conexion.php';
session_start();

if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin' && isset($_POST['pedido_id'])) {
    $id = $_POST['pedido_id'];
    $estado = $_POST['nuevo_estado'];

    $stmt = $conexion->prepare("UPDATE pedidos SET estado = ? WHERE id = ?");
    $stmt->bind_param("si", $estado, $id);
    
    if ($stmt->execute()) {
        header("Location: ../views/dashboard.php");
    } else {
        echo "Error: " . $conexion->error;
    }
}
?>