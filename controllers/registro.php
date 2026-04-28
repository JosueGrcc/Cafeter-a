<?php
include '../config/conexion.php';

if (isset($_POST['nombre']) && isset($_POST['email']) && isset($_POST['password'])) {
    
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $email = mysqli_real_escape_string($conexion, $_POST['email']);
    $pass  = $_POST['password']; 

    // --- PASO NUEVO: Verificar si el correo ya existe ---
    $verificar_correo = "SELECT * FROM usuarios WHERE email = '$email'";
    $resultado = mysqli_query($conexion, $verificar_correo);

    if (mysqli_num_rows($resultado) > 0) {
        // Si el correo ya existe, mandamos un aviso al registro
        header("Location: ../views/registro.html?error=email_existente");
        exit();
    } else {
        // Si no existe, procedemos al registro normal
        $pass_encriptada = password_hash($pass, PASSWORD_DEFAULT);
        $sql = "INSERT INTO usuarios (nombre, email, contrasena) VALUES ('$nombre', '$email', '$pass_encriptada')";

        if (mysqli_query($conexion, $sql)) {
            header("Location: ../views/login.html?registro=exitoso");
            exit();
        } else {
            echo "Error: " . mysqli_error($conexion);
        }
    }
} else {
    echo "Por favor, rellena todos los campos.";
}
?>