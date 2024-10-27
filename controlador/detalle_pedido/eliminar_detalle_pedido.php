<?php

if (!empty($_GET["id"])) {
    $id=$_GET["id"];
    $sql=$conexion->query("DELETE FROM empleados WHERE id_empleado=$id");
    if ($sql==1) {
        echo '<div class="alert alert-success">Empleado eliminado correctamente</div>';
    } else{
        echo '<div class="alert alert-danger">Error al eliminar empleado</div>';
    }
}
?>