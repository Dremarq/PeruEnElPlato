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
        function eliminarproducto() {
            return confirm("¿Estás seguro que deseas eliminar?");
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
            <a href="../controlador/logout.php" class="btn btn-danger">Cerrar Sesión</a>

            <div id="productos" class="section" style="display: block;">
                <a href="../vista/registro_producto.php">
                    <button type="button" class="btn btn-primary">Registrar</button>
                </a>
                <h3>Lista de Productos</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Precio</th>
                            <th>Categoría</th>
                            <th>Img</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        include "../../config/conexion.php"; // Conexión a la bd

                        // Mostrar todos los productos
                        $sql = $conexion->query("SELECT * FROM productos");
                        while($producto = $sql->fetch_object()){ ?>
                            <tr>
                                <td><?= htmlspecialchars($producto->id_producto) ?></td>
                                <td><?= htmlspecialchars($producto->nombre) ?></td>
                                <td><?= htmlspecialchars($producto->descripcion) ?></td>
                                <td><?= htmlspecialchars($producto->precio) ?></td>
                                <td><?= htmlspecialchars($producto->categoria) ?></td>
                                <td><img src="<?= htmlspecialchars($producto->imagen) ?>" alt="<?= htmlspecialchars($producto->nombre) ?>" width="50"></td>
                                <td><?= $producto->estado ? 'Activo' : 'Inactivo' ?></td>
                                <td>
                                    <a href="modificar_producto.php?id=<?= $producto->id_producto ?>" class="btn btn-small btn-warning">Modificar</a>
                                    <a onclick="return eliminarproducto()" href="registro_producto.php?id=<?= $producto->id_producto ?>" class="btn btn-small btn-danger">Eliminar</a>
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
            const sections = document.querySelectorAll('.section');
            sections.forEach(section => {
                section.style.display = 'none';
            });
            document.getElementById(sectionId).style.display = 'block';
        }

        window.onload = function() {
            showSection('clientes');
        };
    </script>
</body>

</html>


