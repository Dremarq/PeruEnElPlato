<?php
// Incluir la conexión a la base de datos
require_once('../config/conexion.php');

// Definir el número de registros por página
$registrosPorPagina = 3;

// Obtener el número de página actual
$paginacion = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$inicio = ($paginacion - 1) * $registrosPorPagina;

// Función para obtener los platos vendidos hoy con LIMIT
function obtenerVentasHoy($inicio, $registrosPorPagina) {
    global $conexion;
    $query = "
        SELECT pvh.id_plato_vendido_hoy, pvh.id_plato, p.nombre, pvh.fecha, pvh.cant_vendida, p.precio
        FROM platos_vendidos_hoy pvh
        JOIN platos p ON pvh.id_plato = p.id_plato
        LIMIT $inicio, $registrosPorPagina
    ";
    return mysqli_query($conexion, $query);
}

// Función para obtener el total de registros de ventas para calcular la cantidad de páginas
function obtenerTotalVentasHoy() {
    global $conexion;
    $query = "
        SELECT COUNT(*) as total FROM platos_vendidos_hoy pvh
        JOIN platos p ON pvh.id_plato = p.id_plato
    ";
    $resultado = mysqli_query($conexion, $query);
    $total = mysqli_fetch_assoc($resultado);
    return $total['total'];
}

// Función para obtener los platos disponibles
function obtenerPlatos() {
    global $conexion;
    $query = "SELECT id_plato, nombre, precio FROM platos WHERE estado = 1";
    return mysqli_query($conexion, $query);
}

// Calcular el total de ventas y las páginas necesarias
$totalVentas = obtenerTotalVentasHoy();
$totalPaginas = ceil($totalVentas / $registrosPorPagina);

