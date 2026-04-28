<?php
include("../config/conexion.php");

$id = $_GET['id'];

$conexion->query("DELETE FROM productos WHERE id = $id");

header("Location: ../views/dashboard.php");
?>