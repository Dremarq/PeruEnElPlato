<?php

class Admin {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function verificarCredenciales($username, $password) {
        // Consulta para verificar las credenciales
        $stmt = $this->conexion->prepare("SELECT * FROM admin WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $resultado = $stmt->get_result();

        // Verificar si el usuario existe
        if ($resultado->num_rows > 0) {
            $admin = $resultado->fetch_assoc();
            // Verificar la contraseña (asumiendo que está en texto plano; deberías usar hash en producción)
            if ($admin['password'] === $password) {
                return $admin; // Devuelve los datos del admin si son correctos
            }
        }
        return false; // Usuario o contraseña incorrectos
    }
}

?>