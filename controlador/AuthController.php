<?php
require_once '../config/conexion.php';
require_once '../modelo/auth.php'; 

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Verificar las credenciales
    $authModel = new Auth($conexion);
    $usuarioEncontrado = $authModel->verificarCredenciales($username, $password);

    if ($usuarioEncontrado) {
        // Guardar información del usuario en la sesión
        $_SESSION['admin_id'] = $usuarioEncontrado['id_admin'];
        $_SESSION['username'] = $usuarioEncontrado['username'];
        $_SESSION['rol'] = $usuarioEncontrado['id_rol']; // Obtener el rol del empleado

        // Redirigir según el rol
        switch ($usuarioEncontrado['id_rol']) {
            case 1: // Administrador
                header('Location: ../vista/admin_dashboard.php');
                break;
            case 2: // Cajero
                header('Location: ../vista/empleados/cajero.php');
                break;
            case 3: // Cocinero
                header('Location: ../vista/empleados/cocinero.php');
                break;
            default:
                header('Location: ../vista/login.php?error=Rol no reconocido.');
                break;
        }
        exit();
    } else {
        // Si no se encontraron credenciales válidas
        header('Location: ../vista/login.php?error=Usuario o contraseña incorrectos.');
        exit();
    }
}
?>