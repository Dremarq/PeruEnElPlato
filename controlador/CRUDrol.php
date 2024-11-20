<?php
require_once '../modelo/rol.php';
require_once '../config/conexion.php';

class RolController {
    private $modelo;

    public function __construct() {
        global $conexion;
        $this->modelo = new Rol($conexion);
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
        if (!empty($_POST['nombre_rol']) && !empty($_POST['descripcion'])) {
            $resultado = $this->modelo->registrarRol($_POST['nombre_rol'], $_POST['descripcion']);

            if ($resultado) {
                $_SESSION['mensaje'] = "Rol registrado exitosamente";
                $_SESSION['tipo_mensaje'] = "success";
            } else {
                $_SESSION['mensaje'] = "Error al registrar rol";
                $_SESSION['tipo_mensaje'] = "danger";
            }
        } else {
            $_SESSION['mensaje'] = "Todos los campos son requeridos";
            $_SESSION['tipo_mensaje'] = "warning";
        }
        header("Location: ../vista/roles.php");
        exit();
    }

    private function modificar() {
        if (!empty($_POST['id_rol'])) {
            $resultado = $this->modelo->modificarRol($_POST['id_rol'], $_POST['nombre_rol'], $_POST['descripcion']);

            if ($resultado) {
                $_SESSION['mensaje'] = "Rol modificado exitosamente";
                $_SESSION['tipo_mensaje'] = "success";
            } else {
                $_SESSION['mensaje'] = "Error al modificar rol";
                $_SESSION['tipo_mensaje'] = "danger";
            }
        }
        header("Location: ../vista/roles.php");
        exit();
    }

    private function eliminar($id) {
        if ($this->modelo->eliminarRol($id)) {
            $_SESSION['mensaje'] = "Rol eliminado exitosamente";
            $_SESSION['tipo_mensaje'] = "success";
        } else {
            $_SESSION['mensaje'] = "Error al eliminar rol";
            $_SESSION['tipo_mensaje'] = "danger";
        }
        header("Location: ../vista/roles.php");
        exit();
    }
}

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Crear instancia del controlador y procesar la acción
$controller = new RolController();
$controller->procesarAccion();
?>