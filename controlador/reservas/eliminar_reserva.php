<?php

if (!empty($_GET["id"])) {
    $id=$_GET["id"];
    $sql=$conexion->query("DELETE FROM reservas WHERE id_reserva=$id");
    if ($sql==1) {
        echo '<div class="alert alert-success">Reserva eliminada correctamente</div>';
    } else{
        echo '<div class="alert alert-danger">Error al eliminar reserva</div>';
    }
}
?>