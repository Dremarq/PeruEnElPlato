<?php
session_start();
require_once "../config/conexion.php";
require_once "../modelo/Cliente.php";

$clienteModelo = new Cliente($conexion);

if ($_POST['accion'] == 'registrar') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $dni = $_POST['dni'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $direccion = $_POST['direccion'];
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    // Intentar registrar el usuario
    if ($clienteModelo->registrarUsuario($nombre, $apellido, $dni, $telefono, $email, $direccion, $usuario, $contrasena)) {
        // Si el registro es exitoso, redirigir al login de clientes
        header('Location: ../vista/loginCliente.php?registro=success');
        exit();
    } else {
        // Si hay un error, redirigir de nuevo al login con un mensaje de error
        header('Location: ../vista/loginCliente.php?error=El DNI ya existe o hubo un error en el registro.');
        exit();
    }
}
?>