<?php
// archivo de conexión
include "../config/conexion.php"; // Ajusta la ruta según tu estructura de carpetas

if (!empty($_POST["btnregistrar"])) {
    // Verifica que todos los campos requeridos no estén vacíos
    if (!empty($_POST["nombre"]) && 
        !empty($_POST["apellido"]) && 
        !empty($_POST["dni"]) && 
        !empty($_POST["telefono"]) && 
        !empty($_POST["direccion"]) && 
        !empty($_POST["email"]) && 
        !empty($_POST["id_rol"])) { // Asegúrate que el nombre del input coincide

        // Asignar variables del formulario
        $nombre = $_POST["nombre"];
        $apellido = $_POST["apellido"];
        $dni = $_POST["dni"];
        $telefono = $_POST["telefono"];
        $direccion = $_POST["direccion"];
        $email = $_POST["email"];
        $id_rol = $_POST["id_rol"]; // Asumimos que hay un campo para el rol

        // Ejecutar la consulta de inserción
        $sql = $conexion->query("INSERT INTO empleados(nombre, apellido, dni, telefono, direccion, email, id_rol) 
                                VALUES('$nombre', '$apellido', '$dni', '$telefono', '$direccion', '$email', '$id_rol')");

        // Verificar si la inserción fue exitosa
        if ($sql === TRUE) {
            echo '<div class="alert alert-success">Empleado Registrado Correctamente</div>';
        } else {
            echo '<div class="alert alert-danger">Error en el Registro del Empleado: ' . $conexion->error . '</div>';
        }
    } else {
        echo '<div class="alert alert-warning">Algunos campos están vacíos</div>';
    }
}
?>
