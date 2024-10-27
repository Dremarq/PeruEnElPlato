<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/styles/admi.css">
    <title>Interfaz de Administrador</title>
</head>

<body>
    <script>
        function eliminarproducto(){
            var respuesta = confirm("¿Estás seguro que deseas eliminar?");
            return respuesta;
        }
    </script>
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
            <!-- Sección de Productos -->
            <?php 
            include "../config/conexion.php"; // Conexión a la bd
            include "../controlador/producto/registrar_producto.php"; // Controlador para registrar productos
            ?>
            <div id="productos" class="section">
                <a href="../vista/registro_producto.php"><button type="submit" class="btn btn-primary" name="btnregistrar" value="ok">Registrar</button></a>
                <h3>Lista de Productos</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripcion</th>
                            <th>Precio</th>
                            <th>Categoria</th>
                            <th>Img</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        // Mostrar todos los productos
                        $sql = $conexion->query("SELECT * FROM productos");
                        while($producto = $sql->fetch_object()){ ?>
                            <tr>
                                <td><?= $producto->id_producto ?></td>
                                <td><?= $producto->nombre ?></td>
                                <td><?= $producto->descripcion ?></td>
                                <td><?= $producto->precio ?></td>
                                <td><?= $producto->categoria ?></td>
                                <td><?= $producto->imagen ?></td>
                                <td><?= $producto->estado ?></td>
                                <td>
                                    <a href="modificar_producto.php?id=<?= $producto->id_producto ?>" class="btn btn-small btn-warning">Modificar</a>
                                    <a onclick="return eliminarproducto()" href="registro_producto.php?id=<?= $producto->id_producto ?>" class="btn btn-small btn-danger"><i class="fa-solid fa-trash">Eliminar</a>
                                    
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
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