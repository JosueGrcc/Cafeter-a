<?php
include("../config/conexion.php");

header('Content-Type: application/json');

$nombre      = mysqli_real_escape_string($conexion, $_POST['nombre']);
$descripcion = mysqli_real_escape_string($conexion, $_POST['descripcion']);
$precio      = floatval($_POST['precio']);
$categoria   = intval($_POST['categoria_id']);

$sql  = "INSERT INTO productos (nombre, descripcion, precio, categoria_id) VALUES (?, ?, ?, ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("ssdi", $nombre, $descripcion, $precio, $categoria);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'id' => $conexion->insert_id]);
} else {
    echo json_encode(['success' => false, 'mensaje' => $conexion->error]);
}