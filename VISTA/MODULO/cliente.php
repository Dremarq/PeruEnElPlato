<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/admi.css">
    <script src="js/admi.js"></script>
    <title>Clientes</title>
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
                <li><a href="#" onclick="showSection('mesa')">Mesa</a></li>
                <li><a href="#" onclick="showSection('proveedores')">Proveedores</a></li>
            </ul>
        </nav>
        <main class="content">
            <h1>Bienvenido al Panel de Administración</h1>
            <p>Selecciona una opción del menú para comenzar.</p>
            <a href="../CONTROLADOR/CRUDclientes.php?action=create" class="btn btn-primary mb-3">Agregar Cliente</a>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>DNI</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th>Dirección</th>
                        <th>Fecha Registro</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($usuarios)) { ?>
                        <?php foreach ($usuarios as $usuario) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($usuario['id_usuario']); ?></td>
                                <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                                <td><?php echo htmlspecialchars($usuario['apellido']); ?></td>
                                <td><?php echo htmlspecialchars($usuario['dni']); ?></td>
                                <td><?php echo htmlspecialchars($usuario['telefono']); ?></td>
                                <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                                <td><?php echo htmlspecialchars($usuario['direccion']); ?></td>
                                <td><?php echo htmlspecialchars($usuario['fecha_registro']); ?></td>
                                <td>
                                    <a href="../CONTROLADOR/CRUDclientes.php?action=edit&id=<?php echo $usuario['id_usuario']; ?>" class="btn btn-warning">Editar</a>
                                    <a href="../CONTROLADOR/CRUDclientes.php?action=delete&id=<?php echo $usuario['id_usuario']; ?>" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este cliente?');">Eliminar</a>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                                <td colspan="9" class="text-center">No hay usuarios disponibles.</td>
                            </tr>
                    <?php } ?>
                </tbody>
            </table>
        </main>
    </div>

</body>

</html>