<?php
session_start();
require_once "../config/conexion.php";
require_once "../modelo/Cliente.php";

$clienteModelo = new Cliente($conexion);
$usuarios = $clienteModelo->obtenerUsuarios();
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
    
    <title>Interfaz de Administrador - Usuarios</title>
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
            <li><a href="../vista/pedidos.php">Pedidos</a></li>
            <li><a href="../vista/productos.php">Productos</a></li>
            <li><a href="../vista/platos.php">Platos</a></li>
            <li><a href="../vista/proveedores.php">Proveedores</a></li>
            <li><a href="../vista/reservas.php">Reservas</a></li>
            <li><a href="../vista/roles.php">Roles</a></li>
            <li><a href="">Usuarios</a></li>
        </ul>
    </nav>

    <!-- Contenido principal -->
    <div class="main-content">
        <h2>Registro de usuarios</h2>

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
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#registroModal">Registrar Usuario</button>

        <!-- Modal de registro -->
        <div class="modal fade" id="registroModal" tabindex="-1" aria-labelledby="registroModalLabel">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="registroModalLabel">Registro de Usuario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="../controlador/CRUDcliente.php" method="POST">
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
                                <input type="text" class="form-control" id="dni" name="dni" required>
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
                                <label for="usuario" class="form-label">usuario:</label>
                                <input type="text" class="form-control" id="usuario" name="usuario" required>
                            </div>
                            <div class="mb-3">
                                <label for="contrasena" class="form-label">contraseña:</label>
                                <input type="password" class="form-control" id="contrasena" name="contrasena" required>
                            </div>
                           
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de usuarios -->
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
                        <th>Dirección</th>
                        <th>usuario</th>
                        <th>contrasena</th>
                        <th>Fecha de Registro</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($usuario = $usuarios->fetch_object()): ?>
                        <tr>
                            <td><?= $usuario->id_usuario ?></td>
                            <td><?= $usuario->nombre ?></td>
                            <td><?= $usuario->apellido ?></td>
                            <td><?= $usuario->dni ?></td>
                            <td><?= $usuario->telefono ?></td>
                            <td><?= $usuario->email ?></td>
                            <td><?= $usuario->direccion ?></td>
                            <td><?= $usuario->usuario ?></td>
                            <td><?= $usuario->contrasena ?></td>
                            <td><?= $usuario->fecha_registro ?></td>
                            <td>
                                <a href="#" onclick="abrirModalModificarUsuario('<?= $usuario->id_usuario ?>', '<?= $usuario->nombre ?>', '<?= $usuario->apellido ?>', '<?= $usuario->dni ?>', '<?= $usuario->telefono ?>', '<?= $usuario->email ?>', '<?= $usuario->direccion ?>','<?= $usuario->usuario ?>','<?= $usuario->contrasena ?>')" class="btn btn-small btn-warning">
                                    <i class="fa-solid fa-pen-to-square"></i> 
                                </a>
                                <a onclick="return eliminarUsuario()" href="../controlador/CRUDcliente.php?accion=eliminar&id=<?= $usuario->id_usuario ?>" class="btn btn-small btn-danger">
                                    <i class="fa-solid fa-trash"></i> 
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Modal de modificación -->
        <div class="modal fade" id="modificarModal" tabindex="-1" aria-labelledby="modificarModalLabel">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modificarModalLabel">Modificar Usuario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="../controlador/CRUDcliente.php" method="POST">
                            <input type="hidden" name="accion" value="modificar">
                            <input type="hidden" id="id_usuario" name="id_usuario">
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
                                <input type="text" class="form-control" id="dniModificar" name="dni" required>
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
                                <label for="usuarioModificar" class="form-label">usuario:</label>
                                <input type="text" class="form-control" id="usuarioModificar" name="usuario" required>
                            </div>
                            <div class="mb-3">
                                <label for="contrasenaModificar" class="form-label">contraseña:</label>
                                <input type="password" class="form-control" id="contrasenaModificar" name="contrasena" required>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pie de página -->
        <footer>
            <p>&copy; Perú al plato</p>
        </footer>

        
        <script>
            function abrirModalModificarUsuario(id_usuario, nombre, apellido, dni, telefono, email, direccion,usuario, contrasena) {
                document.getElementById('id_usuario').value = id_usuario;
                document.getElementById('nombreModificar').value = nombre;
                document.getElementById('apellidoModificar').value = apellido;
                document.getElementById('dniModificar').value = dni;
                document.getElementById('telefonoModificar').value = telefono;
                document.getElementById('emailModificar').value = email;
                document.getElementById('direccionModificar').value = direccion;
                document.getElementById('usuarioModificar').value = usuario;
                document.getElementById('contrasenaModificar').value = contrasena;
                

                var modificarModal = new bootstrap.Modal(document.getElementById('modificarModal'));
                modificarModal.show();
            }
        </script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </div>
</body>

</html>
<script>
    // Función para formatear texto a mayúsculas y eliminar números
    function formatearTexto(input) {
        let valor = input.value;

        // Eliminar números
        valor = valor.replace(/[0-9]/g, '');

        // Convertir a mayúsculas y separar palabras
        valor = valor.split(' ').map(function (palabra) {
            return palabra.charAt(0).toUpperCase() + palabra.slice(1).toLowerCase();
        }).join(' ');

        // Asignar el valor formateado de nuevo al campo
        input.value = valor;
    }

    // Agregar evento al campo de nombre
    document.getElementById('nombre').addEventListener('input', function (e) {
        formatearTexto(e.target);
    });

    // Agregar evento al campo de apellido
    document.getElementById('apellido').addEventListener('input', function (e) {
        formatearTexto(e.target);
    });
     // Función para validar el DNI
     function validarDNI(input) {
        // Eliminar caracteres no válidos (solo permitir números)
        input.value = input.value.replace(/[^0-9]/g, '');

        // Limitar a 8 dígitos
        if (input.value.length > 8) {
            input.value = input.value.slice(0, 8); // Cortar a los primeros 8 dígitos
        }
    }

    // Agregar evento al campo de DNI
    document.getElementById('dni').addEventListener('input', function() {
        validarDNI(this);
    });

   // Función para validar el teléfono
   function validarTelefono(input) {
        // Eliminar caracteres no válidos (solo permitir números)
        input.value = input.value.replace(/[^0-9]/g, '');

        // Limitar a 9 dígitos
        if (input.value.length > 9) {
            input.value = input.value.slice(0, 9); // Cortar a los primeros 9 dígitos
        }

        // Asegurarse de que el primer dígito sea 9
        if (input.value.length === 1 && input.value !== '9') {
            input.value = ''; // Limpiar el campo si no empieza con 9
        }
    }

    // Agregar evento al campo de teléfono
    document.getElementById('telefono').addEventListener('input', function() {
        validarTelefono(this);
    });
</script>