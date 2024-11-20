<?php
session_start();
require_once "../config/conexion.php";
require_once "../modelo/rol.php";

$rolModelo = new Rol($conexion);
$roles = $rolModelo->obtenerRoles();
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

    <title>Interfaz de Administrador - Roles</title>
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
            <li><a href="../vista/usuario.php">Usuarios</a></li>
        </ul>
    </nav>

    <!-- Contenido principal -->
    <div class="main-content">
        <h2>Gestión de Roles</h2>

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
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#registroModal">Registrar Rol</button>

        <!-- Modal de registro -->
        <div class="modal fade" id="registroModal" tabindex="-1" aria-labelledby="registroModalLabel">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="registroModalLabel">Registrar Rol</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="../controlador/CRUDrol.php" method="POST">
                            <input type="hidden" name="accion" value="registrar">
                            <div class="mb-3">
                                <label for="nombre_rol" class="form-label">Nombre del Rol:</label>
                                <input type="text" class="form-control" id="nombre_rol" name="nombre_rol" required>
                            </div>
                            <div class="mb-3">
                                <label for="descripcion" class="form-label">Descripción:</label>
                                <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de roles -->
        <div class="container-fluid">
            <table class="table">
                <thead class="bg-info">
                    <tr>
                        <th>ID</th>
                        <th>Nombre del Rol</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                        </ tr>
                </thead>
                <tbody>
                    <?php while ($rol = $roles->fetch_assoc()): ?>
                        <tr>
                            <td><?= $rol['id_rol'] ?></td>
                            <td><?= $rol['nombre_rol'] ?></td>
                            <td><?= $rol['descripcion'] ?></td>
                            <td>
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modificarModal<?= $rol['id_rol'] ?>"><i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <a href="../controlador/CRUDrol.php?accion=eliminar&id=<?= $rol['id_rol'] ?>" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este rol?');"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>

                        <!-- Modal de modificación -->
                        <div class="modal fade" id="modificarModal<?= $rol['id_rol'] ?>" tabindex="-1" aria-labelledby="modificarModalLabel">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modificarModalLabel">Modificar Rol</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="../controlador/CRUDrol.php" method="POST">
                                            <input type="hidden" name="accion" value="modificar">
                                            <input type="hidden" name="id_rol" value="<?= $rol['id_rol'] ?>">
                                            <div class="mb-3">
                                                <label for="nombre_rol" class="form-label">Nombre del Rol:</label>
                                                <input type="text" class="form-control" id="nombre_rol" name="nombre_rol" value="<?= $rol['nombre_rol'] ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="descripcion" class="form-label">Descripción:</label>
                                                <textarea class="form-control" id="descripcion" name="descripcion" required><?= $rol['descripcion'] ?></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Actualizar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        document.getElementById('id_rol').value = id;
        document.getElementById('nombreRolModificar').value = nombreRol;
        document.getElementById('descripcionModificar').value = descripcion;
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>