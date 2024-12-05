<?php
session_start();
require_once "../config/conexion.php";
require_once "../modelo/Cliente.php";


$clienteModelo = new Cliente($conexion);
$usuarios = $clienteModelo->obtenerUsuarios();

$registrosPorPagina = 7; // Cambia este número según tus necesidades

// Obtener el número de página actual
$paginacion = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$inicio = ($paginacion - 1) * $registrosPorPagina;

// Modificar la consulta para obtener solo los registros necesarios
$usuarios = $clienteModelo->obtenerUsuariosLimit($inicio, $registrosPorPagina);

// Obtener el total de usuarios para calcular la cantidad de páginas
$totalUsuarios = $clienteModelo->contarUsuarios();
$totalPaginas = ceil($totalUsuarios / $registrosPorPagina);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/styles/admi.css">
    <link rel="stylesheet" href="../public/styles/tablas.css">
    <link rel="stylesheet" href="../public/styles/usuario.css">
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
        <a href="../controlador/logout.php" class="btn" style="background-color: #e74c3c; color: white;">Cerrar Sesión</a>
        <button type="button" class="btn" style="background-color: #3498db; color: white;" data-bs-toggle="modal" data-bs-target="#registroModal">Registrar</button>
        <button type="button" class="btn" style="background-color: #e67e22; color: white;" onclick="location.href='../controlador/CRUDcliente.php?accion=generar_pdf'">Generar PDF</button>
        <button type="button" class="btn" style="background-color: #2ecc71; color: white;" onclick="location.href='../controlador/generar_excel.php'">Generar Excel</button>
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
                                <label for="direccion" class="form-label">Cod. Postal:</label>
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
                        <th>Cod. Postal</th>
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
            <div class="paginacion">
    <?php if ($paginacion > 1): ?>
        <a href="?pagina=1" class="paginacion-link">&laquo; Primero</a>
        <a href="?pagina=<?php echo $paginacion - 1; ?>" class="paginacion-link">Anterior</a>
    <?php endif; ?>

    <span class="paginacion-info">Página <?php echo $paginacion; ?> de <?php echo $totalPaginas; ?></span>

    <?php if ($paginacion < $totalPaginas): ?>
        <a href="?pagina=<?php echo $paginacion + 1; ?>" class="paginacion-link">Siguiente</a>
        <a href="?pagina=<?php echo $totalPaginas; ?>" class="paginacion-link">Último &raquo;</a>
    <?php endif; ?>
</div>


        </div>
        <!-- Paginación -->


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
                                <label for="direccionModificar" class="form-label">Cod. Postal:</label>
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




        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="../public/JavaScript/usuario.js"></script>
    </div>
</body>

</html>