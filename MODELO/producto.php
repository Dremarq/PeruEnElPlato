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

    public function registrarProducto($nombre, $descripcion, $precio, $categoria, $imagen) {
        $sql = "INSERT INTO productos (nombre, descripcion, precio, categoria, imagen) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("ssdsb", $nombre, $descripcion, $precio, $categoria, $imagen);
        $stmt->execute();
        return $stmt->insert_id;
    }

    public function modificarProducto($id_producto, $nombre, $descripcion, $precio, $categoria, $estado) {
        $sql = "UPDATE productos SET nombre = ?, descripcion = ?, precio = ?, categoria = ?, estado = ? WHERE id_producto = ?";
 $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("ssdsii", $nombre, $descripcion, $precio, $categoria, $estado, $id_producto);
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