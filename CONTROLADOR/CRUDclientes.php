<?php
require_once '../MODELO/ClientesModel.php';

// Establecer la conexión a la base de datos
$conexion = mysqli_connect('localhost', 'root', '', 'restaurante');

if (!$conexion) {
    die("Conexión fallida: " . mysqli_connect_error());
}

// Crear una instancia del modelo
$model = new ClientesModel($conexion);

// Manejar la acción
if (isset($_GET['action']) && $_GET['action'] == 'index') {
    $usuarios = $model->getAllClientes();
    include '../VISTA/clientes.php'; // Asegúrate de que la ruta sea correcta
}
?>