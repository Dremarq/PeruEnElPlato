<?php
session_start();
require_once "../config/conexion.php";
require_once "../modelo/almacen.php";

$almacenModelo = new Almacen($conexion);
$inventario = $almacenModelo->obtenerInventario();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/styles/admi.css">
    <link rel="stylesheet" href="../public/styles/tablas.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/191a90e971.js" crossorigin="anonymous"></script>
    <title>Interfaz de Administrador - Almacen</title>
</head>

<body>
    <!-- Menú lateral -->
    <nav class="sidebar">
        <h2>Pantalla de Administrador</h2>
        <ul>
            <li><a href="../vista/admin_dashboard.php">Dashboard - Perú en el plato</a></li>
            <li><a href="">Almacen</a></li>
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
        <h2>Almacen</h2>
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
        <button type="button" class="btn" style="background-color: #e67e22; color: white;" onclick="location.href='../controlador/generar_pdf.php'">Generar PDF</button>
        <button type="button" class="btn" style="background-color: #2ecc71; color: white;" onclick="location.href='../controlador/generar_excel.php'">Generar Excel</button>

       

        <!-- Modal de Registro -->
        <div class="modal fade" id="registroModal" tabindex="-1" aria-labelledby="registroModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="registroModalLabel">Registrar Nuevo Ingreso</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formRegistroAlmacen" action="../controlador/CRUDalmacen.php" method="POST">
                            <input type="hidden" name="accion" value="registrar">
                            <div class="mb-3">
                                <label for="id_producto" class="form-label">Producto</label>
                                <select class="form-select" id="id_producto" name="id_producto" required>
                                    <option value="">Seleccione un producto</option>
                                    <?php
                                    $productos = $almacenModelo->obtenerProductos();
                                    if ($productos && $productos->num_rows > 0) {
                                        while ($producto = $productos->fetch_object()) {
                                            echo "<option value='{$producto->id_producto}'>{$producto->nombre}</option>";
                                        }
                                    } else {
                                        echo "<option value='' disabled>No hay productos disponibles</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="stock_actual" class="form-label">Stock Actual</label>
                                <input type="number" class="form-control" id="stock_actual" name="stock_actual" required>
                            </div>
                            <div class="mb-3">
                                <label for="stock_minimo" class="form-label">Stock Mínimo</label>
                                <input type="number" class="form-control" id="stock_minimo" name="stock_minimo" required>
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
            <!-- Tabla de almacen -->
            <table class="table">
                <thead class="bg-info">
                    <tr>
                        <th scope="col">ID Almacén</th>
                        <th scope="col">ID Producto</th>
                        <th scope="col">Nombre Producto</th>
                        <th scope="col">Stock Actual</th>
                        <th scope="col">Stock Mínimo</th>
                        <th scope="col">Fecha de Actualización</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Verificar si hay inventario
                    if ($inventario && $inventario->num_rows > 0):
                        while ($item = $inventario->fetch_object()):
                    ?>
                            <tr>
                                <td><?= $item->id_almacen ?></td>
                                <td><?= $item->id_producto ?></td>
                                <td><?= $item->nombre_producto ?></td>
                                <td><?= $item->stock_actual ?></td>
                                <td><?= $item->stock_minimo ?></td>
                                <td><?= $item->fecha_actualizacion ?></td>
                                <td>
                                    <a href="#" onclick="abrirModalModificar('<?= $item->id_almacen ?>', '<?= $item->id_producto ?>', '<?= $item->nombre_producto ?>', '<?= $item->stock_actual ?>', '<?= $item->stock_minimo ?>')" class="btn btn-small btn-warning">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <a onclick="return eliminarProductoDeAlmacen()" href="../controlador/CRUDalmacen.php?accion=eliminar&id=<?= $item->id_almacen ?>" class="btn btn-small btn-danger">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php
                        endwhile;
                    else:
                        ?>
                        <tr>
                            <td colspan="7" class="text-center">
                                <div class="alert alert-info" role="alert">
                                    <i class="fas fa-info-circle me-2"></i>
                                    No hay productos registrados en el almacén actualmente
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

    <!-- Modal para Modificar Almacén -->
    <div class="modal fade" id="modificarModal" tabindex="-1" aria-labelledby="modificarModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modificarModalLabel">Modificar Producto en Almacén</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formModificarAlmacen" action="../controlador/CRUDalmacen.php" method="POST">
                        <input type="hidden" name="accion" value="modificar">
                        <input type="hidden" id="id_almacen" name="id_almacen"> <!-- Campo oculto para el ID del almacén -->
                        <div class="mb-3">
                            <label for="nombreModificar" class="form-label">Nombre del Producto</label>
                            <input type="text" class="form-control" id="nombreModificar" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="stock_actual_modificar" class="form-label">Stock Actual</label>
                            <input type="number" class="form-control" id="stock_actual_modificar" name="stock_actual" required>
                        </div>
                        <div class="mb-3">
                            <label for="stock_minimo_modificar" class="form-label">Stock Mínimo</label>
                            <input type="number" class="form-control" id="stock_minimo_modificar" name="stock_minimo" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Modificar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Pie de página -->
        <footer>
            <p> Peru al plato</p>
        </footer>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function abrirModalModificar(idAlmacen, idProducto, nombreProducto, stockActual, stockMinimo) {
            // Asignar los valores a los campos del modal
            document.getElementById('id_almacen').value = idAlmacen;
            document.getElementById('nombreModificar').value = nombreProducto;
            document.getElementById('stock_actual_modificar').value = stockActual;
            document.getElementById('stock_minimo_modificar').value = stockMinimo;

            // Mostrar el modal
            var modificarModal = new bootstrap.Modal(document.getElementById('modificarModal'));
            modificarModal.show();
        }

        function eliminarProductoDeAlmacen() {
            return confirm("¿Estás seguro que deseas eliminar este producto del almacén?");
        }
    </script>
    <script>
        function preventNegativeValue(input) {
            if (input.value < 0) {
                input.value = 0; // Si el valor es menor a 0, se establece en 0
            }
        }

        function validateStock(stockActualInput, stockMinimoInput) {
            const stockActual = parseInt(stockActualInput.value);
            const stockMinimo = parseInt(stockMinimoInput.value);

            if (stockActual > stockMinimo) {
                alert("El stock actual no puede ser mayor que el stock mínimo. Se ajustará al stock mínimo.");
                stockActualInput.value = stockMinimo; // Ajustar el stock actual al stock mínimo
            }
        }

        // Aplicar la función a los campos de registro
        const stockActual = document.getElementById('stock_actual');
        const stockMinimo = document.getElementById('stock_minimo');

        stockActual.addEventListener('input', function() {
            preventNegativeValue(this);
            validateStock(stockActual, stockMinimo);
        });

        stockMinimo.addEventListener('input', function() {
            preventNegativeValue(this);
            validateStock(stockActual, stockMinimo);
        });

        // Aplicar la función a los campos de modificación
        const stockActualModificar = document.getElementById('stock_actual_modificar');
        const stockMinimoModificar = document.getElementById('stock_minimo_modificar');

        stockActualModificar.addEventListener('input', function() {
            preventNegativeValue(this);
            validateStock(stockActualModificar, stockMinimoModificar);
        });

        stockMinimoModificar.addEventListener('input', function() {
            preventNegativeValue(this);
            validateStock(stockActualModificar, stockMinimoModificar);
        });
    </script>

</body>

</html>