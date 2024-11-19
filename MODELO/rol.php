<?php

class Rol {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function obtenerRoles() {
        $sql = "SELECT * FROM roles";
        return $this->conexion->query($sql);
    }

    public function registrarRol($nombre_rol, $descripcion) {
        $sql = "INSERT INTO roles (nombre_rol, descripcion) VALUES (?, ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("ss", $nombre_rol, $descripcion);
        return $stmt->execute();
    }

    public function modificarRol($id_rol, $nombre_rol, $descripcion) {
        $sql = "UPDATE roles SET nombre_rol = ?, descripcion = ? WHERE id_rol = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("ssi", $nombre_rol, $descripcion, $id_rol);
        return $stmt->execute();
    }

    public function eliminarRol($id_rol) {
        $sql = "DELETE FROM roles WHERE id_rol = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id_rol);
        return $stmt->execute();
    }
}
?>