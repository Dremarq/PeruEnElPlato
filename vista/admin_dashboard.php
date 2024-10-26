<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/styles/admi.css">
    <title>Interfaz de Administrador</title>
</head>

<body>
    <div class="container">
        <nav class="sidebar">
            <h2>Pantalla de Administrador</h2>
            <ul>
                <li><a href="#" onclick="showSection('clientes')">Clientes</a></li>
                <li><a href="#" onclick="showSection('caja')">Caja</a></li>
                <li><a href="#" onclick="showSection('almacen')">Almacén</a></li>
                <li><a href="#" onclick="showSection('empleados')">Empleados</a></li>
                <li><a href="#" onclick="showSection('mesas')">Mesas</a></li>
                
            </ul>
        </nav>
        <main class="content">
            <h1>Bienvenido al Panel de Administración</h1>
            <p>Selecciona una opción del menú para comenzar.</p>
            <a href="../controlador/logout.php" class="btn btn-danger">Cerrar Sesión</a> <!-- Botón de cierre de sesión -->

            <!-- Sección de Clientes -->
            <div id="clientes" class="section" style="display:none;">
                <h3>Clientes</h3>
                <table>
                    <thead>
                        <tr>
                            <th>ID Usuario</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>DNI</th>
                            <th>Teléfono</th>
                            <th>Email</th>
                            <th>Dirección</th>
                            <th>Fecha de Registro</th>
                        </tr>
                    </thead>
                
                </table>
            </div>

            <!-- Sección de Caja -->
            <div id="caja" class="section" style="display:none;">
                <h3>Caja</h3>
                <p>Información sobre las transacciones y el estado de la caja.</p>
            </div>

            <!-- Sección de Almacén -->
            <div id="almacen" class="section" style="display:none;">
                <h3>Almacén</h3>
                <p>Detalles sobre los productos en el almacén.</p>
            </div>

            <!-- Sección de Empleados -->
            <?php 
            include "../config/conexion.php"; // Conexión a la bd
            include "../controlador/registro_empleado.php"; // Controlador para registrar empleados
            ?>
            <div id="empleados" class="section">
                <a href="../vista/registro_empleado.php"><button type="submit" class="btn btn-primary" name="btnregistrar" value="ok">Registrar</button></a>
                <h3>Lista de Empleados</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>DNI</th>
                            <th>Teléfono</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        // Mostrar todos los empleados
                        $sql = $conexion->query("SELECT e.*, r.nombre_rol FROM empleados e LEFT JOIN roles r ON e.id_rol = r.id_rol");
                        while($empleado = $sql->fetch_object()){ ?>
                            <tr>
                                <td><?= $empleado->id_empleado ?></td>
                                <td><?= $empleado->nombre ?></td>
                                <td><?= $empleado->apellido ?></td>
                                <td><?= $empleado->dni ?></td>
                                <td><?= $empleado->telefono ?></td>
                                <td><?= $empleado->email ?></td>
                                <td><?= $empleado->nombre_rol ?></td>
                                <td>
                                    <a href="modificar_empleado.php?id=<?= $empleado->id_empleado ?>" class="btn btn-small btn-warning">Modificar</a>
                                    <a onclick="return eliminarempleado()" href="registro_empleado.php?id=<?= $empleado->id_empleado ?>" class="btn btn-small btn-danger"><i class="fa-solid fa-trash">Eliminar</a>
                                    
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

            <!-- Sección de Mesas -->
            <div id="mesas" class="section" style="display:none;">
                <h3>Mesas</h3>
                <p>Información sobre las mesas disponibles.</p>
            </div>

           
           
        </main>
    </div>

    <script>
        function showSection(sectionId) {
            // Ocultar todas las secciones
            const sections = document.querySelectorAll('.section');
            sections.forEach(section => {
                section.style.display = 'none';
            });

            // Mostrar la sección seleccionada
            document.getElementById(sectionId).style.display = 'block';
        }

        // Mostrar la sección de Clientes automáticamente al cargar la página
        window.onload = function() {
            showSection('clientes');
        };
    </script>
</body>

</html>