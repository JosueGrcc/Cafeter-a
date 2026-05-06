<?php
session_start();
include '../../config/conexion.php';

if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin' && isset($_POST['pedido_id'])) {
    $id = intval($_POST['pedido_id']);
    $estado = mysqli_real_escape_string($conexion, $_POST['nuevo_estado']);

    $stmt = $conexion->prepare("UPDATE pedidos SET estado = ? WHERE id = ?");
    $stmt->bind_param("si", $estado, $id);
    
    if ($stmt->execute()) {
        header("Location: ../../views/dashboard.php");
    } else {
        echo "Error: " . $conexion->error;
    }
} else {
    header("Location: ../../views/dashboard.php"); 
}
?>