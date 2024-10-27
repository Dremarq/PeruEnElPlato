<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/styles/admi.css">
    <link rel="stylesheet" href="../public/styles/tablas.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/191a90e971.js" crossorigin="anonymous"></script>
    <title>Proveedores</title>
</head>
<body>
    <script>
        function eliminarProveedor() {
            var respuesta = confirm("¿Estás seguro que deseas eliminar este proveedor?");
            return respuesta;
        }
    </script>

    <!-- Menú lateral -->
    <nav class="sidebar">
        <h2>Pantalla de Administrador</h2>
        <ul>
            <li><a href="../vista/admin_dashboard.php">Dashboard - Perú en el plato</a></li>
            <li><a href="../vista/almacen.php">Almacén</a></li>
            <li><a href="../vista/detalle_pedido.php">Detalle Pedido</a></li>
            <li><a href="../vista/empleados.php">Empleados</a></li>
            <li><a href="../vista/pedidos.php">Pedidos</a></li>
            <li><a href="../vista/productos.php">Productos</a></li>
            <li><a href="">Proveedores</a></li>
            <li><a href="../vista/reservas.php">Reservas</a></li>
            <li><a href="../vista/roles.php">Roles</a></li>
            <li><a href="../vista/usuarios.php">Usuarios</a></li>
        </ul>
    </nav>

    <!-- Contenido principal -->
    <div class="main-content">
        <h2>Registro de Proveedores</h2>
        <?php 
        include "../config/conexion.php";
        include "../controlador/proveedores/eliminar_proveedor.php"; 

        // Consulta para obtener proveedores
        $query = "SELECT * FROM proveedores";
        $sql = $conexion->query($query);

        if (!$sql) {
            die("Error en la consulta: " . $conexion->error);
        }
        ?>
        <!-- Opciones de botones -->
        <a href="../controlador/logout.php" class="btn btn-danger">Cerrar Sesión</a> <!-- Botón de cierre de sesión -->
        <a href="../controlador/proveedores/registrar_proveedor.php" class="btn btn-success">Registrar Proveedor</a> <!-- Botón de registro -->

        <div class="container-fluid">
            <!-- Tabla de proveedores -->
            <table class="table">
                <thead class="bg-info">
                    <tr>
                        <th scope="col">ID Proveedor</th>
                        <th scope="col">Nombre Empresa</th>
                        <th scope="col">RUC</th>
                        <th scope="col">Teléfono</th>
                        <th scope="col">Email</th>
                        <th scope="col">Dirección</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    while ($datos = $sql->fetch_object()) { ?>
                        <tr>
                            <td><?= $datos->id_proveedor ?></td>
                            <td><?= $datos->nombre_empresa ?></td>
                            <td><?= $datos->ruc ?></td>
                            <td><?= $datos->telefono ?></td>
                            <td><?= $datos->email ?></td>
                            <td><?= $datos->direccion ?></td>
                            <td><?= $datos->estado ? 'Activo' : 'Inactivo' ?></td>
                            <td>
                                <a href="modificar_proveedor.php?id=<?= $datos->id_proveedor ?>" class="btn btn-small btn-warning"><i class="fa-solid fa-pen-to-square"></i></a>
                                <a onclick="return eliminarProveedor()" href="proveedores.php?id=<?= $datos->id_proveedor ?>" class="btn btn-small btn-danger"><i class="fa-solid fa-trash"></i></a>
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
