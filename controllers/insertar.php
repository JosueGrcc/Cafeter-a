<?php
include("../config/conexion.php");

$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio'];
$categoria = $_POST['categoria_id'];

$sql = "INSERT INTO productos (nombre, descripcion, precio, categoria_id) VALUES (?, ?, ?, ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("ssdi", $nombre, $descripcion, $precio, $categoria);
$stmt->execute();

header("Location: ../views/dashboard.php");
?>