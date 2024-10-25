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
                <li><a href="#" onclick="showSection('proveedores')">Proveedores</a></li>
            </ul>
        </nav>
        <main class="content">
            <h1>Bienvenido al Panel de Administración</h1>
            <p>Selecciona una opción del menú para comenzar.</p>

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
            <div id="empleados" class="section" style="display:none;">
                <h3>Empleados</h3>
                <p>Lista de empleados y sus detalles.</p>
            </div>

            <!-- Sección de Mesas -->
            <div id="mesas" class="section" style="display:none;">
                <h3>Mesas</h3>
                <p>Información sobre las mesas disponibles.</p>
            </div>

            <!-- Sección de Proveedores -->
            <div id="proveedores" class="section" style="display:none;">
                <h3>Proveedores</h3>
                <p>Detalles sobre los proveedores.</p>
            </div>
            <a href="../controlador/logout.php" class="btn btn-danger">Cerrar Sesión</a> <!-- Botón de cierre de sesión -->
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