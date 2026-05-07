<?php
include("../config/conexion.php");

$nombre      = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$precio      = $_POST['precio'];
$categoria   = $_POST['categoria_id'];
$imagen      = isset($_POST['imagen']) ? trim($_POST['imagen']) : '';

$sql = "INSERT INTO productos (nombre, descripcion, precio, categoria_id, imagen) VALUES (?, ?, ?, ?, ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("ssdis", $nombre, $descripcion, $precio, $categoria, $imagen);
$stmt->execute();

header("Location: ../views/dashboard.php");
?>