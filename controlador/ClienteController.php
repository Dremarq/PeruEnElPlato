<?php
include 'modelo/cliente.php'; // Incluir el modelo

class UsuarioController {
    private $usuarioModel;

    public function __construct($conexion) {
        $this->usuarioModel = new Usuario($conexion); // Crear una instancia del modelo
    }

    // Método para mostrar los usuarios
    public function mostrarUsuarios() {
        return $this->usuarioModel->obtenerUsuarios(); // Obtener usuarios del modelo
    }
}

// Crear una instancia del controlador
$usuarioController = new UsuarioController($conexion); // Pasar la conexión
$usuarios = $usuarioController->mostrarUsuarios(); // Obtener los usuarios
?>