<?php

class Pedido {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function obtenerPedidos() {
        $sql = "SELECT p.*, u.nombre AS cliente, e.nombre AS empleado 
                FROM pedidos p
                LEFT JOIN usuarios u ON p.id_usuario = u.id_usuario
                LEFT JOIN empleados e ON p.id_empleado = e.id_empleado";
        $resultado = $this->conexion->query($sql);
        return $resultado;
    }
    public function contarPedidos() {
        $query = "SELECT COUNT(*) as total FROM pedidos"; 
        $resultado = $this->conexion->query($query);
        $total = $resultado->fetch_assoc();
        return $total['total'];
    }
    
    public function obtenerPedidosLimit($inicio, $registrosPorPagina) {
        $query = "
            SELECT p.*, u.nombre AS cliente, e.nombre AS empleado 
            FROM pedidos p
            LEFT JOIN usuarios u ON p.id_usuario = u.id_usuario
            LEFT JOIN empleados e ON p.id_empleado = e.id_empleado
            LIMIT $inicio, $registrosPorPagina";
        return $this->conexion->query($query);
    }
    public function registrarPedido($id_usuario, $id_empleado, $fecha_pedido, $estado, $tipo_pedido, $total) {
        $sql = "INSERT INTO pedidos (id_usuario, id_empleado, fecha_pedido, estado, tipo_pedido, total) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("iisssd", $id_usuario, $id_empleado, $fecha_pedido, $estado, $tipo_pedido, $total);
        $stmt->execute();
        return $stmt->insert_id;
    }

    public function modificarPedido($id_pedido, $id_usuario, $id_empleado, $fecha_pedido, $estado, $tipo_pedido, $total) {
        $sql = "UPDATE pedidos 
                SET id_usuario = ?, id_empleado = ?, fecha_pedido = ?, estado = ?, tipo_pedido = ?, total = ?
                WHERE id_pedido = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("iisssdi", $id_usuario, $id_empleado, $fecha_pedido, $estado, $tipo_pedido, $total, $id_pedido);
        $stmt->execute();
        return $stmt->affected_rows;
    }

    public function eliminarPedido($id_pedido) {
        $sql = "DELETE FROM pedidos WHERE id_pedido = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id_pedido);
        $stmt->execute();
        return $stmt->affected_rows;
    }

    // Métodos para obtener datos para los selects
    public function obtenerClientes() {
        $sql = "SELECT id_usuario, nombre FROM usuarios";
        return $this->conexion->query($sql);
    }

    public function obtenerEmpleados() {
        $sql = "SELECT id_empleado, nombre FROM empleados";
        return $this->conexion->query($sql);
    }
}
?>