<?php
session_start();

// Obtener el carrito enviado desde el cliente
$carrito = json_decode(file_get_contents('php://input'), true);

// Guardar el carrito en la sesión
$_SESSION['carrito'] = $carrito;

echo json_encode(['status' => 'success']);
?>