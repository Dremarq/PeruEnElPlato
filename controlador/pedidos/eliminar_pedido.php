<?php

if (!empty($_GET["id"])) {
    $id=$_GET["id"];
    $sql=$conexion->query("DELETE FROM pedidos WHERE id_pedido=$id");
    if ($sql==1) {
        echo '<div class="alert alert-success">Pedido eliminado correctamente</div>';
    } else{
        echo '<div class="alert alert-danger">Error al eliminar pedido</div>';
    }
}
?>