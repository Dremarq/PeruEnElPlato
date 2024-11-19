<?php
require_once '../modelo/producto.php';
require_once '../config/conexion.php';

class ProductoController {
    private $modelo;

    public function __construct() {
        global $conexion;
        $this->modelo = new Producto($conexion);
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
        if (!empty($_POST['nombre']) && !empty($_POST['descripcion']) && !empty($_POST['costo']) && 
            !empty($_POST['id_proveedor'])) {
            
            $resultado = $this->modelo->registrarProducto(
                $_POST['nombre'],
                $_POST['descripcion'],
                $_POST['costo'],
                $_POST['id_proveedor'] // Asegúrate de que esto sea el ID del proveedor
            );
    
            if ($resultado) {
                $_SESSION['mensaje'] = "Producto registrado exitosamente";
                $_SESSION['tipo_mensaje'] = "success";
            } else {
                $_SESSION['mensaje'] = "Error al registrar producto";
                $_SESSION['tipo_mensaje'] = "danger";
            }
        } else {
            $_SESSION['mensaje'] = "Todos los campos son requeridos";
            $_SESSION['tipo_mensaje'] = "warning";
        }
        header("Location: ../vista/productos.php");
        exit();
    }

    private function modificar() {
        if (!empty($_POST['id_producto'])) {
            $resultado = $this->modelo->modificarProducto(
                $_POST['id_producto'],
                $_POST['nombre'],
                $_POST['descripcion'],
                $_POST['costo'],
                $_POST['estado'],
                $_POST['id_proveedor']
            );

            if ($resultado) {
                $_SESSION['mensaje'] = "Producto modificado exitosamente";
                $_SESSION['tipo_mensaje'] = "success";
            } else {
                $_SESSION['mensaje'] = "Error al modificar producto";
                $_SESSION['tipo_mensaje'] = "danger";
            }
        } else {
            $_SESSION['mensaje'] = "ID de producto requerido";
            $_SESSION['tipo_mensaje'] = "warning";
        }
        header("Location: ../vista/productos.php");
        exit();
    }

    private function eliminar($id_producto) {
        if ($this->modelo->eliminarProducto($id_producto)) {
            $_SESSION['mensaje'] = "Producto eliminado exitosamente";
            $_SESSION['tipo_mensaje'] = "success";
        } else {
            $_SESSION['mensaje'] = "Error al eliminar producto";
            $_SESSION['tipo_mensaje'] = "danger";
        }
        header("Location: ../vista/productos.php");
        exit();
    }
}

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Crear instancia del controlador y procesar la acción
$controller = new ProductoController();
$controller->procesarAccion();
?>