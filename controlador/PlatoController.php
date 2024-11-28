<?php
require_once('../config/conexion.php');

// Función para registrar una venta
function registrarVenta($plato, $cantidad, $fecha) {
    global $conexion;
    
    $query = "INSERT INTO platos_vendidos_hoy (id_plato, cant_vendida, fecha) 
              VALUES ('$plato', '$cantidad', '$fecha')";
    
    if (mysqli_query($conexion, $query)) {
        return true;
    } else {
        return false;
    }
}

// Función para actualizar una venta
function actualizarVenta($id_plato_vendido_hoy, $plato, $cantidad, $fecha) {
    global $conexion;
    
    // Actualizar la cantidad vendida y la fecha
    $query = "UPDATE platos_vendidos_hoy 
              SET id_plato = '$plato', cant_vendida = '$cantidad', fecha = '$fecha' 
              WHERE id_plato_vendido_hoy = '$id_plato_vendido_hoy'";

    if (mysqli_query($conexion, $query)) {
        return true;
    } else {
        return false;
    }
}

// Función para obtener una venta específica (para cargar los detalles en el formulario de edición)
function obtenerVentaPorId($id_plato_vendido_hoy) {
    global $conexion;
    
    $query = "SELECT pvh.id_plato_vendido_hoy, pvh.id_plato, pvh.cant_vendida, pvh.fecha, p.nombre 
              FROM platos_vendidos_hoy pvh
              JOIN platos p ON pvh.id_plato = p.id_plato
              WHERE pvh.id_plato_vendido_hoy = '$id_plato_vendido_hoy'";

    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        return mysqli_fetch_assoc($resultado);
    } else {
        return null;
    }
}

// Verifica si la solicitud es para actualizar una venta
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Si se envía el formulario de edición, actualizamos la venta
    if (isset($_POST['id_plato_vendido_hoy'])) {
        $id_plato_vendido_hoy = $_POST['id_plato_vendido_hoy'];
        $plato = $_POST['plato'];
        $cantidad = $_POST['cantidad'];
        $fecha = $_POST['fecha'];

        $actualizado = actualizarVenta($id_plato_vendido_hoy, $plato, $cantidad, $fecha);

        // Retornar respuesta en formato JSON
        if ($actualizado) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    } else {
        // Si es una solicitud para registrar una nueva venta
        $plato = $_POST['plato'];
        $cantidad = $_POST['cantidad'];
        $fecha = $_POST['fecha'];

        $registrado = registrarVenta($plato, $cantidad, $fecha);

        if ($registrado) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    }
} elseif (isset($_GET['id_plato_vendido_hoy'])) {
    // Si se solicita una venta para editar (GET), devolvemos los datos de la venta
    $id_plato_vendido_hoy = $_GET['id_plato_vendido_hoy'];
    $venta = obtenerVentaPorId($id_plato_vendido_hoy);

    if ($venta) {
        echo json_encode(['success' => true, 'venta' => $venta]);
    } else {
        echo json_encode(['success' => false]);
    }
}
?>
