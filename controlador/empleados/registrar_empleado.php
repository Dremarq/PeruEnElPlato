<?php
require_once "../../config/conexion.php";

// Activar reporte de errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Verificar si se recibieron datos POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si los campos requeridos están presentes y no están vacíos
    if (
        !empty($_POST["nombre"]) &&
        !empty($_POST["dni"]) &&
        !empty($_POST["telefono"]) &&
        !empty($_POST["email"]) &&
        !empty($_POST["rol"])
    ) {

        $nombre = $_POST["nombre"];
        $dni = $_POST["dni"];
        $telefono = $_POST["telefono"];
        $email = $_POST["email"];
        $id_rol = $_POST["rol"];

        // Preparar la consulta SQL
        $sql = $conexion->query("INSERT INTO empleados(nombre, dni, telefono, email, id_rol) 
                                VALUES('$nombre', '$dni', '$telefono', '$email', '$id_rol')");

        if ($sql === TRUE) {
            header("Location: ../../vista/empleados.php?mensaje=registrado");
            exit();
        } else {
            header("Location: ../../vista/empleados.php?mensaje=error&error=" . urlencode($conexion->error));
            exit();
        }
    } else {
        header("Location: ../../vista/empleados.php?mensaje=vacio");
        exit();
    }
} else {
    header("Location: ../../vista/empleados.php?mensaje=acceso_invalido");
    exit();
}
