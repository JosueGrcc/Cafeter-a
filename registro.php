<?php
include 'conexion.php';

// Verificamos que los datos existan antes de usarlos
if (isset($_POST['email']) && isset($_POST['password'])) {
    
    $email = mysqli_real_escape_string($conexion, $_POST['email']);
    $pass  = $_POST['password']; // Aquí usamos 'password' que es lo que pusimos en el HTML

    $pass_encriptada = password_hash($pass, PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (email, password) VALUES ('$email', '$pass_encriptada')";

    if (mysqli_query($conexion, $sql)) {
        echo "¡Registro exitoso!";
    } else {
        echo "Error: " . mysqli_error($conexion);
    }
} else {
    echo "Por favor, rellena todos los campos.";
}
?>