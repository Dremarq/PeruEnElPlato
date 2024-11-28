<?php
session_start();
require_once "../config/conexion.php";
require_once "../modelo/Empleado.php";

$empleadoModelo = new Empleado($conexion);
$empleados = $empleadoModelo->obtenerEmpleados();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/styles/admi.css">
    <link rel="stylesheet" href="../public/styles/tablas.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/191a90e971.js" crossorigin="anonymous"></script>
    <title>Interfaz de Administrador - Empleados</title>
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
            <li><a href="../vista/platos.php">Platos</a></li>
            <li><a href="../vista/proveedores.php">Proveedores</a></li>
            <li><a href="../vista/reservas.php">Reservas</a></li>
            <li><a href="../vista/roles.php">Roles</a></li>
            <li><a href="../vista/usuario.php">Usuarios</a></li>
        </ul>
    </nav>

    <!-- Contenido principal -->
    <div class="main-content">
        <h2>Registro de Empleados</h2>

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

        <a href="../controlador/logout.php" class="btn" style="background-color: #e74c3c; color: white;">Cerrar Sesión</a>
        <button type="button" class="btn" style="background-color: #3498db; color: white;" data-bs-toggle="modal" data-bs-target="#registroModal">Registrar</button>
        <button type="button" class="btn" style="background-color: #e67e22; color: white;" onclick="location.href='../controlador/CRUDempleado.php?accion=generar_pdf'">Generar PDF</button>
        <button type="button" class="btn" style="background-color: #2ecc71; color: white;" onclick="location.href='../controlador/CRUDempleado.php?accion=generar_excel'">Generar Excel</button>
        

        <!-- Tabla de Empleados -->
        <table class="table">
            <thead>
                <tr>
                <th>ID</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>DNI</th>
            <th>Teléfono</th>
            <th>Email</th>
            <th>Dirección</th>
            <th>Fecha de Contratación</th>
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
                        <td><?= $empleado->direccion ?></td>
                        <td><?= $empleado->fecha_contratacion ?></td>
                        <td><?= $empleado->nombre_rol ?></td>
                        <td>
                            <button class="btn btn-warning" onclick="abrirModalModificarEmpleado(<?= $empleado->id_empleado ?>, '<?= $empleado->nombre ?>', '<?= $empleado->apellido ?>', '<?= $empleado->dni ?>', '<?= $empleado->telefono ?>', '<?= $empleado->email ?>','<?= $empleado->direccion ?>','<?= $empleado->fecha_contratacion ?>', <?= $empleado->id_rol ?>)"><i class="fa-solid fa-pen-to-square"></i></button>
                            <a href="../controlador/CRUDempleado.php?accion=eliminar&id=<?= $empleado->id_empleado ?>" class="btn btn-danger"><i class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Modal de Modificación -->
        <div class="modal fade" id="modificarModal" tabindex="-1" aria-labelledby="modificarModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modificarModalLabel">Modificar Empleado</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="../controlador/CRUDempleado.php" method="POST">
                            <input type="hidden" name="accion" value="modificar">
                            <input type="hidden" id="id_empleado" name="id_empleado">
                            <div class="mb-3">
                                <label for="nombreModificar" class="form-label">Nombre:</label>
                                <input type="text" class="form-control" id="nombreModificar" name="nombre" required>
                            </div>
                            <div class="mb-3">
                                <label for="apellidoModificar" class="form-label">Apellido:</label>
                                <input type="text" class="form-control" id="apellidoModificar" name="apellido" required>
                    </div>
                    <div class="mb-3">
                        <label for="dniModificar" class="form-label">DNI:</label>
                        <input type="text" class="form-control" id="dniModificar" name="dni" required pattern="[0-9]{8}"
                        title="El DNI debe tener 8 dígitos numéricos">
                    </div>
                    <div class="mb-3">
                        <label for="telefonoModificar" class="form-label">Teléfono:</label>
                        <input type="text" class="form-control" id="telefonoModificar" name="telefono" required>
                    </div>
                    <div class="mb-3">
                        <label for="emailModificar" class="form-label">Email:</label>
                        <input type="email" class="form-control" id="emailModificar" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="direccionModificar" class="form-label">Dirección:</label>
                        <input type="text" class="form-control" id="direccionModificar" name="direccion" required>
                    </div>
                    <div class="mb-3">
                        <label for="fecha_contratacionModificar" class="form-label">Fecha de Contratación:</label>
                        <input type="date" class="form-control" id="fecha_contratacionModificar" name="fecha_contratacion" required>
                    </div>
                    <div class="mb-3">
                        <label for="rolModificar" class="form-label">Rol:</label>
                        <select class="form-select" id="rolModificar" name="rol" required>
                            <option value="">Seleccione un rol</option>
                            <option value="1">Administrador</option>
                                <option value="2">cajero</option>
                                <option value="3">cocinero</option>
                                <option value="7">Mesero</option>
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
    <!-- Modal de Registro -->
    <div class="modal fade" id="registroModal" tabindex="-1" aria-labelledby="registroModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registroModalLabel">Registrar Empleado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="../controlador/CRUDempleado.php" method="POST">
                        <input type="hidden" name="accion" value="registrar">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre:</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="apellido" class="form-label">Apellido:</label>
                            <input type="text" class="form-control" id="apellido" name="apellido" required>
                        </div>
                        <div class="mb-3">
                            <label for="dni" class="form-label">DNI:</label>
                            <input type="text" class="form-control" id="dni" name="dni" required pattern="[0-9]{8}"
                            title="El DNI debe tener 8 dígitos numéricos">
                        </div>
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono:</label>
                            <input type="text" class="form-control" id="telefono" name="telefono" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección:</label>
                            <input type="text" class="form-control" id="direccion" name="direccion" required>
                        </div>
                        <div class="mb-3">
                            <label for="fecha_contratacion" class="form-label">Fecha de Contratación:</label>
                            <input type="date" class="form-control" id="fecha_contratacion" name="fecha_contratacion" required>
                        </div>
                        <div class="mb-3">
                            <label for="rol" class="form-label">Rol:</label>
                            <select class="form-select" id="rol" name="rol" required>
                                <option value="">Seleccione un rol</option>
                                <option value="1">Administrador</option>
                                <option value="2">cajero</option>
                                <option value="3">cocinero</option>
                                <option value="7">Mesero</option>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function abrirModalModificarEmpleado(id, nombre, apellido, dni, telefono, email,direccion, fecha_contratacion, id_rol) {
            document.getElementById('id_empleado').value = id;
            document.getElementById('nombreModificar').value = nombre;
            document.getElementById('apellidoModificar').value = apellido;
            document.getElementById('dniModificar').value = dni;
            document.getElementById('telefonoModificar').value = telefono;
            document.getElementById('emailModificar').value = email;
            document.getElementById('direccionModificar').value = direccion;
            document.getElementById('fecha_contratacionModificar').value = fecha_contratacion;
            document.getElementById('rolModificar').value = id_rol; // Asigna el rol al campo correspondiente

            // Mostrar el modal
            var modificarModal = new bootstrap.Modal(document.getElementById('modificarModal'));
            modificarModal.show();
        }
    </script>
