<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../views/login.html");
}
?>

<h2>Mi cuenta</h2>
<p>Usuario: <?php echo $_SESSION['usuario']; ?></p>

<a href="../views/dashboard.php">Volver</a>