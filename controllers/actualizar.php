<?php
include("../config/conexion.php");

$id          = $_POST['id'];
$nombre      = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$precio      = $_POST['precio'];
$imagen      = isset($_POST['imagen']) ? trim($_POST['imagen']) : '';

$sql = "UPDATE productos SET nombre=?, descripcion=?, precio=?, imagen=? WHERE id=?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("ssdsi", $nombre, $descripcion, $precio, $imagen, $id);
$stmt->execute();

header("Location: ../views/dashboard.php");
?>