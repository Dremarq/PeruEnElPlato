<?php
class Auth {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function verificarCredenciales($username, $password) {
        $sql = "SELECT * FROM login_sesion WHERE username = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            $usuario = $resultado->fetch_assoc();
            // Comparar la contraseña directamente
            if ($password === $usuario['password']) { // Comparar la contraseña sin hash
                return $usuario; // Devuelve los datos del usuario si son correctos
            }
        }
        return false; // Usuario o contraseña incorrectos
    }
}
?>