<?php
class Cliente {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function obtenerUsuarios() {
        try {
            $query = "SELECT id_usuario, nombre, apellido, dni, telefono, email, direccion, fecha_registro 
                     FROM usuarios";
            return $this->conexion->query($query);
        } catch (Exception $e) {
            error_log("Error en obtenerUsuarios: " . $e->getMessage());
            return false;
        }
    }

    public function registrarUsuario($nombre, $apellido, $dni, $telefono, $email, $direccion, $fecha_registro) {
        try {
            $query = "INSERT INTO usuarios (nombre, apellido, dni, telefono, email, direccion, fecha_registro) 
                     VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->conexion->prepare($query);
            $stmt->bind_param("sssssss", $nombre, $apellido, $dni, $telefono, $email, $direccion, $fecha_registro);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Error en registrarUsuario: " . $e->getMessage());
            return false;
        }
    }

    public function modificarUsuario($id, $nombre, $apellido, $dni, $telefono, $email, $direccion, $fecha_registro) {
        try {
            $query = "UPDATE usuarios 
                     SET nombre = ?, apellido = ?, dni = ?, telefono = ?, email = ?, direccion = ?, fecha_registro = ? 
                     WHERE id_usuario = ?";
            $stmt = $this->conexion->prepare($query);
            $stmt->bind_param("sssssssi", $nombre, $apellido, $dni, $telefono, $email, $direccion, $fecha_registro, $id);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Error en modificarUsuario: " . $e->getMessage());
            return false;
        }
    }

    public function eliminarUsuario($id) {
        try {
            $query = "DELETE FROM usuarios WHERE id_usuario = ?";
            $stmt = $this->conexion->prepare($query);
            $stmt->bind_param("i", $id);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Error en eliminarUsuario: " . $e->getMessage());
            return false;
        }
    }
}
?>