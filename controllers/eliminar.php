<?php
include("../config/conexion.php");

$id = intval($_GET['id']);

if (isset($_GET['ajax'])) {
    header('Content-Type: application/json');
    if ($conexion->query("DELETE FROM productos WHERE id = $id")) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'mensaje' => $conexion->error]);
    }
    exit;
}

// Fallback sin AJAX
$conexion->query("DELETE FROM productos WHERE id = $id");
header("Location: ../views/dashboard.php");