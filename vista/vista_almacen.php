<?php
// Incluir el archivo de conexión a la base de datos
require_once '../config/conexion.php';  // Asegúrate de que la ruta a la conexión sea correcta
// Incluir el archivo de modelo para acceder a las funciones
require_once '../modelo/modelo_almacen.php';  // Asegúrate de que la ruta sea correcta
// Obtener los productos de mantenimiento
$mantenimientoProductos = obtenerMantenimientoProductos();
// Obtener todos los productos para el formulario de solicitud
$productos = obtenerProductos();
// Definir el número de registros por página
$registrosPorPagina = 3;
// Obtener el número de página actual
$paginacion = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$inicio = ($paginacion - 1) * $registrosPorPagina;
// Calcular el total de productos para la paginación
$totalProductos = count($mantenimientoProductos); // Aquí usamos el array de productos
$totalPaginas = ceil($totalProductos / $registrosPorPagina); // Calcular el número total de páginas
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil Almacen</title>
    <link rel="stylesheet" href="../public/styles/almacen.css"> <!-- Vinculación del archivo CSS -->
</head>
<body>
<header>
    <h1>Peru En El Plato - Vista Almacen</h1>
    <button class="btn-cerrar">Cerrar Sesión</button>
</header>
<main>
    <h2>Mantenimiento de Productos</h2>
    
    <!-- Tabla de Mantenimiento Productos -->
    <table>
    <thead>
        <tr>
            <th>ID Producto</th>
            <th>Nombre</th>
            <th>Cantidad</th>
            <th>Fecha Llegada</th>
            <th>Precio Total</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Aquí se mostrará la lista de productos registrados en mantenimiento
        // Añadimos el límite de los productos que se deben mostrar
        $productosMostrados = array_slice($mantenimientoProductos, $inicio, $registrosPorPagina);
        
        foreach ($productosMostrados as $producto) {
            echo "<tr>";
            echo "<td>{$producto['id_producto']}</td>"; // Ahora debe funcionar correctamente
            echo "<td>{$producto['nombre']}</td>";
            echo "<td>{$producto['cantidad_pedir']}</td>";
            echo "<td>{$producto['fecha_llegada']}</td>";
            echo "<td>{$producto['precio_total']}</td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>
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
<h2>Solicitud de Productos</h2>
<form id="solicitudProductos" method="POST" action="../controlador/controlador_almacen.php">
    <label for="nombreInsumo">Nombre del Insumo:</label><br>
    <select id="nombreInsumo" name="id_producto" required>
        <option value="">Seleccione un Producto</option>
        <?php if (!empty($productos)) { ?>
            <?php foreach ($productos as $producto) { ?>
                <option value="<?php echo $producto['id_producto']; ?>" data-precio="<?php echo $producto['costo']; ?>">
                    <?php echo $producto['nombre']; ?>
                </option>
            <?php } ?>
        <?php } else { ?>
            <option value="">No hay productos disponibles</option>
        <?php } ?>
    </select><br>
    
    <label for="cantidadInsumo">Cantidad:</label><br>
    <input type="number" id="cantidadInsumo" name="cantidadInsumo" required><br>
    <label for="fechaLlegada">Fecha Llegada:</label><br>
    <input type="date" id="fechaLlegada" name="fechaLlegada" required><br>
    <label for="precioTotal">Precio Total:</label><br>
    <input type="number" id="precioTotal" name="precioTotal" readonly><br>
    <div class="btn-container">
        <button type="submit" class="btn-actualizar">Enviar</button>
        <button type="button" class="btn-cerrar">Generar PDF</button>
    </div>
</form>
</main>
<script>
    // Función para actualizar el precio total cuando se selecciona un producto
    document.getElementById("nombreInsumo").addEventListener("change", function() {
        var selectedOption = this.options[this.selectedIndex];
        var precio = selectedOption.getAttribute("data-precio"); // Obtener el costo desde el atributo data-precio
        document.getElementById("precioTotal").value = precio; // Actualizar el campo de precio total con el costo del producto
    });
    // Validación de cantidad
    document.getElementById("cantidadInsumo").addEventListener("input", function() {
        var cantidad = this.value;
        if (cantidad < 0 || !Number.isInteger(Number(cantidad))) {
            alert("La cantidad debe ser un número entero positivo.");
            this.value = ""; // Limpiar el campo en caso de error
        }
    });
</script>
</body>
</html>