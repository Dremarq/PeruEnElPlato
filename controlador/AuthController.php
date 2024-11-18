<?php

require_once '../config/conexion.php';
require_once '../modelo/Admin.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $adminModel = new Admin($conexion);
    $adminEncontrado = $adminModel->verificarCredenciales($username, $password);

    if ($adminEncontrado) {
        // Guardar información del admin en la sesión
        $_SESSION['admin_id'] = $adminEncontrado['id_admin'];
        $_SESSION['username'] = $adminEncontrado['username'];
        $_SESSION['ultimo_acceso'] = $adminEncontrado['ultimo_acceso']; // Puedes actualizar esto si deseas

        // Redirigir al panel de administración
        header('Location: ../vista/admin_dashboard.php?alert=success');
        exit();
    } else {
        header('Location: ../vista/login.php?error=Usuario o contraseña incorrectos.');
        exit();
    }
}

?>