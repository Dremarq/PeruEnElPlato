<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/styles/admi.css">
    <title>Registro de Clientes</title>
</head>

<body>
    <script>
        function eliminarcliente(){
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
                <li><a href="#" onclick="showSection('proveedores')">Proveedores</a></li>
            </ul>
        </nav>
        <main class="content">
            <h1>Registro de Clientes</h1>

            <?php 
            include "../config/conexion.php"; // Conexión a la bd
            include "../controlador/clientes/registro_cliente.php"; // Controlador para registrar clientes
            ?>

            <form method="POST" class="mb-4">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" name="nombre" required>
                </div>
                <div class="mb-3">
                    <label for="apellido" class="form-label">Apellido</label>
                    <input type="text" class="form-control" name="apellido" required>
                </div>
                <div class="mb-3">
                    <label for="dni" class="form-label">DNI</label>
                    <input type="text" class="form-control" name="dni" required>
                </div>
                <div class="mb-3">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="text" class="form-control" name="telefono" required>
                </div>
                <div class="mb-3">
                    <label for="direccion" class="form-label">Dirección</label>
                    <input type="text" class="form-control" name="direccion" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="id_rol" class="form-label">Rol</label>
                    <select class="form-select" name="id_rol" required>
                        <option value="">Seleccionar Rol</option>
                        <?php
                        // Obtener los roles desde la bd
                        $sql_roles = $conexion->query("SELECT * FROM roles");
                        while($rol = $sql_roles->fetch_object()){ ?>
                            <option value="<?= $rol->id_rol ?>"><?= $rol->nombre_rol ?></option>
                        <?php } ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" name="btnregistrar" value="ok">Registrar</button>
            </form>

            
</body>

</html>
