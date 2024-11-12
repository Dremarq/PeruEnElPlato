<?php
require_once '../modelo/Producto.php';
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
        if (!empty($_POST['nombre']) && !empty($_POST['descripcion']) && !empty($_POST['precio']) && 
            !empty($_POST['categoria'])) {
            
            // Manejar la subida de la imagen
            $imagen = $_FILES['imagen']['name'];
            $ruta = "../imagenes/" . $imagen; // Ajusta la ruta según tu estructura de carpetas
            move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta);

            $resultado = $this->modelo->registrarProducto(
                $_POST['nombre'],
                $_POST['descripcion'],
                $_POST['precio'],
                $_POST['categoria'],
                $imagen
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
                $_POST['precio'],
                $_POST['categoria'],
                $_POST['estado']
            );

            if ($resultado) {
                $_SESSION['mensaje'] = "Producto modificado exitosamente";
                $_SESSION['tipo_mensaje'] = "success";
            } else {
                $_SESSION['mensaje'] = "Error al modificar producto";
                $_SESSION['tipo_mensaje'] = "danger";
            }
        }
        header("Location: ../vista/productos.php");
        exit();
    }

    private function eliminar($id) {
        if ($this->modelo->eliminarProducto($id)) {
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