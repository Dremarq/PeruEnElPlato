<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/styles/admi.css">
    <link rel="stylesheet" href="../public/styles/tablas.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/191a90e971.js" crossorigin="anonymous"></script>
    <title>Detalle de Pedido</title>
</head>

<body>
    <script>
        function eliminarDetalle() {
            return confirm("¿Estás seguro que deseas eliminar este detalle de pedido?");
        }
    </script>

    <nav class="sidebar">
        <h2>Pantalla de Administrador</h2>
        <ul>
            <li><a href="../vista/admin_dashboard.php">Dashboard - Perú en el plato</a></li>
            <li><a href="../vista/almacen.php">Almacen</a></li>
            <li><a href="">Detalle Pedido</a></li>
            <li><a href="../vista/empleados.php">Empleados</a></li>
            <li><a href="../vista/pedidos.php">Pedidos</a></li>
            <li><a href="../vista/productos.php">Productos</a></li>
            <li><a href="../vista/proveedores.php">Proveedores</a></li>
            <li><a href="../vista/reservas.php">Reservas</a></li>
            <li><a href="../vista/roles.php">Roles</a></li>
            <li><a href="../vista/usuarios.php">Usuarios</a></li>
        </ul>
    </nav>

    

    <div class="main-content">
        <h2>Detalle de Pedidos</h2>
        <?php 
        include "../config/conexion.php";

        // Consulta para obtener los detalles de los pedidos
        $query = "SELECT d.id_detalle, d.id_pedido, p.nombre AS producto, d.cantidad, d.precio_unitario AS precio 
                FROM detalle_pedido d
                JOIN productos p ON d.id_producto = p.id_producto";
        $sql = $conexion->query($query);

        if (!$sql) {
            die("Error en la consulta: " . $conexion->error);
        }
        ?>

        <!-- Opciones de botones -->
        <a href="../controlador/logout.php" class="btn btn-danger">Cerrar Sesión</a> <!-- Botón de cierre de sesión -->
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#registroModal">Registrar Detalle de Pedido</button>

  <!-- Modal -->
  <div class="modal fade" id="registroModal" tabindex="-1" aria-labelledby="registroModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registroModalLabel">Registrar Pedido</h5>
            </div>
            <div class="modal-body">
                <form id="formRegistroPedido" action="#####" method="POST">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Producto</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="dni" class="form-label">Cantidad</label>
                        <input type="text" class="form-control" id="cantidad" name="cantidad" required>
                    </div>
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Precio</label>
                        <input type="text" class="form-control" id="precio" name="precio" required>
                    </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
   <!-- Modal -->                                   

        <!-- tabla detalle pedido-->
        <div class="container-fluid">
            <table class="table">
                <thead class="bg-info">
                    <tr>
                        <th scope="col">ID Detalle</th>
                        <th scope="col">ID Pedido</th>
                        <th scope="col">Producto</th>
                        <th scope="col">Cantidad</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    while ($datos = $sql->fetch_object()) { ?>
                        <tr>
                            <td><?= $datos->id_detalle ?></td>
                            <td><?= $datos->id_pedido ?></td>
                            <td><?= $datos->producto ?></td>
                            <td><?= $datos->cantidad ?></td>
                            <td><?= $datos->precio ?></td>
                            <td>
                                <a href="modificar_detalle_pedido.php?id=<?= $datos->id_detalle ?>" class="btn btn-small btn-warning"><i class="fa-solid fa-pen-to-square"></i></a>
                                <a onclick="return eliminarDetalle()" href="detalle_pedido.php?id=<?= $datos->id_detalle ?>" class="btn btn-small btn-danger"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>        
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <footer>
        <p>&copy; Peru al plato</p>
    </footer>
</body>
</html>

