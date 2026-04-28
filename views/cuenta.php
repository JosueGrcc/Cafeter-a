<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.html");
}
?>

<h2>Mi cuenta</h2>
<p>Usuario: <?php echo $_SESSION['usuario']; ?></p>

<a href="dashboard.php">Volver</a>