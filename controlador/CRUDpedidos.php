<?php
require_once '../modelo/pedidos.php';
require_once '../config/conexion.php';

class PedidoController {
    private $modelo;

    public function __construct() {
        global $conexion;
        $this->modelo = new Pedido($conexion);
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
        if (!empty($_POST['id_usuario']) && !empty($_POST['id_empleado']) && 
            !empty($_POST['fecha_pedido']) && !empty($_POST['estado']) && 
            !empty($_POST['tipo_pedido']) && !empty($_POST['total'])) {
            
            $resultado = $this->modelo->registrarPedido(
                $_POST['id_usuario'],
                $_POST['id_empleado'],
                $_POST['fecha_pedido'],
                $_POST['estado'],
                $_POST['tipo_pedido'],
                $_POST['total']
            );

            if ($resultado) {
                $_SESSION['mensaje'] = "Pedido registrado exitosamente";
                $_SESSION['tipo_mensaje'] = "success";
            } else {
                $_SESSION['mensaje'] = "Error al registrar pedido";
                $_SESSION['tipo_mensaje'] = "danger";
            }
        } else {
            $_SESSION['mensaje'] = "Todos los campos son requeridos";
            $_SESSION['tipo_mensaje'] = "warning";
        }
        header("Location: ../vista/pedidos.php");
        exit();
    }

    private function modificar() {
        if (!empty($_POST['id_pedido'])) {
            $resultado = $this->modelo->modificarPedido(
                $_POST['id_pedido'],
                $_POST['id_usuario'],
                $_POST['id_empleado'],
                $_POST['fecha_pedido'],
                $_POST['estado'],
                $_POST['tipo_pedido'],
                $_POST['total']
            );

            if ($resultado) {
                $_SESSION['mensaje'] = "Pedido modificado exitosamente";
                $_SESSION['tipo_mensaje'] = "success";
            } else {
                $_SESSION['mensaje'] = "Error al modificar pedido";
                $_SESSION['tipo_mensaje'] = "danger";
            }
        }
        header("Location: ../vista/pedidos.php");
        exit();
    }

    private function eliminar($id) {
        if ($this->modelo->eliminarPedido($id)) {
            $_SESSION['mensaje'] = "Pedido eliminado exitosamente";
            $_SESSION['tipo_mensaje'] = "success";
        } else {
            $_SESSION['mensaje'] = "Error al eliminar pedido";
            $_SESSION['tipo_mensaje'] = "danger";
        }
        header("Location: ../vista/pedidos.php");
        exit();
    }
}

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Crear instancia del controlador y procesar la acción
$controller = new PedidoController();
$controller->procesarAccion();
?>