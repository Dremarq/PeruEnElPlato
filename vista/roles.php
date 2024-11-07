<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/styles/admi.css">
    <link rel="stylesheet" href="../public/styles/tablas.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/191a90e971.js" crossorigin="anonymous"></script>
    <title>Roles</title>
</head>
<body>
    <script>
        function eliminarRol() {
            var respuesta = confirm("¿Estás seguro que deseas eliminar este rol?");
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
            <li><a href="../vista/proveedores.php">Proveedores</a></li>
            <li><a href="../vista/reservas.php">Reservas</a></li>
            <li><a href="">Roles</a></li>
            <li><a href="../vista/usuario.php">Usuarios</a></li>
        </ul>
    </nav>

    <!-- Contenido principal -->
    <div class="main-content">
        <h2>Registro de Roles</h2>
        <?php 
        include "../config/conexion.php";
        include "../controlador/roles/eliminar_rol.php"; 

        // Ejecuta la consulta para obtener roles
        $query = "SELECT * FROM roles";
        $sql = $conexion->query($query);

        if (!$sql) {
            die("Error en la consulta: " . $conexion->error);
        }
        ?>
        <!-- Opciones de botones -->
        <a href="../controlador/logout.php" class="btn btn-danger">Cerrar Sesión</a> <!-- Botón de cierre de sesión -->
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#registroRolModal">Registrar Rol</button>

<!-- Modal -->
<div class="modal fade" id="registroRolModal" tabindex="-1" aria-labelledby="registroRolModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registroRolModalLabel">Registrar Rol</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formRegistroRol">
                    <div class="mb-3">
                        <label for="nombreRol" class="form-label">Nombre Rol</label>
                        <select class="form-select" id="nombreRol" name="nombreRol" required>
                            <option value="" disabled selected>Selecciona un rol</option>
                            <option value="administrador">Administrador</option>
                            <option value="mesero">Mesero</option>
                            <option value="chef">Chef</option>
                            <option value="jefe_inventario">Jefe de Inventario</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Registrar Rol</button>
                </form>
            </div>
        </div>
    </div>
</div>

        <div class="container-fluid">
            <!-- Tabla de roles -->
            <table class="table">
                <thead class="bg-info">
                    <tr>
                        <th scope="col">ID Rol</th>
                        <th scope="col">Nombre Empresa</th>
                        <th scope="col">Descripcion</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    while ($datos = $sql->fetch_object()) { ?>
                        <tr>
                            <td><?= $datos->id_rol ?></td>
                            <td><?= $datos->nombre_rol ?></td>
                            <td><?= $datos->descripcion ?></td>
                            <td>
    <a href="#" onclick="abrirModalModificarRol('<?= $datos->id_rol ?>', '<?= $datos->nombre_rol ?>', '<?= $datos->descripcion ?>')" class="btn btn-small btn-warning">
    <i class="fa-solid fa-pen-to-square"></i>
</a>
<!-- Modal para Modificar Rol -->
<div class="modal fade" id="modificarRolModal" tabindex="-1" aria-labelledby="modificarRolModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modificarRolModalLabel">Modificar Rol</h5>
            </div>
            <div class="modal-body">
                <form id="formModificarRol" action="#######" method="POST">
                    <input type="hidden" id="id_rol" name="id_rol"> <!-- Campo oculto para el ID del rol -->
                    <div class="mb-3">
                        <label for="nombreRolModificar" class="form-label">Nombre Rol</label>
                        <select class="form-select" id="nombreRolModificar" name="nombreRolModificar" required>
                            <option value="" disabled selected>Selecciona un rol</option>
                            <option value="administrador">Administrador</option>
                            <option value="mesero">Mesero</option>
                            <option value="chef">Chef</option>
                            <option value="jefe_inventario">Jefe de Inventario</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="descripcionModificar" class="form-label">Descripción</label>
                        <textarea class="form-control" id="descripcionModificar" name="descripcionModificar" rows="3" required></textarea>
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
<!-- Modal para Modificar Rol -->                               
                                <a onclick="return eliminarRol()" href="roles.php?id=<?= $datos->id_rol ?>" class="btn btn-small btn-danger"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>        
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
    function abrirModalModificarRol(id, nombreRol, descripcion) {
        // Asignar los valores a los campos del modal
        document.getElementById('id_rol').value = id;
        document.getElementById('nombreRolModificar').value = nombreRol;
        document.getElementById('descripcionModificar').value = descripcion;

        // Mostrar el modal
        var modificarRolModal = new bootstrap.Modal(document.getElementById('modificarRolModal'));
        modificarRolModal.show();
    }
</script>
    <!-- Pie de página -->
    <footer>
        <p>&copy; Peru al plato</p>
    </footer>
</body>
</html>
