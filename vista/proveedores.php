<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/styles/admi.css">
    <link rel="stylesheet" href="../public/styles/tablas.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/191a90e971.js" crossorigin="anonymous"></script>
    <title>Proveedores</title>
</head>
<body>
    <script>
        function eliminarProveedor() {
            var respuesta = confirm("¿Estás seguro que deseas eliminar este proveedor?");
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
            <li><a href="../vista/productos.php">Productos</a></li>
            <li><a href="">Proveedores</a></li>
            <li><a href="../vista/reservas.php">Reservas</a></li>
            <li><a href="../vista/roles.php">Roles</a></li>
            <li><a href="../vista/usuarios.php">Usuarios</a></li>
        </ul>
    </nav>

    <!-- Contenido principal -->
    <div class="main-content">
        <h2>Registro de Proveedores</h2>
        <?php 
        include "../config/conexion.php";
        include "../controlador/proveedores/eliminar_proveedor.php"; 

        // Consulta para obtener proveedores
        $query = "SELECT * FROM proveedores";
        $sql = $conexion->query($query);

        if (!$sql) {
            die("Error en la consulta: " . $conexion->error);
        }
        ?>
        <!-- Opciones de botones -->
        <a href="../controlador/logout.php" class="btn btn-danger">Cerrar Sesión</a> <!-- Botón de cierre de sesión -->
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#registroProveedorModal">Registrar Proveedor</button>

<!-- Modal -->
<div class="modal fade" id="registroProveedorModal" tabindex="-1" aria-labelledby="registroProveedorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registroProveedorModalLabel">Registrar Proveedor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formRegistroProveedor">
                    <div class="mb-3">
                        <label for="nombreEmpresa" class="form-label">Nombre de Empresa</label>
                        <input type="text" class="form-control" id="nombreEmpresa" name="nombreEmpresa" required>
                    </div>
                    <div class="mb-3">
                        <label for="ruc" class="form-label">RUC</label>
                        <input type="text" class="form-control" id="ruc" name="ruc" required>
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
                        <label for="estado" class="form-label">Estado</label>
                        <select class="form-select" id="estado" name="estado" required>
                            <option value="activo">Activo</option>
                            <option value="inactivo">Inactivo</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Registrar Proveedor</button>
                </form>
            </div>
        </div>
    </div>
</div>

        <div class="container-fluid">
            <!-- Tabla de proveedores -->
            <table class="table">
                <thead class="bg-info">
                    <tr>
                        <th scope="col">ID Proveedor</th>
                        <th scope="col">Nombre Empresa</th>
                        <th scope="col">RUC</th>
                        <th scope="col">Teléfono</th>
                        <th scope="col">Email</th>
                        <th scope="col">Dirección</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    while ($datos = $sql->fetch_object()) { ?>
                        <tr>
                            <td><?= $datos->id_proveedor ?></td>
                            <td><?= $datos->nombre_empresa ?></td>
                            <td><?= $datos->ruc ?></td>
                            <td><?= $datos->telefono ?></td>
                            <td><?= $datos->email ?></td>
                            <td><?= $datos->direccion ?></td>
                            <td><?= $datos->estado ? 'Activo' : 'Inactivo' ?></td>
                            <td>
    <a href="#" onclick="abrirModalModificarProveedor('<?= $datos->id_proveedor ?>', '<?= $datos->nombre_empresa ?>', '<?= $datos->ruc ?>', '<?= $datos->telefono ?>', '<?= $datos->email ?>', '<?= $datos->direccion ?>', '<?= $datos->estado ?>')" class="btn btn-small btn-warning">
    <i class="fa-solid fa-pen-to-square"></i>
</a>
<!-- Modal para Modificar Proveedor -->
<div class="modal fade" id="modificarProveedorModal" tabindex="-1" aria-labelledby="modificarProveedorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modificarProveedorModalLabel">Modificar Proveedor</h5>
            </div>
            <div class="modal-body">
                <form id="formModificarProveedor" action="#######" method="POST">
                    <input type="hidden" id="id_proveedor" name="id_proveedor"> <!-- Campo oculto para el ID del proveedor -->
                    <div class="mb-3">
                        <label for="nombreEmpresaModificar" class="form-label">Nombre de Empresa</label>
                        <input type="text" class="form-control" id="nombreEmpresaModificar" name="nombreEmpresaModificar" required>
                    </div>
                    <div class="mb-3">
                        <label for="rucModificar" class="form-label">RUC</label>
                        <input type="text" class="form-control" id="rucModificar" name="rucModificar" required>
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
<!-- Modal para Modificar Proveedor -->                               
                                
                                
                                
                                
                                <a onclick="return eliminarProveedor()" href="proveedores.php?id=<?= $datos->id_proveedor ?>" class="btn btn-small btn-danger"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>        
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
    function abrirModalModificarProveedor(id, nombreEmpresa, ruc, telefono, email, direccion, estado) {
        // Asignar los valores a los campos del modal
        document.getElementById('id_proveedor').value = id;
        document.getElementById('nombreEmpresaModificar').value = nombreEmpresa;
        document.getElementById('rucModificar').value = ruc;
        document.getElementById('telefonoModificar').value = telefono;
        document.getElementById('emailModificar').value = email;
        document.getElementById('direccionModificar').value = direccion;
        document.getElementById('estadoModificar').value = estado;

        // Mostrar el modal
        var modificarProveedorModal = new bootstrap.Modal(document.getElementById('modificarProveedorModal'));
        modificarProveedorModal.show();
    }
</script>
    <!-- Pie de página -->
    <footer>
        <p>&copy; Peru al plato</p>
    </footer>
</body>
</html>
