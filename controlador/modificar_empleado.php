<?php
// Incluir el archivo de conexión
include "../config/conexion.php";

if (!empty($_POST["btnmodificar"])) {
    if (!empty($_POST["nombre"]) && !empty($_POST["apellido"]) && !empty($_POST["dni"]) && !empty($_POST["telefono"]) && !empty($_POST["direccion"]) && !empty($_POST["email"]) && !empty($_POST["id_rol"])) {
        
        // Asignar variables del formulario
        $id = $_POST["id"];
        $nombre = $_POST["nombre"];
        $apellido = $_POST["apellido"];
        $dni = $_POST["dni"];
        $telefono = $_POST["telefono"];
        $direccion = $_POST["direccion"];
        $email = $_POST["email"];
        $id_rol = $_POST["id_rol"]; // Asegúrate de que este campo coincide con el nombre del input en el formulario.

        // Ejecutar la consulta de actualización
        $sql = $conexion->query("UPDATE empleados SET nombre='$nombre', apellido='$apellido', dni='$dni', telefono='$telefono', direccion='$direccion', email='$email', id_rol='$id_rol' WHERE id_empleado=$id");

        // Verificar si la modificación fue exitosa
        if ($sql === TRUE) {
            header("Location: registro_empleado.php"); // Redirige a la página de registro de empleados
            exit; // Asegúrate de usar exit después de header
        } else {
            echo "<div class='alert alert-danger'>Error al Modificar: " . $conexion->error . "</div>";
        }

    } else {
        echo "<div class='alert alert-warning'>Campos Vacíos</div>";
    }
}
?>
