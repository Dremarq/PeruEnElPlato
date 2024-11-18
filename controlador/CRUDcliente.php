<?php
require_once '../modelo/cliente.php';
require_once '../config/conexion.php';

class ClienteController {
    private $modelo;

    public function __construct() {
        global $conexion;
        $this->modelo = new Cliente($conexion);
    }

    public function procesarAccion() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['accion'])) {
                switch ($_POST['accion']) {
                    case 'registrar':
                        return $this->registrar();
                        case 'login':
                            return $this->login();
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
            !empty($_POST['telefono']) && !empty($_POST['email']) && !empty($_POST['direccion']) && 
            !empty($_POST['usuario']) && !empty($_POST['contrasena'])) { // Cambiado 'password' a 'contrasena'
            
            $resultado = $this->modelo->registrarUsuario(
                $_POST['nombre'],
                $_POST['apellido'],
                $_POST['dni'],
                $_POST['telefono'],
                $_POST['email'],
                $_POST['direccion'],
                $_POST['usuario'],
                $_POST['contrasena'] // Cambiado 'password' a 'contrasena'
            );

            if ($resultado) {
                $_SESSION['mensaje'] = "Usuario registrado exitosamente";
                $_SESSION['tipo_mensaje'] = "success";
            } else {
                $_SESSION['mensaje'] = "Error al registrar usuario";
                $_SESSION['tipo_mensaje'] = "danger";
            }
        } else {
            $_SESSION['mensaje'] = "Por favor, complete todos los campos requeridos";
            $_SESSION['tipo_mensaje'] = "warning";
        }
        header("Location: ../vista/usuario.php");
    }

    private function login() {
        // Validar que el usuario y la contraseña estén presentes
        if (!empty($_POST['usuario']) && !empty($_POST['contrasena'])) { // Cambiado 'password' a 'contrasena'
            $clienteEncontrado = $this->modelo->verificarCredenciales($_POST['usuario'], $_POST['contrasena']); // Cambiado 'password' a 'contrasena'

            if ($clienteEncontrado) {
                $_SESSION['cliente_id'] = $clienteEncontrado['id_usuario'];
                header('Location: ../vista/cliente/inicio.php'); // Redirigir a la página del cliente
                exit();
            } else {
                header('Location: ../vista/loginCliente.php?error=Credenciales incorrectas');
                exit();
            }
        } else {
            header('Location: ../vista/loginCliente.php?error=Por favor, ingresa usuario y contraseña');
            exit();
        }
    }

    private function modificar() {
        if (!empty($_POST['id_usuario']) && !empty($_POST['nombre']) && !empty($_POST['apellido']) && 
            !empty($_POST['dni']) && !empty($_POST['telefono']) && !empty($_POST['email']) && 
            !empty($_POST['direccion']) && !empty($_POST['usuario']) && !empty($_POST['password'])) {
            
            $resultado = $this->modelo->modificarUsuario(
                $_POST['id_usuario'], // Cambiado aquí
                $_POST['nombre'],
                $_POST['apellido'],
                $_POST['dni'],
                $_POST['telefono'],
                $_POST['email'],
                $_POST['direccion'],
                $_POST['usuario'],
                $_POST['password']
            );
    
            if ($resultado) {
                $_SESSION['mensaje'] = "Usuario modificado exitosamente";
                $_SESSION['tipo_mensaje'] = "success";
            } else {
                $_SESSION['mensaje'] = "Error al modificar usuario";
                $_SESSION['tipo_mensaje'] = "danger";
            }
        } else {
            $_SESSION['mensaje'] = "Por favor, complete todos los campos requeridos";
            $_SESSION['tipo_mensaje'] = "warning";
        }
        header("Location: ../vista/usuario.php");
    }

    private function eliminar($id) {
        if ($this->modelo->eliminarUsuario($id)) {
            $_SESSION['mensaje'] = "Usuario eliminado exitosamente";
            $_SESSION['tipo_mensaje'] = "success";
        } else {
            $_SESSION['mensaje'] = "Error al eliminar usuario";
            $_SESSION['tipo_mensaje'] = "danger";
        }
        header("Location: ../vista/usuario.php");
        exit();
    }
}

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Crear instancia del controlador y procesar la acción
$controller = new ClienteController();
$controller->procesarAccion();
?>