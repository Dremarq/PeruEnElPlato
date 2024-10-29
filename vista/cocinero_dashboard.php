
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/styles/admi.css">
    <title>Interfaz de Administrador</title>
</head>

<body>
    <div class="container">
        <nav class="sidebar">
            <h2>Pantalla de Administrador</h2>
            <ul>
                <li><a href="#">Dashboard - Cocinero</a></li>
                <li><a href="../vista/almacen.php">Almacen</a></li>
                <li><a href="../vista/detalle_pedido.php">Detalle Pedido</a></li>
                <li><a href="../vista/empleados.php">Empleados</a></li>
                <li><a href="../vista/pedidos.php">Pedidos</a></li>
                <li><a href="../vista/productos.php">Productos</a></li>
                <li><a href="../vista/proveedores.php">Proveedores</a></li>
                <li><a href="../vista/reservas.php">Reserva</a></li>
                <li><a href="../vista/roles.php">Roles</a></li>
                <li><a href="../vista/usuarios.php">Usuarios</a></li>
            </ul>
        </nav>
        <main class="content">
            <h1>Bienvenido al Panel de Administración</h1>
            <p>Selecciona una opción del menú para comenzar.</p>
            <a href="../controlador/logout.php" class="btn btn-danger">Cerrar Sesión</a> <!-- Botón de cierre de sesión -->
        </main> <!-- Cierre del main -->
    </div> <!-- Cierre del container -->
</body>

</html>
