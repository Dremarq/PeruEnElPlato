<?php
session_start();
require_once "../config/conexion.php";
require_once "../modelo/proveedores.php";

$proveedorModelo = new Proveedor($conexion);
$proveedores = $proveedorModelo->obtenerProveedores();
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
    <script src="../public/JavaScript/proveedor.js"></script>
    <title>Interfaz de Administrador - Proveedores</title>
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
            <li><a href="">Proveedores</a></li>
            <li><a href="../vista/reservas.php">Reservas</a></li>
            <li><a href="../vista/roles.php">Roles</a></li>
            <li><a href="../vista/usuario.php">Usuarios</a></li>
        </ul>
    </nav>

    <!-- Contenido principal -->
    <div class="main-content">
        <h2>Registro de Proveedores</h2>

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
        <button type="button" class="btn" style="background-color: #e67e22; color: white;" onclick="location.href='../controlador/CRUDproveedores.php?accion=generar_pdf'">Generar PDF</button>
        <button type="button" class="btn" style="background-color: #2ecc71; color: white;" onclick="location.href='../controlador/CRUDproveedores.php?accion=generar_excel'">Generar Excel</button>

        <!-- Modal de registro -->
        <div class="modal fade" id="registroModal" tabindex="-1" aria-labelledby="registroModalLabel">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="registroModalLabel">Registro de Proveedor</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="../controlador/CRUDproveedores.php" method="POST">
                            <input type="hidden" name="accion" value="registrar">
                            <div class="mb-3">
                                <label for="nombre_empresa" class="form-label">Nombre de la Empresa:</label>
                                <input type="text" class="form-control" id="nombre_empresa" name="nombre_empresa" required>
                            </div>
                            <div class="mb-3">
                                <label for="ruc" class="form-label">RUC:</label>
                                <input type="text" class="form-control" id="ruc" name="ruc" required>
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
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de proveedores -->
        <div class="container-fluid">
            <table class="table">
                <thead class="bg-info">
                    <tr>
                        <th>ID</th>
                        <th>Nombre Empresa</th>
                        <th>RUC</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th>Dirección</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead> 
                <tbody>
                    <?php while ($proveedor = $proveedores->fetch_object()): ?>
                        <tr>
                            <td><?= $proveedor->id_proveedor ?></td>
                            <td><?= $proveedor->nombre_empresa ?></td>
                            <td><?= $proveedor->ruc ?></td>
                            <td><?= $proveedor->telefono ?></td>
                            <td><?= $proveedor->email ?></td>
                            <td><?= $proveedor->direccion ?></td>
                            <td><?= $proveedor->estado ? 'Activo' : 'Inactivo' ?></td>
                            <td>
                                <a href="#" onclick="abrirModalModificarProveedor('<?= $proveedor->id_proveedor ?>', '<?= $proveedor->nombre_empresa ?>', '<?= $proveedor->ruc ?>', '<?= $proveedor->telefono ?>', '<?= $proveedor->email ?>', '<?= $proveedor->direccion ?>', '<?= $proveedor->estado ?>')" class="btn btn-small btn-warning">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <a href="../controlador/CRUDproveedores.php?accion=eliminar&id=<?= $proveedor->id_proveedor ?>"
                                    onclick="return confirmarEliminacion()"
                                    class="btn btn-small btn-danger">
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
                        <h5 class="modal-title" id="modificarModalLabel">Modificar Proveedor</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="../controlador/CRUDproveedores.php" method="POST">
                            <input type="hidden" name="accion" value="modificar">
                            <input type="hidden" id="id_proveedor" name="id_proveedor">
                            <div class="mb-3">
                                <label for="nombre_empresaModificar" class="form-label">Nombre de la Empresa:</label>
                                <input type="text" class="form-control" id="nombre_empresaModificar" name="nombre_empresa" required>
                            </div>
                            <div class="mb-3">
                                <label for="rucModificar" class="form-label">RUC:</label>
                                <input type="text" class="form-control" id="rucModificar" name="ruc" required>
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
                                <label for="estadoModificar" class="form-label">Estado:</label>
                                <select class="form-select" id="estadoModificar" name="estado" required>
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
       

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="../public/JavaScript/proveedor.js"></script> 

        <!-- Pie de página -->
        <footer>
            <p>&copy; Peru al plato</p>
        </footer>
    </div>
</body>

</html>
