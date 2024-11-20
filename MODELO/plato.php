<?php

class Plato {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function obtenerPlatos() {
        $sql = "SELECT * FROM platos";
        $resultado = $this->conexion->query($sql);
        return $resultado;
    }

    public function registrarPlato($nombre, $descripcion, $precio, $categoria, $imagen) {
        $sql = "INSERT INTO platos (nombre, descripcion, precio, categoria, imagen) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("ssdsb", $nombre, $descripcion, $precio, $categoria, $imagen);
        $stmt->execute();
        return $stmt->insert_id;
    }

    public function modificarPlato($id_plato, $nombre, $descripcion, $precio, $categoria, $estado) {
        $sql = "UPDATE platos SET nombre = ?, descripcion = ?, precio = ?, categoria = ?, estado = ? WHERE id_plato = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("ssdsii", $nombre, $descripcion, $precio, $categoria, $estado, $id_plato);
        $stmt->execute();
        return $stmt->affected_rows;
    }

    public function eliminarPlato($id_plato) {
        $sql = "DELETE FROM platos WHERE id_plato = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id_plato);
        $stmt->execute();
        return $stmt->affected_rows;
    }
}