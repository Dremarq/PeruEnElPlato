<?php
require_once '../modelo/plato.php'; // Asegúrate de que el nombre del archivo sea correcto
require_once '../config/conexion.php';

class PlatoController {
    private $modelo;

    public function __construct() {
        global $conexion;
        $this->modelo = new Plato($conexion);
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
            $ruta = "../public/img/". $imagen; // Ajusta la ruta según tu estructura de carpetas
            move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta);

            $resultado = $this->modelo->registrarPlato(
                $_POST['nombre'],
                $_POST['descripcion'],
                $_POST['precio'],
                $_POST['categoria'],
                $imagen
            );
            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta)) {
                // La imagen se ha subido correctamente
            } else {
                $_SESSION['mensaje'] = "Error al subir la imagen";
                $_SESSION['tipo_mensaje'] = "danger";
            }
            if ($resultado) {
                $_SESSION['mensaje'] = "Plato registrado exitosamente";
                $_SESSION['tipo_mensaje'] = "success";
            } else {
                $_SESSION['mensaje'] = "Error al registrar plato";
                $_SESSION['tipo_mensaje'] = "danger";
            }
        } else {
            $_SESSION['mensaje'] = "Todos los campos son requeridos";
            $_SESSION['tipo_mensaje'] = "warning";
        }
        header("Location: ../vista/platos.php");
        exit();
    }

    private function modificar() {
        if (!empty($_POST['id_plato'])) {
            $resultado = $this->modelo->modificarPlato(
                $_POST['id_plato'],
                $_POST['nombre'],
                $_POST['descripcion'],
                $_POST['precio'],
                $_POST['categoria'],
                $_POST['estado']
            );

            if ($resultado) {
                $_SESSION['mensaje'] = "Plato modificado exitosamente";
                $_SESSION['tipo_mensaje'] = "success";
            } else {
                $_SESSION['mensaje'] = "Error al modificar plato";
                $_SESSION['tipo_mensaje'] = "danger";
            }
        } else {
            $_SESSION['mensaje'] = "ID de plato requerido";
            $_SESSION['tipo_mensaje'] = "warning";
        }
        header("Location: ../vista/platos.php");
        exit();
    }

    private function eliminar($id_plato) {
        $resultado = $this->modelo->eliminarPlato($id_plato);
        if ($resultado) {
            $_SESSION['mensaje'] = "Plato eliminado exitosamente";
            $_SESSION['tipo_mensaje'] = "success";
        } else {
            $_SESSION['mensaje'] = "Error al eliminar plato";
            $_SESSION['tipo_mensaje'] = "danger";
        }
        header("Location: ../vista/platos.php");
        exit();
    }
}

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Crear instancia del controlador y procesar la acción
$controller = new PlatoController();
$controller->procesarAccion();