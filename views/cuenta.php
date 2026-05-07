<?php
session_start();
include '../config/conexion.php';

if (!isset($_SESSION['usuario'])) {
    header("Location: ../views/login.html");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

// Obtener datos actuales del usuario
$query = "SELECT * FROM usuarios WHERE id = $usuario_id";
$resultado = mysqli_query($conexion, $query);
$usuario = mysqli_fetch_assoc($resultado);

// Mensajes de feedback
$mensaje_exito = '';
$mensaje_error  = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nuevo_nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $nuevo_email  = mysqli_real_escape_string($conexion, $_POST['email']);
    $nueva_pass   = $_POST['password'];
    $confirmar    = $_POST['confirmar_password'];

    // Verificar email duplicado (excluyendo al usuario actual)
    $check = mysqli_query($conexion, "SELECT id FROM usuarios WHERE email = '$nuevo_email' AND id != $usuario_id");
    if (mysqli_num_rows($check) > 0) {
        $mensaje_error = "Ese correo ya está en uso por otra cuenta.";
    } elseif (!empty($nueva_pass) && $nueva_pass !== $confirmar) {
        $mensaje_error = "Las contraseñas no coinciden.";
    } else {
        if (!empty($nueva_pass)) {
            $pass_hash = password_hash($nueva_pass, PASSWORD_DEFAULT);
            $sql = "UPDATE usuarios SET nombre='$nuevo_nombre', email='$nuevo_email', contrasena='$pass_hash' WHERE id=$usuario_id";
        } else {
            $sql = "UPDATE usuarios SET nombre='$nuevo_nombre', email='$nuevo_email' WHERE id=$usuario_id";
        }

        if (mysqli_query($conexion, $sql)) {
            $_SESSION['usuario'] = $nuevo_nombre;
            $mensaje_exito = "¡Datos actualizados correctamente!";
            // Recargar datos frescos
            $resultado = mysqli_query($conexion, "SELECT * FROM usuarios WHERE id = $usuario_id");
            $usuario   = mysqli_fetch_assoc($resultado);
        } else {
            $mensaje_error = "Error al actualizar: " . mysqli_error($conexion);
        }
    }
}

// Inicial del avatar
$inicial = strtoupper(substr($usuario['nombre'], 0, 1));
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Cuenta — Octava Café</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/mi_cuenta.css">

</head>
<body>

    <!-- HEADER -->
    <header class="header">
        <span class="header-marca">OCTAVA <span>CAFÉ</span></span>
        <a href="index.php" class="btn_regresar">← Volver al inicio</a>
    </header>

    <!-- CONTENIDO -->
    <main class="pagina">
        <div class="tarjeta_cuenta">

            <!-- Banner con avatar -->
            <div class="banner">
                <div class="avatar"><?php echo $inicial; ?></div>
                <h2><?php echo htmlspecialchars($usuario['nombre']); ?></h2>
                <p>Mi cuenta</p>
            </div>

            <!-- Formulario -->
            <div class="cuerpo_form">

                <?php if ($mensaje_exito): ?>
                    <div class="alerta alerta-exito">✓ <?php echo $mensaje_exito; ?></div>
                <?php endif; ?>

                <?php if ($mensaje_error): ?>
                    <div class="alerta alerta-error">✕ <?php echo $mensaje_error; ?></div>
                <?php endif; ?>

                <form method="POST">

                    <!-- Datos personales -->
                    <p class="subtitulo_seccion">Datos personales</p>

                    <div class="grupo">
                        <label for="nombre">Nombre completo</label>
                        <input type="text" id="nombre" name="nombre"
                               value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>
                    </div>

                    <div class="grupo">
                        <label for="email">Correo electrónico</label>
                        <input type="email" id="email" name="email"
                               value="<?php echo htmlspecialchars($usuario['email']); ?>" required>
                    </div>

                    <hr class="separador">

                    <!-- Cambiar contraseña -->
                    <p class="subtitulo_seccion">Cambiar contraseña</p>

                    <div class="grupo">
                        <label for="password">Nueva contraseña</label>
                        <input type="password" id="password" name="password"
                               placeholder="Dejar vacío para no cambiar">
                        <p class="hint">Solo rellena este campo si quieres cambiar tu contraseña.</p>
                    </div>

                    <div class="grupo">
                        <label for="confirmar_password">Confirmar nueva contraseña</label>
                        <input type="password" id="confirmar_password" name="confirmar_password"
                               placeholder="Repite la nueva contraseña">
                    </div>

                    <button type="submit" class="btn_guardar">Guardar cambios</button>
                </form>
            </div>

            <!-- Footer con link a pedidos -->
            <div class="footer_tarjeta">
                <a href="mis_pedidos.php">☕ Ver mis pedidos</a>
            </div>

        </div>
    </main>

</body>
</html>