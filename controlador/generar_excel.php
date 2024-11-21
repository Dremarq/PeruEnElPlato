<?php
require_once '../config/conexion.php';
require_once '../modelo/almacen.php';

$almacenModelo = new Almacen($conexion);
$inventario = $almacenModelo->obtenerInventario();

// Configuración para la descarga de Excel
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="inventario_almacen.xls"');

echo "ID\tNOMBRE DE PRODUCTO\tSROCK ACTUAL\tSTOCK MINIMO\tFECHA DE ACTUALIZACION\n";

while ($item = $inventario->fetch_object()) {
    echo "{$item->id_almacen}\t{$item->nombre_producto}\t{$item->stock_actual}\t{$item->stock_minimo}\t{$item->fecha_actualizacion}\n";
}
?>