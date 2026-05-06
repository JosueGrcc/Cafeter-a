<?php
include '../../config/conexion.php'; 
session_start();


if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.html");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];


$query = "SELECT * FROM pedidos WHERE usuario_id = $usuario_id ORDER BY fecha DESC";
$resultado = mysqli_query($conexion, $query);
?>