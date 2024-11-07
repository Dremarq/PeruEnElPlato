<?php
require_once '../modelo/proveedores.php';
require_once '../config/conexion.php';

class ProveedorController {
    private $modelo;

    public function __construct() {
        global $conexion;
        $this->modelo = new Proveedor($conexion);
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
        if (!empty($_POST['nombre_empresa']) && !empty($_POST['ruc']) && !empty($_POST['telefono']) && 
            !empty($_POST['email']) && !empty($_POST['direccion'])) {
            
            $resultado = $this->modelo->registrarProveedor(
                $_POST['nombre_empresa'],
                $_POST['ruc'],
                $_POST['telefono'],
                $_POST['email'],
                $_POST['direccion']
            );

            if ($resultado) {
                $_SESSION['mensaje'] = "Proveedor registrado exitosamente";
                $_SESSION['tipo_mensaje'] = "success";
            } else {
                $_SESSION['mensaje'] = "Error al registrar proveedor";
                $_SESSION['tipo_mensaje'] = "danger";
            }
        } else {
            $_SESSION['mensaje'] = "Todos los campos son requeridos";
            $_SESSION['tipo_mensaje'] = "warning";
        }
        header("Location: ../vista/proveedores.php");
        exit();
    }
    private function modificar() {
        if (!empty($_POST['id_proveedor'])) {
            $resultado = $this->modelo->modificarProveedor(
                $_POST['id_proveedor'],
                $_POST['nombre_empresa'],
                $_POST['ruc'],
                $_POST['telefono'],
                $_POST['email'],
                $_POST['direccion'],
                $_POST['estado']
            );
    
            if ($resultado) {
                $_SESSION['mensaje'] = "Proveedor modificado exitosamente";
                $_SESSION['tipo_mensaje'] = "success";
            } else {
                $_SESSION['mensaje'] = "Error al modificar proveedor";
                $_SESSION['tipo_mensaje'] = "danger";
            }
        }
        header("Location: ../vista/proveedores.php");
        exit();
    }

    private function eliminar($id) {
        if ($this->modelo->eliminarProveedor($id)) {
            $_SESSION['mensaje'] = "Proveedor eliminado exitosamente";
            $_SESSION['tipo_mensaje'] = "success";
        } else {
            $_SESSION['mensaje'] = "Error al eliminar proveedor";
            $_SESSION['tipo_mensaje'] = "danger";
        }
        header("Location: ../vista/proveedores.php");
        exit();
    }
}

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Crear instancia del controlador y procesar la acción
$controller = new ProveedorController();
$controller->procesarAccion();
?>