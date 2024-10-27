<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/styles/admi.css">
    <link rel="stylesheet" href="../public/styles/tablas.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/191a90e971.js" crossorigin="anonymous"></script>
    <title>Interfaz de Administrador - Reservas</title>
</head>
<body>
    <script>
        function eliminarReserva() {
            var respuesta = confirm("¿Estás seguro que deseas eliminar esta reserva?");
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
            <li><a href="../vista/proveedores.php">Proveedores</a></li>
            <li><a href="">Reservas</a></li>
            <li><a href="../vista/roles.php">Roles</a></li>
            <li><a href="../vista/usuarios.php">Usuarios</a></li>
        </ul>
    </nav>

    <!-- Contenido principal -->
    <div class="main-content">
        <h2>Registro de Reservas</h2>
        <?php 
        include "../config/conexion.php";
        include "../controlador/reservas/eliminar_reserva.php";

        // Consulta para obtener reservas
        $query = "SELECT r.id_reserva, u.nombre AS cliente, r.numero_mesa, r.fecha_reserva, r.hora_reserva, r.cantidad_personas, r.estado
                FROM reservas r
                JOIN usuarios u ON r.id_usuario = u.id_usuario";
        $sql = $conexion->query($query);

        if (!$sql) {
            die("Error en la consulta: " . $conexion->error);
        }
        ?>
        <!-- Opciones de botones -->
        <a href="../controlador/logout.php" class="btn btn-danger">Cerrar Sesión</a> <!-- Botón de cierre de sesión -->
        <a href="../controlador/reservas/registrar_reserva.php" class="btn btn-success">Registrar Reserva</a> <!-- Botón de registro -->

        <div class="container-fluid">
            <!-- Tabla de reservas -->
            <table class="table">
                <thead class="bg-info">
                    <tr>
                        <th scope="col">ID Reserva</th>
                        <th scope="col">Cliente</th>
                        <th scope="col">Mesa</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Hora</th>
                        <th scope="col">Cantidad de Personas</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    while ($datos = $sql->fetch_object()) { ?>
                        <tr>
                            <td><?= $datos->id_reserva ?></td>
                            <td><?= $datos->cliente ?></td>
                            <td><?= $datos->numero_mesa ?></td>
                            <td><?= $datos->fecha_reserva ?></td>
                            <td><?= $datos->hora_reserva ?></td>
                            <td><?= $datos->cantidad_personas ?></td>
                            <td><?= $datos->estado ?></td>
                            <td>
                                <a href="modificar_reserva.php?id=<?= $datos->id_reserva ?>" class="btn btn-small btn-warning"><i class="fa-solid fa-pen-to-square"></i></a>
                                <a onclick="return eliminarReserva()" href="reservas.php?id=<?= $datos->id_reserva ?>" class="btn btn-small btn-danger"><i class="fa-solid fa-trash"></i></a>
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
