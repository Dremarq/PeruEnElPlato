<?php
require_once '../modelo/detalle_pedido.php';
require_once '../config/conexion.php';

class DetallePedidoController {
    private $modelo;

    public function __construct() {
        global $conexion;
        $this->modelo = new DetallePedido($conexion);
    }

    public function procesarAccion() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['accion'])) {
                switch ($_POST['accion']) {
                    case 'registrar':
                        return $this->registrar();
                    case 'modificar':
                        return $this->modificar();
                }
            }
        } elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if (isset($_GET['accion']) && $_GET['accion'] === 'eliminar' && isset($_GET['id'])) {
                return $this->eliminar($_GET['id']);
            }
        }
    }

    private function registrar() {
        if (!empty($_POST['id_pedido']) && !empty($_POST['id_producto']) && 
            !empty($_POST['cantidad']) && !empty($_POST['precio_unitario'])) {
            
            $resultado = $this->modelo->registrarDetallePedido(
                $_POST['id_pedido'],
                $_POST['id_producto'],
                $_POST['cantidad'],
                $_POST['precio_unitario']
            );

            if ($resultado) {
                $_SESSION['mensaje'] = "Detalle de pedido registrado exitosamente";
                $_SESSION['tipo_mensaje'] = "success";
            } else {
                $_SESSION['mensaje'] = "Error al registrar detalle de pedido";
                $_SESSION['tipo_mensaje'] = "danger";
            }
        } else {
            $_SESSION['mensaje'] = "Todos los campos son requeridos";
            $_SESSION['tipo_mensaje'] = "warning";
        }
        header("Location: ../vista/detalle_pedido.php");
        exit();
    }

    private function modificar() {
        if (!empty($_POST['id_detalle'])) {
            $resultado = $this->modelo->modificarDetallePedido(
                $_POST['id_detalle'],
                $_POST['id_producto'],
                $_POST['cantidad'],
                $_POST['precio_unitario']
            );

            if ($resultado) {
                $_SESSION['mensaje'] = "Detalle de pedido modificado exitosamente";
                $_SESSION['tipo_mensaje'] = "success";
            } else {
                $_SESSION['mensaje'] = "Error al modificar detalle de pedido";
                $_SESSION['tipo_mensaje'] = "danger";
            }
        }
        header("Location: ../vista/detalle_pedido.php");
        exit();
    }

    private function eliminar($id) {
        if ($this->modelo->eliminarDetallePedido($id)) {
            $_SESSION['mensaje'] = "Detalle de pedido eliminado exitosamente";
            $_SESSION['tipo_mensaje'] = "success";
        } else {
            $_SESSION['mensaje'] = "Error al eliminar detalle de pedido";
            $_SESSION['tipo_mensaje'] = "danger";
        }
        header("Location: ../vista/detalle_pedido.php");
        exit();
    }
}

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Crear instancia del controlador y procesar la acción
$controller = new DetallePedidoController();
$controller->procesarAccion();
?>