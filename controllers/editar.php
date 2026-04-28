<?php
include("conexion.php");

$id = $_GET['id'];
$result = $conexion->query("SELECT * FROM productos WHERE id = $id");
$row = $result->fetch_assoc();
?>

<form action="actualizar.php" method="POST">
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
    <input type="text" name="nombre" value="<?php echo $row['nombre']; ?>">
    <input type="text" name="descripcion" value="<?php echo $row['descripcion']; ?>">
    <input type="number" step="0.01" name="precio" value="<?php echo $row['precio']; ?>">
    <button>Actualizar</button>
</form>