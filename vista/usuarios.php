<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/styles/admi.css">
    <link rel="stylesheet" href="../public/styles/tablas.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/191a90e971.js" crossorigin="anonymous"></script>
    <title>Interfaz de Administrador - Usuarios</title>
</head>

<body>
    <script>
        function eliminarUsuario() {
            return confirm("¿Estás seguro que deseas eliminar este usuario?");
        }
    </script>

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
            <li><a href="../vista/proveedores.php">Proveedores</a></li>
            <li><a href="../vista/reservas.php">Reservas</a></li>
            <li><a href="../vista/roles.php">Roles</a></li>
            <li><a href="">Usuarios</a></li>
        </ul>
    </nav>

    <!-- Contenido principal -->
    <div class="main-content">
        <h2>Registro de Usuarios</h2>
        <?php
        include "../config/conexion.php";
        include "../controlador/usuarios/eliminar_usuario.php";

        // Consulta para obtener los usuarios
        $query = "SELECT id_usuario, nombre, apellido, dni, telefono, email, direccion, fecha_registro FROM usuarios";
        $sql = $conexion->query($query);

        if (!$sql) {
            die("Error en la consulta: " . $conexion->error);
        }
        ?>
        <!-- Opciones de botones -->
        <a href="../controlador/logout.php" class="btn btn-danger">Cerrar Sesión</a> <!-- Botón de cierre de sesión -->
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#registroUsuarioModal">Registrar Usuario</button>

        <!-- Modal -->
        <div class="modal fade" id="registroUsuarioModal" tabindex="-1" aria-labelledby="registroUsuarioModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="registroUsuarioModalLabel">Registrar Usuario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formRegistroUsuario">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <div class="mb-3">
                                <label for="apellido" class="form-label">Apellido</label>
                                <input type="text" class="form-control" id="apellido" name="apellido" required>
                            </div>
                            <div class="mb-3">
                                <label for="dni" class="form-label">DNI</label>
                                <input type="text" class="form-control" id="dni" name="dni" required>
                            </div>
                            <div class="mb-3">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="tel" class="form-control" id="telefono" name="telefono" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="direccion" class="form-label">Dirección</label>
                                <input type="text" class="form-control" id="direccion" name="direccion" required>
                            </div>
                            <div class="mb-3">
                                <label for="fechaRegistro" class="form-label">Fecha de Registro</label>
                                <input type="date" class="form-control" id="fechaRegistro" name="fechaRegistro" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Registrar Usuario</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <!-- Tabla de usuarios -->
            <table class="table">
                <thead class="bg-info">
                    <tr>
                        <th scope="col">ID Usuario</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Apellido</th>
                        <th scope="col">DNI</th>
                        <th scope="col">Teléfono</th>
                        <th scope="col">Email</th>
                        <th scope="col">Dirección</th>
                        <th scope="col">Fecha de Registro</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($datos = $sql->fetch_object()) { ?>
                        <tr>
                            <td><?= $datos->id_usuario ?></td>
                            <td><?= $datos->nombre ?></td>
                            <td><?= $datos->apellido ?></td>
                            <td><?= $datos->dni ?></td>
                            <td><?= $datos->telefono ?></td>
                            <td><?= $datos->email ?></td>
                            <td><?= $datos->direccion ?></td>
                            <td><?= $datos->fecha_registro ?></td>
                            <td>
                                <a href="#" onclick="abrirModalModificarUsuario('<?= $datos->id_usuario ?>', '<?= $datos->nombre ?>', '<?= $datos->apellido ?>', '<?= $datos->dni ?>', '<?= $datos->telefono ?>', '<?= $datos->email ?>', '<?= $datos->direccion ?>', '<?= $datos->fecha_registro ?>')" class="btn btn-small btn-warning">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <!-- Modal para Modificar Usuario -->
                                <div class="modal fade" id="modificarUsuarioModal" tabindex="-1" aria-labelledby="modificarUsuarioModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modificarUsuarioModalLabel">Modificar Usuario</h5>
                                            </div>
                                            <div class="modal-body">
                                                <form id="formModificarUsuario" action="#######" method="POST">
                                                    <input type="hidden" id="id_usuario" name="id_usuario"> <!-- Campo oculto para el ID del usuario -->
                                                    <div class="mb-3">
                                                        <label for="nombreModificar" class="form-label">Nombre</label>
                                                        <input type="text" class="form-control" id="nombreModificar" name="nombreModificar" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="apellidoModificar" class="form-label">Apellido</label>
                                                        <input type="text" class="form-control" id="apellidoModificar" name="apellidoModificar" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="dniModificar" class="form-label">DNI</label>
                                                        <input type="text" class="form-control" id="dniModificar" name="dniModificar" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="telefonoModificar" class="form-label">Teléfono</label>
                                                        <input type="tel" class="form-control" id="telefonoModificar" name="telefonoModificar" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="emailModificar" class="form-label">Email</label>
                                                        <input type="email" class="form-control" id="emailModificar" name="emailModificar" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="direccionModificar" class="form-label">Dirección</label>
                                                        <input type="text" class="form-control" id="direccionModificar" name="direccionModificar" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="fechaRegistroModificar" class="form-label">Fecha de Registro</label>
                                                        <input type="date" class="form-control" id="fechaRegistroModificar" name="fechaRegistroModificar" required>
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
                                <!-- Modal para Modificar Usuario -->
                                <a onclick="return eliminarUsuario()" href="usuarios.php?id=<?= $datos->id_usuario ?>" class="btn btn-small btn-danger"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        function abrirModalModificarUsuario(id, nombre, apellido, dni, telefono, email, direccion, fechaRegistro) {
            // Asignar los valores a los campos del modal
            document.getElementById('id_usuario').value = id;
            document.getElementById('nombreModificar').value = nombre;
            document.getElementById('apellidoModificar').value = apellido;
            document.getElementById('dniModificar').value = dni;
            document.getElementById('telefonoModificar').value = telefono;
            document.getElementById('emailModificar').value = email;
            document.getElementById('direccionModificar').value = direccion;
            document.getElementById('fechaRegistroModificar').value = fechaRegistro;

            // Mostrar el modal
            var modificarUsuarioModal = new bootstrap.Modal(document.getElementById('modificarUsuarioModal'));
            modificarUsuarioModal.show();
        }
    </script>
    <!-- Pie de página -->
    <footer>
        <p>&copy; Peru al plato</p>
    </footer>
</body>

</html>