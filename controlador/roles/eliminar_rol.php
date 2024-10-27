<?php

if (!empty($_GET["id"])) {
    $id=$_GET["id"];
    $sql=$conexion->query("DELETE FROM roles WHERE id_rol=$id");
    if ($sql==1) {
        echo '<div class="alert alert-success">Rol eliminado correctamente</div>';
    } else{
        echo '<div class="alert alert-danger">Error al eliminar rol</div>';
    }
}
?>