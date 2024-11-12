<?php
session_start();
require_once "../config/conexion.php";
require_once "../modelo/pedidos.php";

$pedidoModelo = new Pedido($conexion);
$pedidos = $pedidoModelo->obtenerPedidos();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/styles/admi.css">
    <link rel="stylesheet" href="../public/styles/tablas.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/191a90e971.js" crossorigin="anonymous"></script>
    <title>Interfaz de Administrador - Pedidos</title>
</head>
<body>
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

        <?php if (isset($_SESSION['mensaje'])): ?>
            <div class="alert alert-<?= $_SESSION['tipo_mensaje'] ?> alert-dismissible fade show" role="alert">
                <?= $_SESSION['mensaje'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php
            unset($_SESSION['mensaje']);
            unset($_SESSION['tipo_mensaje']);
            ?>
        <?php endif; ?>

        <!-- Opciones de botones -->
        <a href="../controlador/logout.php" class="btn btn-danger">Cerrar Sesión</a>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#registroModal">Registrar Pedido</button>

        <!-- Modal de Registro -->
        <div class="modal fade" id="registroModal" tabindex="-1" aria-labelledby="registroModalLabel">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="registroModalLabel">Registrar Nuevo Pedido</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="../controlador/CRUDpedidos.php" method="POST">
                            <input type="hidden" name="accion" value="registrar">
                            <div class="mb-3">
                                <label for="id_usuario" class="form-label">Cliente</label>
                                <select class="form-select" id="id_usuario" name="id_usuario" required>
                                    <option value="">Seleccione un cliente</option>
                                    <?php
                                    $clientes = $pedidoModelo->obtenerClientes();
                                    while ($cliente = $clientes->fetch_object()) {
                                        echo "<option value='{$cliente->id_usuario}'>{$cliente->nombre}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="id_empleado" class="form-label">Empleado</label>
                                <select class="form-select" id="id_empleado" name="id_empleado" required>
                                    <option value="">Seleccione un empleado</option>
                                    <?php
                                    $empleados = $pedidoModelo->obtenerEmpleados();
                                    while ($empleado = $empleados->fetch_object()) {
                                        echo "<option value='{$empleado->id_empleado}'>{$empleado->nombre}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="fecha_pedido" class="form-label">Fecha del Pedido</label>
                                <input type="datetime-local" class="form-control" id="fecha_pedido" name="fecha_pedido" required>
                            </div>
                            <div class="mb-3">
                                <label for="estado" class="form-label">Estado</label>
                                <select class="form-select" id="estado" name="estado" required>
                                    <option value="Pendiente">Pendiente</option>
                                    <option value="En Proceso">En Proceso</option>
                                    <option value="Completado">Completado</option>
                                    <option value="Cancelado">Cancelado</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="tipo_pedido" class="form-label">Tipo de Pedido</label>
                                <select class="form-select" id="tipo_pedido" name="tipo_pedido" required>
                                    <option value="Dine-in">Dine-in</option>
                                    <option value="Delivery">Delivery</option>
                                    <option value="Para Llevar">Para Llevar</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="total" class="form-label">Total</label>
                                <input type="number" step="0.01" class="form-control" id="total" name="total" required>
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
        <div class="container-fluid">
            <!-- Tabla de pedidos -->
            <table class="table">
                <thead class="bg-info">
                    <tr>
                        <th>ID Pedido</th>
                        <th>Cliente</th>
                        <th>Empleado</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Tipo Pedido</th>
                        <th>Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    // Verificar si hay pedidos
                    if ($pedidos && $pedidos->num_rows > 0):
                        while ($pedido = $pedidos->fetch_object()): 
                    ?>
                        <tr>
                            <td><?= $pedido->id_pedido ?></td>
                            <td><?= $pedido->cliente ?></td>
                            <td><?= $pedido->empleado ?></td>
                            <td><?= $pedido->fecha_pedido ?></td>
                            <td><?= $pedido->estado ?></td>
                            <td><?= $pedido->tipo_pedido ?></td>
                            <td><?= $pedido->total ?></td>
                            <td>
                                <a href="#" onclick="abrirModalModificar(
                                    '<?= $pedido->id_pedido ?>',
                                    '<?= $pedido->id_usuario ?>',
                                    '<?= $pedido->id_empleado ?>',
                                    '<?= $pedido->fecha_pedido ?>',
                                    '<?= $pedido->estado ?>',
                                    '<?= $pedido->tipo_pedido ?>',
                                    '<?= $pedido->total ?>'
                                )" class="btn btn-small btn-warning">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <a onclick="return eliminarPedido()" href="../controlador/CRUDpedidos.php?accion=eliminar&id=<?= $pedido->id_pedido ?>" class="btn btn-small btn-danger">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php 
                        endwhile; 
                    else: 
                    ?>
                        <tr>
                            <td colspan="8" class="text-center">
                                <div class="alert alert-info" role="alert">
                                    <i class="fas fa-info-circle me-2"></i>
                                    No hay pedidos registrados actualmente
                                </div>
                            </td>
                        </tr>
                    <?php 
                    endif; 
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal de Modificación -->
    <div class="modal fade" id="modificarModal" tabindex="-1" aria-labelledby="modificarModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modificarModalLabel">Modificar Pedido</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="../controlador/CRUDpedidos.php" method="POST">
                        <input type="hidden" name="accion" value="modificar">
                        <input type="hidden" id="id_pedido" name="id_pedido">
                        <div class="mb-3">
                            <label for="id_usuario" class="form-label">Cliente</label>
                            <select class="form-select" id="id_usuario_modificar" name="id_usuario" required>
                                <option value="">Seleccione un cliente</option>
                                <?php
                                $clientes = $pedidoModelo->obtenerClientes();
                                while ($cliente = $clientes->fetch_object()) {
                                    echo "<option value='{$cliente->id_usuario}'>{$cliente->nombre}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="id_empleado" class="form-label">Empleado</label>
                            <select class="form-select" id="id_empleado_modificar" name="id_empleado" required>
                                <option value="">Seleccione un empleado</option>
                                <?php
                                $empleados = $pedidoModelo->obtenerEmpleados();
                                while ($empleado = $empleados->fetch_object()) {
                                    echo "<option value='{$empleado->id_empleado}'>{$empleado->nombre}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="fecha_pedido" class="form-label">Fecha del Pedido</label>
                            <input type="datetime-local" class="form-control" id="fecha_pedido_modificar" name="fecha_pedido" required>
                        </div>
                        <div class="mb-3">
                            <label for="estado" class="form-label">Estado</label>
                            <select class="form-select" id="estado_modificar" name="estado" required>
                                <option value="Pendiente">Pendiente</option>
                                <option value="En Proceso">En Proceso</option>
                                <option value="Completado">Completado</option>
                                <option value="Cancelado">Cancelado</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tipo_pedido" class="form-label">Tipo de Pedido</label>
                            <select class="form-select" id="tipo_pedido_modificar" name="tipo_pedido" required>
                                <option value="Dine-in">Dine-in</option>
                                <option value="Delivery">Delivery</option>
                                <option value="Para Llevar">Para Llevar</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="total" class="form-label">Total</label>
                            <input type="number" step="0.01" class="form-control" id="total_modificar" name="total" required>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <<script>
    function abrirModalModificar(id, idUsuario, idEmpleado, fechaPedido, estado, tipoPedido, total) {
        // Corregir los IDs de los campos
        document.getElementById('id_pedido').value = id;
        document.getElementById('id_usuario_modificar').value = idUsuario;
        document.getElementById('id_empleado_modificar').value = idEmpleado;
        document.getElementById('fecha_pedido_modificar').value = fechaPedido;
        document.getElementById('estado_modificar').value = estado;
        document.getElementById('tipo_pedido_modificar').value = tipoPedido;
        document.getElementById('total_modificar').value = total;

        // Crear y mostrar el modal correctamente
        var modificarModal = new bootstrap.Modal(document.getElementById('modificarModal'));
        modificarModal.show();
    }

    function eliminarPedido() {
        return confirm("¿Estás seguro de que deseas eliminar este pedido?");
    }
</script>
</body>
</html>