<?php
require_once '../modelo/reservas.php';
require_once '../config/conexion.php';

class ReservaController {
    private $modelo;

    public function __construct() {
        global $conexion;
        $this->modelo = new Reserva($conexion);
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
        if (!empty($_POST['id_usuario']) && !empty($_POST['numero_mesa']) && 
            !empty($_POST['fecha_reserva']) && !empty($_POST['hora_reserva']) && 
            !empty($_POST['cantidad_personas']) && !empty($_POST['estado'])) {
            
            $resultado = $this->modelo->registrarReserva(
                $_POST['id_usuario'],
                $_POST['numero_mesa'],
                $_POST['fecha_reserva'],
                $_POST['hora_reserva'],
                $_POST['cantidad_personas'],
                $_POST['estado']
            );

            if ($resultado) {
                $_SESSION['mensaje'] = "Reserva registrada exitosamente";
                $_SESSION['tipo_mensaje'] = "success";
            } else {
                $_SESSION['mensaje'] = "Error al registrar reserva";
                $_SESSION['tipo_mensaje'] = "danger";
            }
        } else {
            $_SESSION['mensaje'] = "Todos los campos son requeridos";
            $_SESSION['tipo_mensaje'] = "warning";
        }
        header("Location: ../vista/reservas.php");
        exit();
    }

    private function modificar() {
        if (!empty($_POST['id_reserva'])) {
            $resultado = $this->modelo->modificarReserva(
                $_POST['id_reserva'],
                $_POST['id_usuario'],
                $_POST['numero_mesa'],
                $_POST['fecha_reserva'],
                $_POST['hora_reserva'],
                $_POST['cantidad_personas'],
                $_POST['estado']
            );

            if ($resultado) {
                $_SESSION['mensaje'] = "Reserva modificada exitosamente";
                $_SESSION['tipo_mensaje'] = "success";
            } else {
                $_SESSION['mensaje'] = "Error al modificar reserva";
                $_SESSION['tipo_mensaje'] = "danger";
            }
        }
        header("Location: ../vista/reservas.php");
        exit();
    }

    private function eliminar($id) {
        if ($this->modelo->eliminarReserva($id)) {
            $_SESSION['mensaje'] = "Reserva eliminada exitosamente";
            $_SESSION['tipo_mensaje'] = "success";
        } else {
            $_SESSION['mensaje'] = "Error al eliminar reserva";
            $_SESSION['tipo_mensaje'] = "danger";
        }
        header("Location: ../vista/reservas.php");
        exit();
    }
}

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Crear instancia del controlador y procesar la acción
$controller = new ReservaController();
$controller->procesarAccion();
?>