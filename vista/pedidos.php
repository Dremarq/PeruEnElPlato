<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/styles/admi.css">
    <link rel="stylesheet" href="../public/styles/tablas.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/191a90e971.js" crossorigin="anonymous"></script>
    <title>Interfaz de Administrador</title>
</head>
<body>
    <script>
        function eliminarPedido() {
            var respuesta = confirm("¿Estás seguro que deseas eliminar este pedido?");
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
            <li><a href="">Pedidos</a></li>
            <li><a href="../vista/productos.php">Productos</a></li>
            <li><a href="../vista/proveedores.php">Proveedores</a></li>
            <li><a href="../vista/reservas.php">Reservas</a></li>
            <li><a href="../vista/roles.php">Roles</a></li>
            <li><a href="../vista/usuario.php">Usuarios</a></li>
        </ul>
    </nav>

    <!-- Contenido principal -->
    <div class="main-content">
        <h2>Registro de Pedidos</h2>
        <?php 
        include "../config/conexion.php";
        include "../controlador/pedidos/eliminar_pedido.php";

        // Ejecuta la consulta para obtener pedidos
        $query = "SELECT p.id_pedido, u.nombre AS cliente, p.fecha_pedido AS fecha, p.total, p.estado FROM pedidos p JOIN usuarios u ON p.id_usuario = u.id_usuario"; 
        $sql = $conexion->query($query);

        if (!$sql) {
            die("Error en la consulta: " . $conexion->error);
        }
        ?>
        <!-- Opciones de botones -->
        <a href="../controlador/logout.php" class="btn btn-danger">Cerrar Sesión</a> <!-- Botón de cierre de sesión -->
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#registroModal">Registrar Pedido</button>

<!-- Modal -->
<div class="modal fade" id="registroModal" tabindex="-1" aria-labelledby="registroModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registroModalLabel">Registrar Pedido</h5>
                
            </div>
            <div class="modal-body">
                <form id="formRegistroPedido" action="#######" method="POST">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre del Cliente</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                    <label for="fechaHora" class="form-label">Seleccionar Fecha y Hora</label>
                    <input type="datetime-local" class="form-control" id="fechaHora" name="fechaHora" required>
                    </div>
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Total</label>
                        <input type="text" class="form-control" id="total" name="total" required>
                    </div>
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Estado</label>
                        <input type="text" class="form-control" id="estado" name="estados" required>
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

        <div class="container-fluid">
            <!-- Tabla de pedidos -->
            <table class="table">
                <thead class="bg-info">
                    <tr>
                        <th scope="col">ID Pedido</th>
                        <th scope="col">Cliente</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Total</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    while ($datos = $sql->fetch_object()) { ?>
                        <tr>
                            <td><?= $datos->id_pedido ?></td>
                            <td><?= $datos->cliente ?></td>
                            <td><?= $datos->fecha ?></td>
                            <td><?= $datos->total ?></td>
                            <td><?= $datos->estado ?></td>
                            <td>
    <a href="#" onclick="abrirModalModificarPedido('<?= $datos->id_pedido ?>', '<?= $datos->cliente ?>', '<?= $datos->fecha ?>', '<?= $datos->total ?>', '<?= $datos->estado ?>')" class="btn btn-small btn-warning">
    <i class="fa-solid fa-pen-to-square"></i>
</a>
<!-- Modal para Modificar Pedido -->
<div class="modal fade" id="modificarPedidoModal" tabindex="-1" aria-labelledby="modificarPedidoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modificarPedidoModalLabel">Modificar Pedido</h5>
            </div>
            <div class="modal-body">
                <form id="formModificarPedido" action="#######" method="POST">
                    <input type="hidden" id="id_pedido" name="id_pedido"> <!-- Campo oculto para el ID del pedido -->
                    <div class="mb-3">
                        <label for="nombreClienteModificar" class="form-label">Nombre del Cliente</label>
                        <input type="text" class="form-control" id="nombreClienteModificar" name="nombreClienteModificar" required>
                    </div>
                    <div class="mb-3">
                        <label for="fechaHoraModificar" class="form-label">Seleccionar Fecha y Hora</label>
                        <input type="datetime-local" class="form-control" id="fechaHoraModificar" name="fechaHoraModificar" required>
                    </div>
                    <div class="mb-3">
                        <label for="totalModificar" class="form-label">Total</label>
                        <input type="text" class="form-control" id="totalModificar" name="totalModificar" required>
                    </div>
                    <div class="mb-3">
                        <label for="estadoModificar" class="form-label">Estado</label>
                        <input type="text" class="form-control" id="estadoModificar" name="estadoModificar" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Modificar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal para Modificar Pedido -->                              
                                  
                                <a onclick="return eliminarPedido()" href="pedidos.php?id=<?= $datos->id_pedido ?>" class="btn btn-small btn-danger"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>        
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
    function abrirModalModificarPedido(id, nombreCliente, fecha, total, estado) {
        // Asignar los valores a los campos del modal
        document.getElementById('id_pedido').value = id;
        document.getElementById('nombreClienteModificar').value = nombreCliente;
        document.getElementById('fechaHoraModificar').value = fecha;
        document.getElementById('totalModificar').value = total;
        document.getElementById('estadoModificar').value = estado;

        // Mostrar el modal
        var modificarPedidoModal = new bootstrap.Modal(document.getElementById('modificarPedidoModal'));
        modificarPedidoModal.show();
    }
</script>
    <!-- Pie de página -->
    <footer>
        <p>&copy; Peru al plato</p>
    </footer>
</body>
</html>
