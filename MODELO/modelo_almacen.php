<?php
// Incluir el archivo de conexión a la base de datos
require_once '../config/conexion.php';  // Asegúrate de que la ruta sea correcta
// Obtener todos los productos
function obtenerProductos() {
    global $conexion;
    // Cambiar 'precio' por 'costo'
    $query = "SELECT id_producto, nombre, costo FROM productos WHERE estado = 1";
    $resultado = mysqli_query($conexion, $query);
    $productos = [];
    while ($row = mysqli_fetch_assoc($resultado)) {
        $productos[] = $row;
    }
    return $productos;
}
// Obtener todos los registros de mantenimiento de productos
function obtenerMantenimientoProductos() {
    global $conexion;  // Usamos la variable $conexion
    $sql = "SELECT mp.id_mant_prod, mp.id_producto, p.nombre, mp.cantidad_pedir, mp.fecha_llegada, mp.precio_total
        FROM mantenimiento_productos mp
        INNER JOIN productos p ON mp.id_producto = p.id_producto";
    $result = $conexion->query($sql);  // Cambiado de $conn a $conexion
    return $result->fetch_all(MYSQLI_ASSOC);
}
// Insertar un nuevo mantenimiento de producto
function insertarMantenimientoProducto($id_producto, $cantidad_pedir, $fecha_llegada, $precio_total) {
    global $conexion;  // Usamos la variable $conexion
    $sql = "INSERT INTO mantenimiento_productos (id_producto, cantidad_pedir, fecha_llegada, precio_total)
            VALUES (?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);  // Cambiado de $conn a $conexion
    $stmt->bind_param("iisd", $id_producto, $cantidad_pedir, $fecha_llegada, $precio_total);
    $stmt->execute();
}
?>