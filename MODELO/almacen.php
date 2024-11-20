<?php

class Almacen {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function obtenerInventario() {
        $sql = "SELECT a.*, p.nombre AS nombre_producto 
                FROM almacen a 
                JOIN productos p ON a.id_producto = p.id_producto";
        $resultado = $this->conexion->query($sql);
        return $resultado;
    }
    public function obtenerProductos() {
        $sql = "SELECT id_producto, nombre FROM productos WHERE estado = 1";
        return $this->conexion->query($sql);
    }

    public function registrarProductoEnAlmacen($id_producto, $stock_actual, $stock_minimo) {
        $fecha_actualizacion = date('Y-m-d H:i:s');
        $sql = "INSERT INTO almacen (id_producto, stock_actual, stock_minimo, fecha_actualizacion) 
                VALUES (?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("iiis", $id_producto, $stock_actual, $stock_minimo, $fecha_actualizacion);
        $stmt->execute();
        return $stmt->insert_id;
    }

    public function modificarInventario($id_almacen, $stock_actual, $stock_minimo) {
        $fecha_actualizacion = date('Y-m-d H:i:s');
        $sql = "UPDATE almacen 
                SET stock_actual = ?, stock_minimo = ?, fecha_actualizacion = ? 
                WHERE id_almacen = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("iisi", $stock_actual, $stock_minimo, $fecha_actualizacion, $id_almacen);
        $stmt->execute();
        return $stmt->affected_rows;
    }

    public function eliminarProductoDeAlmacen($id_almacen) {
        $sql = "DELETE FROM almacen WHERE id_almacen = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id_almacen);
        $stmt->execute();
        return $stmt->affected_rows;
    }
}
?>