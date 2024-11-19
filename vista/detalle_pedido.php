<?php
session_start();
require_once "../config/conexion.php";
require_once "../modelo/detalle_pedido.php";

$detallePedidoModelo = new DetallePedido($conexion);
$detalles = $detallePedidoModelo->obtenerDetallesPedido();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/styles/admi.css">
    <link rel="stylesheet" href="../public/styles/tablas.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/191a90e971.js" crossorigin="anonymous"></script>
    <title>Detalle de Pedidos - Administrador</title>
</head>

<body>
    <!-- Menú lateral -->
    <nav class="sidebar">
        <h2>Pantalla de Administrador</h2>
        <ul>
            <li><a href="../vista/admin_dashboard.php">Dashboard - Perú en el plato</a></li>
            <li><a href="../vista/almacen.php">Almacen</a></li>
            <li><a href="">Detalle Pedido</a></li>
            <li><a href="../vista/empleados.php">Empleados</a></li>
            <li><a href="../vista/pedidos.php">Pedidos</a></li>
            <li><a href="../vista/productos.php">Productos</a></li>
            <li><a href="../vista/platos.php">Platos</a></li>
            <li><a href="../vista/proveedores.php">Proveedores</a></li>
            <li><a href="../vista/reservas.php">Reservas</a></li>
            <li><a href="../vista/roles.php">Roles</a></li>
            <li><a href="../vista/usuario.php">Usuarios</a></li>
        </ul>
    </nav>

    <!-- Contenido principal -->
    <div class="main-content">
        <h2>Detalle de Pedidos</h2>
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
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#registroModal">Registrar Detalle de Pedido</button>

        <!-- Modal de Registro -->
        <div class="modal fade" id="registroModal" tabindex="-1" aria-labelledby="registroModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="registroModalLabel">Registrar Nuevo Detalle de Pedido</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formRegistroDetallePedido" action="../controlador/CRUDdetalle_pedido.php" method="POST">
                            <input type="hidden" name="accion" value="registrar">
                            <div class="mb-3">
                                <label for="id_pedido" class="form-label">Pedido</label>
                                <select class="form-select" id="id_pedido" name="id_pedido" required>
                                    <option value="">Seleccione un pedido</option>
                                    <?php
                                    $pedidos = $detallePedidoModelo->obtenerPedidos();
                                    if ($pedidos && $pedidos->num_rows > 0) {
                                        while ($pedido = $pedidos->fetch_object()) {
                                            echo "<option value='{$pedido->id_pedido}'>Pedido #{$pedido ->id_pedido}</option>";
                                        }
                                    } else {
                                        echo "<option value='' disabled>No hay pedidos disponibles</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="id_plato" class="form-label">Plato</label>
                                <select class="form-select" id="id_plato" name="id_plato" required>
                                    <option value="">Seleccione un plato</option>
                                    <?php
                                    $platos = $detallePedidoModelo->obtenerPlatos();
                                    if ($platos && $platos->num_rows > 0) {
                                        while ($plato = $platos->fetch_object()) {
                                            echo "<option value='{$plato->id_plato}'>{$plato->nombre}</option>";
                                        }
                                    } else {
                                        echo "<option value='' disabled>No hay platos disponibles</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="cantidad" class="form-label">Cantidad</label>
                                <input type="number" class="form-control" id="cantidad" name="cantidad" required>
                            </div>
                            <div class="mb-3">
                                <label for="precio_unitario" class="form-label">Precio Unitario</label>
                                <input type="number" step="0.01" class="form-control" id="precio_unitario" name="precio_unitario" required>
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
            <!-- Tabla de detalles de pedido -->
            <table class="table">
                <thead class="bg-info">
                    <tr>
                        <th scope="col">ID Detalle</th>
                        <th scope="col">ID Pedido</th>
                        <th scope="col">Plato</th>
                        <th scope="col">Cantidad</th>
                        <th scope="col">Precio Unitario</th>
                        <th scope="col">Subtotal</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($detalle = $detalles->fetch_object()): ?>
                        <tr>
                            <td><?= $detalle->id_detalle ?></td>
                            <td><?= $detalle->id_pedido ?></td>
                            <td><?= $detalle->plato ?></td>
                            <td><?= $detalle->cantidad ?></td>
                            <td><?= number_format($detalle->precio_unitario, 2) ?></td>
                            <td><?= number_format($detalle->subtotal, 2) ?></td>
                            <td>
                                <button type="button" class="btn btn-small btn-warning" data-bs-toggle="modal" data-bs-target="#modificarModal<?= $detalle->id_detalle ?>"><i class="fa-solid fa-pen-to-square"></i></button>
                                <a href="../controlador/CRUDdetalle_pedido.php?accion=eliminar&id=<?= $detalle->id_detalle ?>" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este detalle de pedido?');"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>

                        <!-- Modal de Modificación -->
                        <div class="modal fade" id="modificarModal<?= $detalle->id_detalle ?>" tabindex="-1" aria-labelledby="modificarModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modificarModalLabel">Modificar Detalle de Pedido</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="../controlador/CRUDdetalle_pedido.php" method="POST">
                                            <input type="hidden" name="accion" value="modificar">
                                            <input type="hidden" name="id_detalle" value="<?= $detalle->id_detalle ?>">
                                            <div class="mb-3">
                                                <label for="id_plato" class="form-label">Plato</label>
                                                <select class="form-select" id="id_plato" name="id_plato" required>
                                                    <option value="">Seleccione un plato</ ```php
                                                    <option value="">Seleccione un plato</option>
                                                    <?php
                                                    $platos = $detallePedidoModelo->obtenerPlatos();
                                                    if ($platos && $platos->num_rows > 0) {
                                                        while ($plato = $platos->fetch_object()) {
                                                            $selected = ($plato->id_plato == $detalle->id_plato) ? 'selected' : '';
                                                            echo "<option value='{$plato->id_plato}' $selected>{$plato->nombre}</option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="cantidad" class="form-label">Cantidad</label>
                                                <input type="number" class="form-control" id="cantidad" name="cantidad" value="<?= $detalle->cantidad ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="precio_unitario" class="form-label">Precio Unitario</label>
                                                <input type="number" step="0.01" class="form-control" id="precio_unitario" name="precio_unitario" value="<?= $detalle->precio_unitario ?>" required>
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
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <!-- Pie de página -->
        <footer>
            <p>&copy; Peru al plato</p>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Función para confirmar eliminación
        function eliminarDetallePedido() {
            return confirm("¿Estás seguro que deseas eliminar este detalle de pedido?");
        }
    </script>
</body>

</html>

<script>
    function preventNegativeValue(input) {
        if (input.value < 0) {
            input.value = 0; // Si el valor es menor a 0, se establece en 0
        }
    }

    // Aplicar la función a los campos de cantidad y precio unitario
    const cantidad = document.getElementById('cantidad');
    const precioUnitario = document.getElementById('precio_unitario');

    cantidad.addEventListener('input', function() {
        preventNegativeValue(this);
    });

    precioUnitario.addEventListener('input', function() {
        preventNegativeValue(this);
    });
</script>