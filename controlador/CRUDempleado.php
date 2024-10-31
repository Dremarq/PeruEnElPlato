<?php
require_once '../modelo/Empleado.php';
require_once '../config/conexion.php';

class EmpleadoController {
    private $modelo;

    public function __construct() {
        global $conexion;
        $this->modelo = new Empleado($conexion);
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
        if (!empty($_POST['nombre']) && !empty($_POST['apellido']) && !empty($_POST['dni']) && 
            !empty($_POST['telefono']) && !empty($_POST['email']) && 
            !empty($_POST['rol'])) {
            
            $resultado = $this->modelo->registrarEmpleado(
                $_POST['nombre'],
                $_POST['apellido'],
                $_POST['dni'],
                $_POST['telefono'],
                $_POST['email'],
                $_POST['rol']
            );

            if ($resultado) {
                $_SESSION['mensaje'] = "Empleado registrado exitosamente";
                $_SESSION['tipo_mensaje'] = "success";
            } else {
                $_SESSION['mensaje'] = "Error al registrar empleado";
                $_SESSION['tipo_mensaje'] = "danger";
            }
        } else {
            $_SESSION['mensaje'] = "Todos los campos son requeridos";
            $_SESSION['tipo_mensaje'] = "warning";
        }
        header("Location: ../vista/empleados.php");
        exit();
    }

    private function modificar() {
        if (!empty($_POST['id_empleado'])) {
            $resultado = $this->modelo->modificarEmpleado(
                $_POST['id_empleado'],
                $_POST['nombre'],
                $_POST['apellido'],
                $_POST['dni'],
                $_POST['telefono'],
                $_POST['email'],
                $_POST['rol']
            );

            if ($resultado) {
                $_SESSION['mensaje'] = "Empleado modificado exitosamente";
                $_SESSION['tipo_mensaje'] = "success";
            } else {
                $_SESSION['mensaje'] = "Error al modificar empleado";
                $_SESSION['tipo_mensaje'] = "danger";
            }
        }
        header("Location: ../vista/empleados.php");
        exit();
    }

    private function eliminar($id) {
        if ($this->modelo->eliminarEmpleado($id)) {
            $_SESSION['mensaje'] = "Empleado eliminado exitosamente";
            $_SESSION['tipo_mensaje'] = "success";
        } else {
            $_SESSION['mensaje'] = "Error al eliminar empleado";
            $_SESSION['tipo_mensaje'] = "danger";
        }
        header("Location: ../vista/empleados.php");
        exit();
    }
}

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Crear instancia del controlador y procesar la acción
$controller = new EmpleadoController();
$controller->procesarAccion();
?>