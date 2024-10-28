<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/styles/admi.css">
    <link rel="stylesheet" href="../public/styles/tablas.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/191a90e971.js" crossorigin="anonymous"></script>
    <title>Interfaz de Administrador</title>
</head>
<body>
    <script>
        function eliminarProducto() {
            var respuesta = confirm("¿Estás seguro que deseas eliminar?");
            return respuesta;
        }
    </script>

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
            <li><a href="../vista/usuarios.php">Usuarios</a></li>
        </ul>
    </nav>

    <!-- Contenido principal -->
    <div class="content">
        <h2>Registro de productos</h2>
        <?php 
        include "../config/conexion.php";
        include "../controlador/producto/eliminar_producto.php";

        // Consulta para obtener productos
        $query = "SELECT * FROM productos";
        $sql = $conexion->query($query);

        if (!$sql) {
            die("Error en la consulta: " . $conexion->error);
        }
        ?>
        <!-- Opciones de botones -->
        <a href="../controlador/logout.php" class="btn btn-danger">Cerrar Sesión</a> <!-- Botón de cierre de sesión -->
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#registroModal">Registrar Producto</button>

<!-- Modal -->
<div class="modal fade" id="registroModal" tabindex="-1" aria-labelledby="registroModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registroModalLabel">Registrar Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formRegistroProducto" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="precio" class="form-label">Precio</label>
                        <input type="number" class="form-control" id="precio" name="precio" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="categoria" class="form-label">Categoría</label>
                        <select class="form-select" id="categoria" name="categoria" required>
                            <option value="" disabled selected>Selecciona una categoría</option>
                            <option value="categoria1">Entrada</option>
                            <option value="categoria2">Plato Principal</option>
                            <option value="categoria3">Bebida</option>
                            <option value="categoria4">Postre</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="imagen" class="form-label">Subir Imagen</label>
                        <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*" required>
                    </div>
                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        <select class="form-select" id="estado" name="estado" required>
                            <option value="activo">Activo</option>
                            <option value="inactivo">Inactivo</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Registrar Producto</button>
                </form>
            </div>
        </div>
    </div>
</div>

        <div class="container-fluid">
            <!-- Tabla de productos -->
            <table class="table">
                <thead class="bg-info">
                    <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Descripcion</th>
                    <th scope="col">Precio</th>
                    <th scope="col">Categoria</th>
                    <th scope="col">Imagen</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    // Filtrar resultados según la búsqueda
                    while ($datos = $sql->fetch_object()) { ?>
                        <tr>
                            <td><?= $datos->id_producto ?></td>
                            <td><?= $datos->nombre ?></td>
                            <td><?= $datos->descripcion ?></td>
                            <td><?= $datos->precio ?></td>
                            <td><?= $datos->categoria ?></td>
                            <td><img src="<?= $datos->imagen ?>" alt="<?= $datos->nombre ?>" style="width: 50px; height: auto;"></td>
                            <td><?= $datos->estado ?></td>
                            <td>
    <a href="#" onclick="abrirModalModificarProducto('<?= $datos->id_producto ?>', '<?= $datos->nombre ?>', '<?= $datos->descripcion ?>', '<?= $datos->precio ?>', '<?= $datos->categoria ?>', '<?= $datos->estado ?>')" class="btn btn-small btn-warning">
    <i class="fa-solid fa-pen-to-square"></i>
</a>
<!-- Modal para Modificar Producto -->
<div class="modal fade" id="modificarProductoModal" tabindex="-1" aria-labelledby="modificarProductoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modificarProductoModalLabel">Modificar Producto</h5>
            </div>
            <div class="modal-body">
                <form id="formModificarProducto" action="#######" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="id_producto" name="id_producto"> <!-- Campo oculto para el ID del producto -->
                    <div class="mb-3">
                        <label for="nombreModificar" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombreModificar" name="nombreModificar" required>
                    </div>
                    <div class="mb-3">
                        <label for="descripcionModificar" class="form-label">Descripción</label>
                        <textarea class="form-control" id="descripcionModificar" name="descripcionModificar" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="precioModificar" class="form-label">Precio</label>
                        <input type="number" class="form-control" id="precioModificar" name="precioModificar" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="categoriaModificar" class="form-label">Categoría</label>
                        <select class="form-select" id="categoriaModificar" name="categoriaModificar" required>
                            <option value="" disabled selected>Selecciona una categoría</option>
                            <option value="categoria1">Entrada</option>
                            <option value="categoria2">Plato Principal</option>
                            <option value="categoria3">Bebida</option>
                            <option value="categoria4">Postre</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="estadoModificar" class="form-label">Estado</label>
                        <select class="form-select" id="estadoModificar" name="estadoModificar" required>
                            <option value="activo">Activo</option>
                            <option value="inactivo">Inactivo</option>
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
<!-- Modal para Modificar Producto -->                                

                                <a onclick="return eliminarProducto()" href="productos.php?id=<?= $datos->id_producto ?>" class="btn btn-small btn-danger"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>        
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
    function abrirModalModificarProducto(id, nombre, descripcion, precio, categoria, estado) {
        // Asignar los valores a los campos del modal
        document.getElementById('id_producto').value = id;
        document.getElementById('nombreModificar').value = nombre;
        document.getElementById('descripcionModificar').value = descripcion;
        document.getElementById('precioModificar').value = precio;
        document.getElementById('categoriaModificar').value = categoria;
        document.getElementById('estadoModificar').value = estado;

        // Mostrar el modal
        var modificarProductoModal = new bootstrap.Modal(document.getElementById('modificarProductoModal'));
        modificarProductoModal.show();
    }
</script>
    <!-- Pie de página -->
    <footer>
        <p>&copy; Peru al plato</p>
    </footer>
</body>
</html>
