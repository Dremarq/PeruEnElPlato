<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <link rel="stylesheet" href="../public/styles/admi.css">
    <title>Interfaz de Administrador</title>
 
</head>

<body>
    <div class="container">
        <nav class="sidebar">
            <h2>Pantalla de Administrador</h2>
            <ul>
                <li><a href="#">Dashboard - Administrador</a></li>
                <li><a href="../vista/almacen.php">Almacen</a></li>
                <li><a href="../vista/detalle_pedido.php">Detalle Pedido</a></li>
                <li><a href="../vista/empleados.php">Empleados</a></li>
                <li><a href="../vista/pedidos.php">Pedidos</a></li>
                <li><a href="../vista/productos.php">Productos</a></li>
                <li><a href="../vista/proveedores.php">Proveedores</a></li>
                <li><a href="../vista/reservas.php">Reserva</a></li>
                <li><a href="../vista/roles.php">Roles</a></li>
                <li><a href="../vista/usuario.php">Usuarios</a></li>
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