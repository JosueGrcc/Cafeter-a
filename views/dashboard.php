<?php
session_start();
include '../config/conexion.php';

if (!isset($_SESSION['usuario'])) {
    header("Location: ../views/login.html");
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
</head>

<body>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&family=Playfair+Display:wght@600&display=swap"
        rel="stylesheet">
    <div class="header">
        <h2>Bienvenido, <?php echo explode(" ", $_SESSION['usuario'])[0]; ?></h2>

        <div class="header-right">
            <a href="../views/index.php" class="btn-header inicio">Inicio</a>

            <div class="user-menu">
                <div class="user-info">
                    <div class="avatar">👤</div>
                    <span><?php echo explode(" ", $_SESSION['usuario'])[0]; ?></span>
                </div>

                <div class="dropdown">
                    <a href="../controllers/cuenta.php">Mi cuenta</a>
                    <a href="../controllers/logout.php">Cerrar sesión</a>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="card">
            <h3>Agregar producto</h3>

            <form action="../controllers/insertar.php" method="POST">
                <input type="text" name="nombre" placeholder="Nombre" required>
                <input type="text" name="descripcion" placeholder="Descripción" required>
                <input type="number" step="0.01" name="precio" placeholder="Precio" required>
                <div class="select-container">
                    <select name="categoria_id" required>
                        <option value="">Selecciona categoría</option>

                        <?php
                        $cats = $conexion->query("SELECT * FROM categorias");
                        while ($cat = $cats->fetch_assoc()) {
                            echo "<option value='{$cat['id']}'>{$cat['nombre']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <button type="submit">Guardar</button>
            </form>
        </div>
        <div class="card">

            <h3>Productos</h3>

            <table border="1">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Categoría</th>
                    <th>Acciones</th>
                </tr>


                <?php
                $result = $conexion->query("
        SELECT productos.*, categorias.nombre AS categoria_nombre
        FROM productos
        INNER JOIN categorias 
        ON productos.categoria_id = categorias.id ORDER BY productos.id ASC
        ");

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
        <td>{$row['id']}</td>
        <td>{$row['nombre']}</td>
        <td>{$row['descripcion']}</td>
        <td>{$row['precio']}</td>
        <td>{$row['categoria_nombre']}</td>
        <td>
            <a href='../views/editar.php?id={$row['id']}'>Editar</a>
            <a href='../controllers/eliminar.php?id={$row['id']}'>Eliminar</a>
        </td>
    </tr>";
                }
                ?>

            </table>
        </div>
    </div>
</body>

</html>