</body>

</html>
<script>
        function validarNombreApellido(input) {
            // Eliminar caracteres no válidos (números y caracteres especiales)
            input.value = input.value.replace(/[^A-Za-z\s]/g, '');

            // Capitalizar la primera letra de cada palabra
            input.value = input.value.replace(/\b\w/g, char => char.toUpperCase());
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('nombre').addEventListener('input', function() {
                validarNombreApellido(this);
            });

            document.getElementById('apellido').addEventListener('input', function() {
                validarNombreApellido(this);
            });
        });
        function validarDNI(input) {
            // Eliminar caracteres no válidos (solo permitir números)
            input.value = input.value.replace(/[^0-9]/g, '');

            // Limitar a 8 dígitos
            if (input.value.length > 8) {
                input.value = input.value.slice(0, 8); // Cortar a los primeros 8 dígitos
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('dni').addEventListener('input', function() {
                validarDNI(this);
            });
        });
        function validarTelefono(input) {
            // Eliminar caracteres no válidos (solo permitir números)
            input.value = input.value.replace(/[^0-9]/g, '');

            // Verificar que el primer dígito sea 9 y limitar a 9 dígitos
            if (input.value.length > 9) {
                input.value = input.value.slice(0, 9); // Cortar a los primeros 9 dígitos
            }

            // Asegurarse de que el primer dígito sea 9
            if (input.value.length === 1 && input.value !== '9') {
                input.value = ''; // Limpiar el campo si no empieza con 9
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('telefono').addEventListener('input', function() {
                validarTelefono(this);
            });
        });
    </script>