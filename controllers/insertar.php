<?php
include("conexion.php");

$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio'];

$sql = "INSERT INTO productos (nombre, descripcion, precio) VALUES (?, ?, ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("ssd", $nombre, $descripcion, $precio);
$stmt->execute();

header("Location: dashboard.php");
?>