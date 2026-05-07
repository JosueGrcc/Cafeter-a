<?php
include("../config/conexion.php");

header('Content-Type: application/json');

$id          = intval($_POST['id']);
$nombre      = mysqli_real_escape_string($conexion, $_POST['nombre']);
$descripcion = mysqli_real_escape_string($conexion, $_POST['descripcion']);
$precio      = floatval($_POST['precio']);
$categoria   = intval($_POST['categoria_id']);

$sql  = "UPDATE productos SET nombre=?, descripcion=?, precio=?, categoria_id=? WHERE id=?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("ssdii", $nombre, $descripcion, $precio, $categoria, $id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'mensaje' => $conexion->error]);
}