<?php
session_start();
require_once "../../config/conexion.php"; // Asegúrate de incluir la conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $total = $_POST['total'];
    $metodo_pago = $_POST['metodo_pago'];

    // Aquí puedes agregar la lógica para procesar el pago según el método seleccionado
    switch ($metodo_pago) {
        case 'yape':
            $numero_celular = $_POST['numero_celular'];
            // Lógica para procesar el pago con Yape
            // ...
            break;

        case 'tarjeta':
            $numero_tarjeta = $_POST['numero_tarjeta'];
            $fecha_expiracion = $_POST['fecha_expiracion'];
            $cvv = $_POST['cvv'];
            // Lógica para procesar el pago con tarjeta
            // ...
            break;

        case 'plin':
            $numero_celular = $_POST['numero_celular'];
            // Lógica para procesar el pago con Plin
            // ...
            break;

        default:
            echo "Método de pago no válido.";
            exit();
    }

    // Aquí puedes guardar la transacción en la base de datos o realizar otras acciones necesarias
    // Por ejemplo, guardar la información del pedido en la base de datos

    // Guardar el carrito en la sesión para la generación de la boleta
    $_SESSION['carrito'] = $_SESSION['carrito']; // Asegúrate de que el carrito esté en la sesión
    $_SESSION['nombre_cliente'] = $_POST['nombre']; // Guarda el nombre del cliente
    $_SESSION['email_cliente'] = $_POST['correo']; // Guarda el correo del cliente

    // Redirigir a la página de generación de boleta
    header("Location: generar_boleta.php");
    exit();
} else {
    echo "Método no permitido.";
}
?>
