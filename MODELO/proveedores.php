<?php

class Proveedor {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function obtenerProveedores() {
        $sql = "SELECT * FROM proveedores";
        $resultado = $this->conexion->query($sql);
        return $resultado;
    }

    public function registrarProveedor($nombre_empresa, $ruc, $telefono, $email, $direccion) {
        $sql = "INSERT INTO proveedores (nombre_empresa, ruc, telefono, email, direccion) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("sssss", $nombre_empresa, $ruc, $telefono, $email, $direccion);
        $stmt->execute();
        return $stmt->insert_id;
    }

    public function modificarProveedor($id_proveedor, $nombre_empresa, $ruc, $telefono, $email, $direccion, $estado) {
        $sql = "UPDATE proveedores SET nombre_empresa = ?, ruc = ?, telefono = ?, email = ?, direccion = ?, estado = ? WHERE id_proveedor = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("sssssii", $nombre_empresa, $ruc, $telefono, $email, $direccion, $estado, $id_proveedor);
        $stmt->execute();
        return $stmt->affected_rows;
    }

    public function eliminarProveedor($id_proveedor) {
        $sql = "DELETE FROM proveedores WHERE id_proveedor = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id_proveedor);
        $stmt->execute();
        return $stmt->affected_rows;
    }
}