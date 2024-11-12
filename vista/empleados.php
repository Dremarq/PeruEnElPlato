<?php
session_start();
require_once "../config/conexion.php";
require_once "../modelo/Empleado.php";

$empleadoModelo = new Empleado($conexion);
$empleados = $empleadoModelo->obtenerEmpleados();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/styles/admi.css">
    <link rel="stylesheet" href="../public/styles/tablas.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/191a90e971.js" crossorigin="anonymous"></script>
    <script src="../public/JavaScript/empleado.js"></script>
    <title>Interfaz de Administrador</title>
</head>

<body>


    <!-- Menú lateral -->
    <nav class="sidebar">
        <h2>Pantalla de Administrador</h2>
        <ul>
            <li><a href="../vista/admin_dashboard.php">Dashboard - Perú en el plato</a></li>
            <li><a href="../vista/almacen.php">Almacén</a></li>
            <li><a href="../vista/detalle_pedido.php">Detalle Pedido</a></li>
            <li><a href="">Empleados</a></li>
            <li><a href="../vista/pedidos.php">Pedidos</a></li>
            <li><a href="../vista/productos.php">Productos</a></li>
            <li><a href="../vista/proveedores.php">Proveedores</a></li>
            <li><a href="../vista/reservas.php">Reservas</a></li>
            <li><a href="../vista/roles.php">Roles</a></li>
            <li><a href="../vista/usuario.php">Usuarios</a></li>
        </ul>
    </nav>

    <!-- Contenido principal -->
    <div class="main-content">
        <h2>Registro de empleado</h2>


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
        <a href="../controlador/logout.php" class="btn btn-danger">Cerrar Sesión</a> <!-- Botón de cierre de sesión -->
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#registroModal">Registrar Empleado</button>
        <!-- <a href="../controlador/empleados/registrar_empleado.php" class="btn btn-success">Registrar Empleado</a> Botón de registro -->

        <!-- Modal de registro -->
        <div class="modal fade" id="registroModal" tabindex="-1" aria-labelledby="registroModalLabel">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="registroModalLabel">Registro de Empleado</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="../controlador/CRUDempleado.php" method="POST">
                            <input type="hidden" name="accion" value="registrar">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre:</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required minlength="3" maxlength="50"
                                    pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+"
                                    title="Solo se permiten letras y espacios">
                            </div>
                            <div class="mb-3">
                                <label for="apellido" class="form-label">Apellido:</label>
                                <input type="text" class="form-control" id="apellido" name="apellido" required minlength="3" maxlength="50"
                                    pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+"
                                    title="Solo se permiten letras y espacios">
                            </div>
                            <div class="mb-3">
                                <label for="dni" class="form-label">DNI:</label>
                                <input type="text" class="form-control" id="dni" name="dni" required pattern="[0-9]{8}"
                                    title="El DNI debe tener 8 dígitos numéricos">
                            </div>
                            <div class="mb-3">
                                <label for="telefono" class="form-label">Teléfono:</label>
                                <input type="text" class="form-control" id="telefono" name="telefono" required pattern="9[0-9]{8}"
                                    title="El teléfono debe comenzar con 9 y tener 9 dígitos">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email:</label>
                                <input type="email" class="form-control" id="email" name="email" required maxlength="80">
                            </div>
                            <div class="mb-3">
                                <label for="rol" class="form-label">Rol:</label>
                                <select class="form-select" id="rol" name="rol" required>
                                    <option value="">Seleccione un rol</option>

                                    <option value="1">Administrador</option>
                                    <option value="2">Chef</option>
                                    <option value="3">Mesero</option>
                                    <option value="4">Encargo de inventario</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de empleados -->
        <div class="container-fluid">
            <table class="table">
                <thead class="bg-info">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>DNI</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($empleado = $empleados->fetch_object()): ?>
                        <tr>
                            <td><?= $empleado->id_empleado ?></td>
                            <td><?= $empleado->nombre ?></td>
                            <td><?= $empleado->apellido ?></td>
                            <td><?= $empleado->dni ?></td>
                            <td><?= $empleado->telefono ?></td>
                            <td><?= $empleado->email ?></td>
                            <td><?= $empleado->nombre_rol ?></td>
                            <td>
                                <a href="#" onclick="abrirModalModificarEmpleado('<?= $empleado->id_empleado ?>', '<?= $empleado->nombre ?>', '<?= $empleado->apellido ?>', '<?= $empleado->dni ?>', '<?= $empleado->telefono ?>', '<?= $empleado->email ?>', '<?= $empleado->id_rol ?>')" class="btn btn-small btn-warning">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <a onclick="return eliminarempleados()" href="../controlador/CRUDempleado.php?accion=eliminar&id=<?= $empleado->id_empleado ?>" class="btn btn-small btn-danger">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Modal para Modificar Empleado -->
        <div class="modal fade" id="modificarEmpleadoModal" tabindex="-1" aria-labelledby="modificarEmpleadoModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modificarEmpleadoModalLabel">Modificar Empleado</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formModificarEmpleado" action="../controlador/CRUDempleado.php" method="POST">
                            <input type="hidden" name="accion" value="modificar">
                            <input type="hidden" id="id_empleado" name="id_empleado">
                            <div class="mb-3">
                                <label for="nombreModificar" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombreModificar" name="nombre" required required minlength="3" maxlength="50"
                                    pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+"
                                    title="Solo se permiten letras y espacios">
                            </div>
                            <div class="mb-3">
                                <label for="apellidoModificar" class="form-label">apellido</label>
                                <input type="text" class="form-control" id="apellidoModificar" name="apellido" required required minlength="3" maxlength="50"
                                    pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+"
                                    title="Solo se permiten letras y espacios">
                            </div>
                            <div class="mb-3">
                                <label for="dniModificar" class="form-label">DNI</label>
                                <input type="text" class="form-control" id="dniModificar" name="dni" required pattern="[0-9]{8}"
                                    title="El DNI debe tener 8 dígitos numéricos">
                            </div>
                            <div class="mb-3">
                                <label for="telefonoModificar" class="form-label">Teléfono</label>
                                <input type="text" class="form-control" id="telefonoModificar" name="telefono" required pattern="9[0-9]{8}"
                                    title="El teléfono debe comenzar con 9 y tener 9 dígitos">
                            </div>
                            <div class="mb-3">
                                <label for="emailModificar" class="form-label">Email</label>
                                <input type="email" class="form-control" id="emailModificar" name="email" required required maxlength="70">
                            </div>
                            <div class="mb-3">
                                <label for="rolModificar" class="form-label">Rol</label>
                                <select class="form-select" id="rolModificar" name="rol" required>
                                    <option value="1">Administrador</option>
                                    <option value="2">Chef</option>
                                    <option value="3">Mesero</option>
                                    <option value="4">Encargo de inventario</option>
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




        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>