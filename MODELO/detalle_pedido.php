<?php

class DetallePedido {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function obtenerDetallesPedido() {
        $sql = "SELECT d.id_detalle, d.id_pedido, p.nombre AS producto, d.cantidad, 
                d.precio_unitario, d.subtotal 
                FROM detalle_pedido d
                JOIN productos p ON d.id_producto = p.id_producto";
        $resultado = $this->conexion->query($sql);
        return $resultado;
    }

    public function obtenerProductos() {
        $sql = "SELECT id_producto, nombre FROM productos WHERE estado = 1";
        return $this->conexion->query($sql);
    }

    public function registrarDetallePedido($id_pedido, $id_producto, $cantidad, $precio_unitario) {
        try {
            $subtotal = $cantidad * $precio_unitario;
            
            $sql = "INSERT INTO detalle_pedido (id_pedido, id_producto, cantidad, precio_unitario, subtotal) 
                    VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("iiidd", $id_pedido, $id_producto, $cantidad, $precio_unitario, $subtotal);
            $stmt->execute();
            return $stmt->insert_id;
        } catch (Exception $e) {
            error_log("Error en registrarDetallePedido: " . $e->getMessage());
            return false;
        }
    }

    public function modificarDetallePedido($id_detalle, $id_producto, $cantidad, $precio_unitario) {
        try {
            $subtotal = $cantidad * $precio_unitario;
            
            $sql = "UPDATE detalle_pedido 
                    SET id_producto = ?, cantidad = ?, precio_unitario = ?, subtotal = ? 
                    WHERE id_detalle = ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("iiddi", $id_producto, $cantidad, $precio_unitario, $subtotal, $id_detalle);
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