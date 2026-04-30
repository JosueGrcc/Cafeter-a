<?php
include '../config/conexion.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conexion, $_POST['email']);
    $password_ingresada = $_POST['password']; 

    $consulta = "SELECT * FROM usuarios WHERE email = '$email'";
    $resultado = mysqli_query($conexion, $consulta);

    if (mysqli_num_rows($resultado) > 0) {
        $usuario = mysqli_fetch_assoc($resultado);

        if (password_verify($password_ingresada, $usuario['contrasena'])) {
            // --- AQUÍ ESTÁ EL CAMBIO ---
            $_SESSION['usuario_id'] = $usuario['id']; // Guardamos el ID para los pedidos
            $_SESSION['usuario'] = $usuario['nombre']; // Guardamos el nombre para el saludo
            
            header("Location: ../views/index.php"); 
            exit();
        }
    }

    header("Location: ../views/login.html?error=password_incorrecto");
    exit();
}
?>