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
    <link rel="stylesheet" href="../public/styles/det_ped.css">
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
        <a href="../controlador/logout.php" class="btn" style="background-color: #e74c3c; color: white;">Cerrar Sesión</a>
        <button type="button" class="btn" style="background-color: #3498db; color: white;" data-bs-toggle="modal" data-bs-target="#registroModal">Registrar</button>
        <button type="button" class="btn" style="background-color: #e67e22; color: white;" onclick="location.href='../controlador/CRUDdetalle_pedido.php?accion=generar_pdf'">Generar PDF</button>
        <button type="button" class="btn" style="background-color: #2ecc71; color: white;" onclick="location.href='../controlador/CRUDdetalle_pedido.php?accion=generar_excel'">Generar Excel</button>
        <!-- <button id="toggle-dark-mode" onclick="toggleDarkMode()">Modo Oscuro</button> -->       

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
                                            echo "<option value='{$pedido->id_pedido}'>Pedido #{$pedido->id_pedido}</option>";
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
        <br>   
        <br>       
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
                    <?php if ($detalles && $detalles->num_rows > 0): ?>
                        <?php while ($detalle = $detalles->fetch_object()): ?>
                            <tr>
                                <td><?= $detalle->id_detalle ?></td>
                                <td><?= $detalle->id_pedido ?></td>
                                <td><?= isset($detalle->plato) ? $detalle->plato : 'N/A' ?></td>
                                <td><?= $detalle->cantidad ?></td>
                                <td><?= number_format($detalle->precio_unitario, 2) ?></td>
                                <td><?= isset($detalle->subtotal) ? number_format($detalle->subtotal, 2) : '0.00' ?></td>
                                <td>
                                    <a href="#" onclick="abrirModalModificarDetalle('<?= $detalle->id_detalle ?>', '<?= $detalle->id_pedido ?>', '<?= isset($detalle->id_plato) ? $detalle->id_plato : 'N/A' ?>', '<?= $detalle->cantidad ?>', '<?= $detalle->precio_unitario ?>')" class="btn btn-small btn-warning">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <a href="../controlador/CRUDdetalle_pedido.php?accion=eliminar&id=<?= $detalle->id_detalle ?>" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este detalle de pedido?');"><i class="fa-solid fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">
                                <div class="alert alert-info" role="alert">
                                    <i class="fas fa-info-circle me-2"></i>
                                    No hay detalles de pedido registrados actualmente.
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <!-- Pie de página -->
        <footer>
            <p>&copy; Peru al plato</p>
        </footer>
    </div>

    <!-- Modal para Modificar Detalle de Pedido -->
    <div class="modal fade" id="modificarModalDetalle" tabindex="-1" aria-labelledby="modificarModalDetalleLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modificarModalDetalleLabel">Modificar Detalle de Pedido</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formModificarDetallePedido" action="../controlador/CRUDdetalle_pedido.php" method="POST">
                        <input type="hidden" name="accion" value="modificar">
                        <input type="hidden" id="id_detalle" name="id_detalle"> <!-- Campo oculto para el ID del detalle -->
                        <div class="mb-3">
                            <label for="id_pedido_modificar" class="form-label">Pedido</label>
                            <select class="form-select" id="id_pedido_modificar" name="id_pedido" required>
                                <option value="">Seleccione un pedido</option>
                                <?php
                                // Aquí debes cargar los pedidos desde la base de datos
                                $pedidos = $detallePedidoModelo->obtenerPedidos();
                                while ($pedido = $pedidos->fetch_object()) {
                                    echo "<option value='{$pedido->id_pedido}'>{$pedido->id_pedido}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="id_plato_modificar" class="form-label">Plato</label>
                            <select class="form-select" id="id_plato_modificar" name="id_plato" required>
                                <option value="">Seleccione un plato</option>
                                <?php
                                // Aquí debes cargar los platos desde la base de datos
                                $platos = $detallePedidoModelo->obtenerPlatos();
                                while ($plato = $platos->fetch_object()) {
                                    echo "<option value='{$plato->id_plato}'>{$plato->nombre}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="cantidad_modificar" class="form-label">Cantidad</label>
                            <input type="number" class="form-control" id="cantidad_modificar" name="cantidad" required>
                        </div>
                        <div class="mb-3">
                            <label for="precio_unitario_modificar" class="form-label">Precio Unitario</label>
                            <input type="number" step="0.01" class="form-control" id="precio_unitario_modificar" name="precio_unitario" required>
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

    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../public/JavaScript/detalle_pedido.js"></script>
        
    

</body>

</html>


    