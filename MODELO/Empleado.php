<?php
class Empleado {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function obtenerEmpleados() {
        try {
            $query = "SELECT e.*, r.nombre_rol 
                     FROM empleados e 
                     LEFT JOIN roles r ON e.id_rol = r.id_rol";
            return $this->conexion->query($query);
        } catch (Exception $e) {
            error_log("Error en obtenerEmpleados: " . $e->getMessage());
            return false;
        }
    }

    public function registrarEmpleado($nombre, $apellido, $dni, $telefono, $email, $id_rol) {
        try {
            $query = "INSERT INTO empleados (nombre, apellido, dni, telefono, email, id_rol) 
                     VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->conexion->prepare($query);
            $stmt->bind_param("sssssi", $nombre, $apellido, $dni, $telefono, $email, $id_rol);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Error en registrarEmpleado: " . $e->getMessage());
            return false;
        }
    }

    public function modificarEmpleado($id, $nombre, $apellido, $dni, $telefono, $email, $id_rol) {
        try {
            $query = "UPDATE empleados 
                     SET nombre = ?, apellido = ?, dni = ?, telefono = ?, email = ?, id_rol = ? 
                     WHERE id_empleado = ?";
            $stmt = $this->conexion->prepare($query);
            $stmt->bind_param("ssssiii", $nombre, $apellido, $dni, $telefono, $email, $id_rol, $id);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Error en modificarEmpleado: " . $e->getMessage());
            return false;
        }
    }

    public function eliminarEmpleado($id) {
        try {
            $query = "DELETE FROM empleados WHERE id_empleado = ?";
            $stmt = $this->conexion->prepare($query);
            $stmt->bind_param("i", $id);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Error en eliminarEmpleado: " . $e->getMessage());
            return false;
        }
    }
}
?>