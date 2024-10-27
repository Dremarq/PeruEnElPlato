<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/styles/admi.css">
    <link rel="stylesheet" href="../public/styles/tablas.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/191a90e971.js" crossorigin="anonymous"></script>
    <title>Interfaz de Administrador - Almacen</title>
</head>
<body>
    <script>
        function eliminarProducto() {
            return confirm("¿Estás seguro que deseas eliminar este producto?");
        }
    </script>

    <!-- Menú lateral -->
    <nav class="sidebar">
        <h2>Pantalla de Administrador</h2>
        <ul>
            <li><a href="../vista/admin_dashboard.php">Dashboard - Perú en el plato</a></li>
            <li><a href="">Almacen</a></li>
            <li><a href="../vista/detalle_pedido.php">Detalle Pedido</a></li>
            <li><a href="../vista/empleados.php">Empleados</a></li>
            <li><a href="../vista/pedidos.php">Pedidos</a></li>
            <li><a href="../vista/productos.php">Productos</a></li>
            <li><a href="../vista/proveedores.php">Proveedores</a></li>
            <li><a href="../vista/reservas.php">Reservas</a></li>
            <li><a href="../vista/roles.php">Roles</a></li>
            <li><a href="../vista/usuarios.php">Usuarios</a></li>
        </ul>
    </nav>

    <!-- Contenido principal -->
    <div class="main-content">
        <h2>Registro de Almacen</h2>
        <?php 
        include "../config/conexion.php";
        include "../controlador/almacen/eliminar_producto.php";

        // Consulta para obtener productos en el almacen
        $query = "SELECT a.id_almacen, p.id_producto, p.nombre, a.stock_actual, a.stock_minimo, a.fecha_actualizacion
                FROM almacen a
                JOIN productos p ON a.id_producto = p.id_producto";
        $sql = $conexion->query($query);

        if (!$sql) {
            die("Error en la consulta: " . $conexion->error);
        }
        ?>
        <!-- Opciones de botones -->
        <a href="../controlador/logout.php" class="btn btn-danger">Cerrar Sesión</a> <!-- Botón de cierre de sesión -->
        <a href="../controlador/almacen/registrar_producto.php" class="btn btn-success">Registrar Nuevos Ingresos</a> <!-- Botón de registro -->
        
        <div class="container-fluid">
            <!-- Tabla de almacen -->
            <table class="table">
                <thead class="bg-info">
                    <tr>
                        <th scope="col">ID Almacén</th>
                        <th scope="col">ID Producto</th>
                        <th scope="col">Nombre Producto</th>
                        <th scope="col">Stock Actual</th>
                        <th scope="col">Stock Mínimo</th>
                        <th scope="col">Fecha de Actualización</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    while ($datos = $sql->fetch_object()) { ?>
                        <tr>
                            <td><?= $datos->id_almacen ?></td>
                            <td><?= $datos->id_producto ?></td>
                            <td><?= $datos->nombre ?></td>
                            <td><?= $datos->stock_actual ?></td>
                            <td><?= $datos->stock_minimo ?></td>
                            <td><?= $datos->fecha_actualizacion ?></td>
                            <td>
                                <a href="modificar_almacen.php?id=<?= $datos->id_producto ?>" class="btn btn-small btn-warning"><i class="fa-solid fa-pen-to-square"></i></a>
                                <a onclick="return eliminarProducto()" href="almacen.php?id=<?= $datos->id_producto ?>" class="btn btn-small btn-danger"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>        
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- Pie de página -->
    <footer>
        <p>&copy; Peru al plato</p>
    </footer>
</body>
</html>