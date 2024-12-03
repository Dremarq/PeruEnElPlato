<?php

class DetallePedido {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function obtenerDetallesPedido() {
        $query = "
            SELECT dp.id_detalle, dp.id_pedido, dp.id_plato, dp.cantidad, dp.precio_unitario, 
                   (dp.cantidad * dp.precio_unitario) AS subtotal, 
                   p.nombre AS plato
            FROM detalle_pedido dp
            JOIN platos p ON dp.id_plato = p.id_plato";
        return $this->conexion->query($query);
    }

    public function obtenerPlatos() {
        $sql = "SELECT id_plato, nombre FROM platos WHERE estado = 1"; // Asegurarse de que los platos estén activos
        return $this->conexion->query($sql);
    }

    public function registrarDetallePedido($id_pedido, $id_plato, $cantidad, $precio_unitario) {
        try {
            $subtotal = $cantidad * $precio_unitario;
            
            $sql = "INSERT INTO detalle_pedido (id_pedido, id_plato, cantidad, precio_unitario, subtotal) 
                    VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("iiidd", $id_pedido, $id_plato, $cantidad, $precio_unitario, $subtotal);
            $stmt->execute();
            return $stmt->insert_id;
        } catch (Exception $e) {
            error_log("Error en registrarDetallePedido: " . $e->getMessage());
            return false;
        }
    }

    public function modificarDetallePedido($id_detalle, $id_plato, $cantidad, $precio_unitario) {
        try {
            $subtotal = $cantidad * $precio_unitario;
            
            $sql = "UPDATE detalle_pedido 
                    SET id_plato = ?, cantidad = ?, precio_unitario = ?, subtotal = ? 
                    WHERE id_detalle = ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("iiddi", $id_plato, $cantidad, $precio_unitario, $subtotal, $id_detalle);
            $stmt->execute();
            return $stmt->affected_rows;
        } catch (Exception $e) {
            error_log("Error en modificarDetallePedido: " . $e->getMessage());
            return false;
        }
    }

    public function eliminarDetallePedido($id_detalle) {
        try {
            $sql = "DELETE FROM detalle_pedido WHERE id_detalle = ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("i", $id_detalle);
            $stmt->execute();
            return $stmt->affected_rows;
        } catch (Exception $e) {
            error_log("Error en eliminarDetallePedido: " . $e->getMessage());
            return false;
        }
    }

    public function obtenerPedidos() {
        $sql = "SELECT id_pedido FROM pedidos WHERE estado = 'Pendiente'";
        return $this->conexion->query($sql);
    }
}
?>