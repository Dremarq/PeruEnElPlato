<?php
include "../config/conexion.php";
$id = $_GET["id"];
$sql = $conexion->query("SELECT * FROM empleados WHERE id_empleado = $id");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/styles/admi.css">
    <title>Modificar Empleado</title>
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
            <h1>Modificar Empleado</h1>
            <div class="container-fluid row">
                <form class="col-4 p-3" method="POST">
                    <input type="hidden" name="id" value="<?= $_GET["id"] ?>">
                    <?php 
                        include "../controlador/modificar_empleado.php"; // Controlador para modificar empleados
                        while ($datos = $sql->fetch_object()) { ?>
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" name="nombre" value="<?= $datos->nombre ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="apellido" class="form-label">Apellido</label>
                                <input type="text" class="form-control" name="apellido" value="<?= $datos->apellido ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="dni" class="form-label">DNI</label>
                                <input type="text" class="form-control" name="dni" value="<?= $datos->dni ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="text" class="form-control" name="telefono" value="<?= $datos->telefono ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="direccion" class="form-label">Dirección</label>
                                <input type="text" class="form-control" name="direccion" value="<?= $datos->direccion ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" value="<?= $datos->email ?>" required>
                            </div> 
                            <div class="mb-3">
                                <label for="id_rol" class="form-label">Rol</label>
                                <select class="form-select" name="id_rol" required>
                                    <option value="">Seleccionar Rol</option>
                                    <?php
                                    // Obtener los roles desde la base de datos
                                    $sql_roles = $conexion->query("SELECT * FROM roles");
                                    while ($rol = $sql_roles->fetch_object()) { ?>
                                        <option value="<?= $rol->id_rol ?>" <?= $rol->id_rol == $datos->id_rol ? 'selected' : '' ?>><?= $rol->nombre_rol ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        <?php } ?>
                    <button type="submit" class="btn btn-primary" name="btnmodificar" value="ok">Modificar</button>
                </form>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    <!-- Pie de página -->
    <footer>
        <p>&copy; Restaurant</p>
    </footer>
</body>
</html>