// Redirigir a la misma página después de registrar una venta
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['plato']) && isset($_POST['cantidad']) && isset($_POST['fecha'])) {
    require_once('../controlador/PlatoController.php');

    $plato = $_POST['plato'];
    $cantidad = $_POST['cantidad'];
    $fecha = $_POST['fecha'];

    // Suponiendo que registrarVenta es la función que maneja la inserción de la venta
    $registrado = registrarVenta($plato, $cantidad, $fecha);

    if ($registrado) {
        // Redirigir a la misma página
        header("Location: Mesero_V.php");
        exit(); // Importante para evitar que se ejecute más código después de la redirección
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil Mesero</title>
    <link rel="stylesheet" href="../public/styles/mesero.css">
    <link rel="stylesheet" href="../public/styles/mesero_v.css">
</head>
<body>
<header>
    <h1>Peru En El Plato - Vista Mesero</h1>
    <a href="../controlador/logout.php"> <button class="btn-cerrar">Cerrar Sesión</button></a>
 
</header>


<main>
    <div class="contenedor">
    <div class="mantenimiento">
    <h2 class="titulo-mantenimiento">Mantenimiento de Platos Vendidos Hoy</h2>
    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Id Plato</th>
                <th>Nombre del Plato</th>
                <th>Precio</th>
                <th>Fecha</th>
                <th>Cantidad Vendida</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Obtener las ventas realizadas hoy para la página actual
            $ventasHoy = obtenerVentasHoy($inicio, $registrosPorPagina);

            // Mostrar las ventas en la tabla
            while ($venta = mysqli_fetch_assoc($ventasHoy)) {
                echo "<tr>
                        <td>" . $venta['id_plato_vendido_hoy'] . "</td>
                        <td>" . $venta['id_plato'] . "</td>
                        <td>" . htmlspecialchars($venta['nombre']) . "</td>
                        <td>" . $venta['precio'] . "</td>
                        <td>" . $venta['fecha'] . "</td>
                        <td>" . $venta['cant_vendida'] . "</td>
                        <td>
                            <button class='btn-editar' data-id='" . $venta['id_plato_vendido_hoy'] . "'>Editar</button>
                            <br><br>
 
                            <button class='btn-eliminar' data-id='" . $venta['id_plato_vendido_hoy'] . "'>Eliminar</button>
                        </td>
                    </tr>";
            }
            ?>
            <!-- Navegación de Paginación -->
    <div class="paginacion">
        <?php if ($paginacion > 1): ?>
            <a href="?pagina=1">&laquo; Primero</a>
            <a href="?pagina=<?php echo $paginacion - 1; ?>">Anterior</a>
        <?php endif; ?>

        <span>Página <?php echo $paginacion; ?> de <?php echo $totalPaginas; ?></span>

        <?php if ($paginacion < $totalPaginas): ?>
            <a href="?pagina=<?php echo $paginacion + 1; ?>">Siguiente</a>
            <a href="?pagina=<?php echo $totalPaginas; ?>">Último &raquo;</a>
        <?php endif; ?>
    </div>
    <br>
        </tbody>
    </table>
</div>



   <!-- Formulario para editar las ventas (MODAL) -->
<div id="formulario-editar" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close" id="cancelarEdicion">&times;</span>
        <h2>Editar Venta</h2>
        <form id="editarVentaForm" method="POST">
            <input type="hidden" id="id_plato_vendido_hoy" name="id_plato_vendido_hoy">
            <label for="editarPlato">Plato:</label><br>
            <select id="editarPlato" name="plato" required>
                <option value="">Seleccione un Plato</option>
                <?php
                // Cargar todos los platos disponibles
                $platosDisponibles = obtenerPlatos(); 
                while ($plato = mysqli_fetch_assoc($platosDisponibles)) {
                    echo "<option value='" . $plato['id_plato'] . "' data-precio='" . $plato['precio'] . "'>" . htmlspecialchars($plato['nombre']) . "</option>";
                }
                ?>
            </select><br>

            <label for="editarCantidad">Cantidad Vendida:</label><br>
            <input type="number" id="editarCantidad" name="cantidad" required><br>

            <label for="editarFecha">Fecha de Venta:</label><br>
            <input type="date" id="editarFecha" name="fecha" required><br>

            <button type="submit" class="btn-actualizar">Actualizar Venta</button>
        </form>
    </div>
</div>

    <!-- Formulario para registrar nuevas ventas (siempre visible) -->
    <div class="registro-venta">
    <h2>Registro de Nueva Venta</h2>
    <form id="registroPlatos" method="POST" action="Mesero_V.php">
        <label for="plato">Plato:</label><br>
        <select id="plato" name="plato" required>
            <option value="">Seleccione un Plato</option>
            <?php
            // Cargar todos los platos disponibles
            $platosDisponibles = obtenerPlatos(); 
            while ($plato = mysqli_fetch_assoc($platosDisponibles)) {
                echo "<option value='" . $plato['id_plato'] . "' data-precio='" . $plato['precio'] . "'>" . htmlspecialchars($plato['nombre']) . "</option>";
            }
            ?>
        </select><br><br>

        <label for="cantidad">Cantidad Vendida:</label><br>
        <input type="number" id="cantidad" name="cantidad" required><br>
        <br>
        <label for="fecha">Fecha de Venta:</label><br>
        <input type="date" id="fecha" name="fecha" value="<?php echo date('Y-m-d'); ?>" required><br>

        <button type="submit" class="btn-actualizar">Registrar Venta</button>
    </form>
        </div>
    </div>
</main>

<script>
// Evento para mostrar el formulario de edición
document.querySelectorAll('.btn-editar').forEach(function(button) {
    button.addEventListener('click', function() {
        var id = this.getAttribute('data-id');
        
        // Obtener los detalles del plato vendido
        fetch('../controlador/PlatoController.php?id_plato_vendido_hoy=' + id)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Llenar los datos en el formulario de edición
                    document.getElementById('id_plato_vendido_hoy').value = data.venta.id_plato_vendido_hoy;
                    document.getElementById('editarPlato').value = data.venta.id_plato;
                    document.getElementById('editarCantidad').value = data.venta.cant_vendida;
                    document.getElementById('editarFecha').value = data.venta.fecha;
                    
                    // Mostrar el formulario de edición
                    document.getElementById('formulario-editar').style.display = 'block';
                }
            });
    });
});

// Cancelar la edición (cerrar el modal)
document.getElementById('cancelarEdicion').addEventListener('click', function() {
    document.getElementById('formulario-editar').style.display = 'none';
});

// Enviar el formulario de edición mediante AJAX
document.getElementById('editarVentaForm').addEventListener('submit', function(e) {
    e.preventDefault(); // Prevenir el envío normal del formulario

    var formData = new FormData(this); // Obtener los datos del formulario

    fetch('../controlador/PlatoController.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Venta actualizada correctamente.');
            // Actualizar la tabla de ventas (sin recargar la página)
            location.reload();
        } else {
            alert('Error al actualizar la venta.');
        }
    });
});

// Cerrar el modal si se hace clic fuera de él
window.onclick = function(event) {
    var modal = document.getElementById('formulario-editar');
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}
</script>
</body>
</html>

