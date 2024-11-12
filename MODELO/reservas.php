<?php

class Reserva {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function obtenerReservas() {
        $sql = "SELECT r.*, u.nombre AS cliente 
                FROM reservas r
                JOIN usuarios u ON r.id_usuario = u.id_usuario";
        $resultado = $this->conexion->query($sql);
        return $resultado;
    }

    public function registrarReserva($id_usuario, $numero_mesa, $fecha_reserva, $hora_reserva, $cantidad_personas, $estado) {
        $sql = "INSERT INTO reservas (id_usuario, numero_mesa, fecha_reserva, hora_reserva, cantidad_personas, estado) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("iissss", $id_usuario, $numero_mesa, $fecha_reserva, $hora_reserva, $cantidad_personas, $estado);
        $stmt->execute();
        return $stmt->insert_id;
    }

    public function modificarReserva($id_reserva, $id_usuario, $numero_mesa, $fecha_reserva, $hora_reserva, $cantidad_personas, $estado) {
        $sql = "UPDATE reservas 
                SET id_usuario = ?, numero_mesa = ?, fecha_reserva = ?, hora_reserva = ?, cantidad_personas = ?, estado = ? 
                WHERE id_reserva = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("iissssi", $id_usuario, $numero_mesa, $fecha_reserva, $hora_reserva, $cantidad_personas, $estado, $id_reserva);
        $stmt->execute();
        return $stmt->affected_rows;
    }

    public function eliminarReserva($id_reserva) {
        $sql = "DELETE FROM reservas WHERE id_reserva = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id_reserva);
        $stmt->execute();
        return $stmt->affected_rows;
    }

    public function obtenerClientes() {
        $sql = "SELECT id_usuario, nombre FROM usuarios";
        return $this->conexion->query($sql);
    }
}
?>