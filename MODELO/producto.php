<?php

class Producto {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function obtenerProductos() {
        $sql = "SELECT * FROM productos";
        $resultado = $this->conexion->query($sql);
        return $resultado;
    }

    public function registrarProducto($nombre, $descripcion, $costo, $id_proveedor) {
        $sql = "INSERT INTO productos (nombre, descripcion, costo, id_proveedor) VALUES (?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("ssdi", $nombre, $descripcion, $costo, $id_proveedor);
        $stmt->execute();
        return $stmt->insert_id;
    }

    public function modificarProducto($id_producto, $nombre, $descripcion, $costo, $estado, $id_proveedor) {
        $sql = "UPDATE productos SET nombre = ?, descripcion = ?, costo = ?, estado = ?, id_proveedor = ? WHERE id_producto = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("ssdiii", $nombre, $descripcion, $costo, $estado, $id_proveedor, $id_producto);
        $stmt->execute();
        return $stmt->affected_rows;
    }

    public function eliminarProducto($id_producto) {
        $sql = "DELETE FROM productos WHERE id_producto = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id_producto);
        $stmt->execute();
        return $stmt->affected_rows;
    }
}