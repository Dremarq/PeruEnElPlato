<?php
session_start();
require_once "../config/conexion.php";
require_once "../modelo/reservas.php";

$reservaModelo = new Reserva($conexion);
$reservas = $reservaModelo->obtenerReservas();
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
    <title>Interfaz de Administrador - Reservas</title>
</head>

<body>
    <!-- Menú lateral -->
    <nav class="sidebar">
        <h2>Pantalla de Administrador</h2>
        <ul>
            <li><a href="../vista/admin_dashboard.php">Dashboard - Perú en el plato</a></li>
            <li><a href="../vista/almacen.php">Almacen</a></li>
            <li><a href="../vista/detalle_pedido.php">Detalle Pedido</a></li>
            <li><a href="../vista/empleados.php">Empleados</a></li>
            <li><a href="../vista/pedidos.php">Pedidos</a></li>
            <li><a href="../vista/productos.php">Productos</a></li>
            <li><a href="../vista/platos.php">Platos</a></li>
            <li><a href="../vista/proveedores.php">Proveedores</a></li>
            <li><a href="">Reservas</a></li>
            <li><a href="../vista/roles.php">Roles</a></li>
            <li><a href="../vista/usuario.php">Usuarios</a></li>
        </ul>
    </nav>

    <!-- Contenido principal -->
    <div class="main-content">
        <h2>Registro de Reservas</h2>

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
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#registroModal">Registrar Reserva</button>

        <!-- Modal de Registro -->
        <div class="modal fade" id="registroModal" tabindex="-1" aria-labelledby="registroModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="registroModalLabel">Registrar Nueva Reserva</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="../controlador/CRUDreservas.php" method="POST">
                            <input type="hidden" name="accion" value="registrar">
                            <div class="mb-3">
                                <label for="id_usuario" class="form-label">Cliente</label>
                                <select class="form-select" id="id_usuario" name="id_usuario" required>
                                    <option value="">Seleccione un cliente</option>
                                    <?php
                                    $clientes = $reservaModelo->obtenerClientes();
                                    while ($cliente = $clientes->fetch_object()) {
                                        echo "<option value='{$cliente->id_usuario}'>{$cliente->nombre}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="numero_mesa" class="form-label">Número de Mesa</label>
                                <input type="number" class="form-control" id="numero_mesa" name="numero_mesa" required>
                            </div>
                            <div class="mb-3">
                                <label for="fecha_reserva" class="form-label">Fecha de Reserva</label>
                                <input type="date" class="form-control" id="fecha_reserva" name="fecha_reserva" required>
                            </div>
                            <div class="mb-3">
                                <label for="hora_reserva" class="form-label">Hora de Reserva</label>
                                <input type="time" class="form-control" id="hora_reserva" name="hora_reserva" required>
                            </div>
                            <div class="mb-3">
                                <label for="cantidad_personas" class="form-label">Cantidad de Personas</label>
                                <input type="number" class="form-control" id="cantidad_personas" name="cantidad_personas" required>
                            </div>
                            <div class="mb-3">
                                <label for="estado" class="form-label">Estado</label>
                                <select class="form-select" id="estado" name="estado" required>
                                    <option value="Confirmada">Confirmada</option>
                                    <option value="Pendiente">Pendiente</option>
                                    <option value="Cancelada">Cancelada</option>
                                </select>
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
            <!-- Tabla de reservas -->
            <table class="table">
                <thead class="bg-info">
                    <tr>
                        <th>ID Reserva</th>
                        <th>Cliente</th>
                        <th>Número de Mesa</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Cantidad de Personas</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Verificar si hay reservas
                    if ($reservas && $reservas->num_rows > 0):
                        while ($reserva = $reservas->fetch_object()):
                    ?>
                            <tr>
                                <td><?= $reserva->id_reserva ?></td>
                                <td><?= $reserva->cliente ?></td>
                                <td><?= $reserva->numero_mesa ?></td>
                                <td><?= $reserva->fecha_reserva ?></td>
                                <td><?= $reserva->hora_reserva ?></td>
                                <td><?= $reserva->cantidad_personas ?></td>
                                <td><?= $reserva->estado ?></td>
                                <td>
                                    <a href="#" onclick="abrirModalModificar(
                            '<?= $reserva->id_reserva ?>',
                            '<?= $reserva->id_usuario ?>',
                            '<?= $reserva->numero_mesa ?>',
                            '<?= $reserva->fecha_reserva ?>',
                            '<?= $reserva->hora_reserva ?>',
                            '<?= $reserva->cantidad_personas ?>',
                            '<?= $reserva->estado ?>'
                        )" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modificarModal">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="../controlador/CRUDreservas.php?accion=eliminar&id=<?= $reserva->id_reserva ?>"
                                        class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de eliminar esta reserva?')">
                                        <i class="fas fa-trash"></i>
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
                                    No hay reservas registradas actualmente
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
                    <h5 class="modal-title" id="modificarModalLabel">Modificar Reserva</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="../controlador/CRUDreservas.php" method="POST">
                        <input type="hidden" name="accion" value="modificar">
                        <input type="hidden" id="modificar_id_reserva" name="id_reserva">
                        <div class="mb-3">
                            <label for="modificar_id_usuario" class="form-label">Cliente</label>
                            <select class="form-select" id="modificar_id_usuario" name="id_usuario" required>
                                <option value="">Seleccione un cliente</option>
                                <?php
                                $clientes = $reservaModelo->obtenerClientes();
                                while ($cliente = $clientes->fetch_object()) {
                                    echo "<option value='{$cliente->id_usuario}'>{$cliente->nombre}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="modificar_numero_mesa" class="form-label">Número de Mesa</label>
                            <input type="number" class="form-control" id="modificar_numero_mesa" name="numero_mesa" required>
                        </div>
                        <div class="mb-3">
                            <label for="modificar_fecha_reserva" class="form-label">Fecha de Reserva</label>
                            <input type="date" class="form-control" id="modificar_fecha_reserva" name="fecha_reserva" required>
                        </div>
                        <div class="mb-3">
                            <label for="modificar_hora_reserva" class="form-label">Hora de Reserva</label>
                            <input type="time" class="form-control" id="modificar_hora_reserva" name="hora_reserva" required>
                        </div>
                        <div class="mb-3">
                            <label for="modificar_cantidad_personas" class="form-label">Cantidad de Personas</label>
                            <input type="number" class="form-control" id="modificar_cantidad_personas" name="cantidad_personas" required>
                        </div>
                        <div class="mb-3">
                            <label for="modificar_estado" class="form-label">Estado</label>
                            <select class="form-select" id="modificar_estado" name="estado" required>
                                <option value="Confirmada">Confirmada</option>
                                <option value="Pendiente">Pendiente</option>
                                <option value="Cancelada">Cancelada</option>
                            </select>
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

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function abrirModalModificar(id, idUsuario, numeroMesa, fechaReserva, horaReserva, cantidadPersonas, estado) {
            document.getElementById('modificar_id_reserva').value = id;
            document.getElementById('modificar_id_usuario').value = idUsuario;
            document.getElementById('modificar_numero_mesa').value = numeroMesa;
            document.getElementById('modificar_fecha_reserva').value = fechaReserva;
            document.getElementById('modificar_hora_reserva').value = horaReserva;
            document.getElementById('modificar_cantidad_personas').value = cantidadPersonas;
            document.getElementById('modificar_estado').value = estado;
        }
    </script>
</body>

</html>