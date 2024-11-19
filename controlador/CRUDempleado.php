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
        // Verificar que todos los campos requeridos estén llenos
        if (!empty($_POST['nombre']) && !empty($_POST['apellido']) && !empty($_POST['dni']) && 
            !empty($_POST['telefono']) && !empty($_POST['email']) && 
            !empty($_POST['rol']) && !empty($_POST['direccion']) && 
            !empty($_POST['fecha_contratacion'])) {

            // Verificar si el DNI ya existe
            if ($this->modelo->verificarDNI($_POST['dni'])) {
                $_SESSION['mensaje'] = "El DNI ya está registrado.";
                $_SESSION['tipo_mensaje'] = "danger";
                header("Location: ../vista/empleados.php");
                exit();
            }

            // Verificar si el teléfono ya existe
            if ($this->modelo->verificarTelefono($_POST['telefono'])) {
                $_SESSION['mensaje'] = "El teléfono ya está registrado.";
                $_SESSION['tipo_mensaje'] = "danger";
                header("Location: ../vista/empleados.php");
                exit();
            }

            // Si no existen, registrar el empleado
            $resultado = $this->modelo->registrarEmpleado(
                $_POST['nombre'],
                $_POST['apellido'],
                $_POST['dni'],
                $_POST['telefono'],
                $_POST['email'],
                $_POST['direccion'],
                $_POST['fecha_contratacion'],
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
            // Verificar si el DNI ya existe (excepto para el empleado actual)
            if ($this->modelo->verificarDNI($_POST['dni'], $_POST['id_empleado'])) {
                $_SESSION['mensaje'] = "El DNI ya está registrado.";
                $_SESSION['tipo_mensaje'] = "danger";
                header("Location: ../vista/empleados.php");
                exit();
            }

            // Verificar si el teléfono ya existe (excepto para el empleado actual)
            if ($this->modelo->verificarTelefono($_POST['telefono'], $_POST['id_empleado'])) {
                $_SESSION['mensaje'] = "El teléfono ya está registrado.";
                $_SESSION['tipo_mensaje'] = "danger";
                header("Location: ../vista/empleados.php");
                exit();
            }

            $resultado = $this->modelo->modificarEmpleado(
                $_POST['id_empleado'],
                $_POST['nombre'],
                $_POST['apellido'],
                $_POST['dni'],
                $_POST['telefono'],
                $_POST['email'],
                $_POST['direccion'],
                $_POST['fecha_contratacion'],
                $_POST['rol']
            );

            if ($resultado) {
                $_SESSION['mensaje'] = "Empleado modificado exitosamente";
                $_SESSION['tipo_mensaje'] = "success";
            } else {
                $_SESSION['mensaje'] = "Error al modificar empleado";
                $_SESSION['tipo_mensaje'] = "danger";
            }
        } else {
            $_SESSION['mensaje'] = "ID de empleado requerido";
            $_SESSION['tipo_mensaje'] = "warning";
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