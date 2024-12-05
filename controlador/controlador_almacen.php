<?php
// Incluir el modelo
require_once '../config/conexion.php';
require_once '../MODELO/modelo_almacen.php';
require_once '../vista/vista_almacen.php';  // Aquí pasa la variable productos al archivo vista
// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $id_producto = $_POST['id_producto'];
    $cantidad_pedir = $_POST['cantidadInsumo'];
    $fecha_llegada = $_POST['fechaLlegada'];
    $precio_total = $_POST['precioTotal'];
    // Insertar el nuevo registro en la base de datos
    insertarMantenimientoProducto($id_producto, $cantidad_pedir, $fecha_llegada, $precio_total);
}
// Obtener los productos y los registros de mantenimiento
$productos = obtenerProductos();
$mantenimientoProductos = obtenerMantenimientoProductos();
// Cargar la vista
require_once '../vista/vista_almacen.php';
?>