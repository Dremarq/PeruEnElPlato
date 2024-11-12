<?php
session_start();
require_once "../config/conexion.php";
require_once "../modelo/Producto.php";

$productoModelo = new Producto($conexion);
$productos = $productoModelo->obtenerProductos();
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
    <script src="../public/JavaScript/producto.js"></script>
    <title>Interfaz de Administrador - Productos</title>
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
            <li><a href="">Productos</a></li>
            <li><a href="../vista/proveedores.php">Proveedores</a></li>
            <li><a href="../vista/reservas.php">Reservas</a></li>
            <li><a href="../vista/roles.php">Roles</a></li>
            <li><a href="../vista/usuario.php">Usuarios</a></li>
        </ul>
    </nav>

    <!-- Contenido principal -->
    <div class="main-content">
        <h2>Registro de productos</h2>

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
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#registroModal">Registrar Producto</button>

        <!-- Modal de registro -->
        <div class="modal fade" id="registroModal" tabindex="-1" aria-labelledby="registroModalLabel">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="registroModalLabel">Registro de Producto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="../controlador/CRUDproductos.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="accion" value="registrar">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre:</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <div class="mb-3">
                                <label for="descripcion" class="form-label">Descripción:</label>
                                <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="precio" class="form-label">Precio:</label>
                                <input type="number" class="form-control" id="precio" name="precio" step="0.01" required>
                            </div>
                            <div class="mb-3">
                                <label for="categoria" class="form-label">Categoría:</label>
                                <select class="form-select" id="categoria" name="categoria" required>
                                    <option value="">Seleccione una categoría</option>
                                    <option value="Entrada">Entrada</option>
                                    <option value="Plato Principal">Plato Principal</option>
                                    <option value="Bebida">Bebida</option>
                                    <option value="Postre">Postre</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="imagen" class="form-label">Imagen:</label>
                                <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
                            </div>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de productos -->
        <div class="container-fluid">
            <table class="table">
                <thead class="bg-info">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Categoría</th>
                        <th>Imagen</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($producto = $productos->fetch_object()): ?>
                        <tr>
                            <td><?= $producto->id_producto ?></td>
                            <td><?= $producto->nombre ?></td>
                            <td><?= $producto->descripcion ?></td>
                            <td><?= $producto->precio ?></td>
                            <td><?= $producto->categoria ?></td>
                            <td><img src="<?= $producto->imagen ?>" alt="<?= $producto->nombre ?>" style="width: 50px; height: auto;"></td>
                            <td><?= $producto->estado ? 'Activo' : 'Inactivo' ?></td>
                            <td>
                                <a href="#" onclick="abrirModalModificarProducto('<?= $producto->id_producto ?>', '<?= $producto->nombre ?>', '<?= $producto->descripcion ?>', '<?= $producto->precio ?>', '<?= $producto->categoria ?>', '<?= $producto->estado ?>')" class="btn btn-small btn-warning">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <a href="../controlador/CRUDproductos.php?accion=eliminar&id=<?= $producto->id_producto ?>"
                                    onclick="return elim inaProducto(<?= $producto->id_producto ?>)" class="btn btn-small btn-danger">
                                    <i class="fa-solid fa-trash-can"></i>
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
                        <h5 class="modal-title" id="modificarModalLabel">Modificar Producto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="../controlador/CRUDproductos.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="accion" value="modificar">
                            <input type="hidden" id="id_producto" name="id_producto">
                            <div class="mb-3">
                                <label for="nombreModificar" class="form-label">Nombre:</label>
                                <input type="text" class="form-control" id="nombreModificar" name="nombre" required>
                            </div>
                            <div class="mb-3">
                                <label for="descripcionModificar" class="form-label">Descripción:</label>
                                <textarea class="form-control" id="descripcionModificar" name="descripcion" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="precioModificar" class="form-label">Precio:</label>
                                <input type="number" class="form-control" id="precioModificar" name="precio" step="0.01" required>
                            </div>
                            <div class="mb-3">
                                <label for="categoriaModificar" class="form-label">Categoría:</label>
                                <select class="form-select" id="categoriaModificar" name="categoria" required>
                                    <option value="">Seleccione una categoría</option>
                                    <option value="Entrada">Entrada</option>
                                    <option value="Plato Principal">Plato Principal</option>
                                    <option value="Bebida">Bebida</option>
                                    <option value="Postre">Postre</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="imagenModificar" class="form-label">Imagen:</label>
                                <input type="file" class="form-control" id="imagenModificar" name="imagen" accept="image/*">
                            </div>
                            <div class="mb-3">
                                <label for="estadoModificar" class="form-label">Estado:</label>
                                <select class="form-select" id="estadoModificar" name="estado" required>
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary">Guardar cambios</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function abrirModalModificarProducto(id, nombre, descripcion, precio, categoria, estado) {
                // Obtener referencias a los campos del formulario de modificación
                document.getElementById('id_producto').value = id;
                document.getElementById('nombreModificar').value = nombre;
                document.getElementById('descripcionModificar').value = descripcion;
                document.getElementById('precioModificar').value = precio;
                document.getElementById('categoriaModificar').value = categoria;
                document.getElementById('estadoModificar').value = estado;

                // Mostrar el modal
                var modificarModal = new bootstrap.Modal(document.getElementById('modificarModal'));
                modificarModal.show();
            }

            function eliminarProducto() {
                return confirm("¿Estás seguro que deseas eliminar este producto?");
            }
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

    </div>
</body>

</html>