<?php
class Cliente
{
    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    public function obtenerUsuarios()
    {
        try {
            $query = "SELECT id_usuario, nombre, apellido, dni, telefono, email, direccion, usuario, contrasena, fecha_registro 
                     FROM usuarios"; // Cambiado 'password' a 'contrasena'
            return $this->conexion->query($query);
        } catch (Exception $e) {
            error_log("Error en obtenerUsuarios: " . $e->getMessage());
            return false;
        }
    }

    public function registrarUsuario($nombre, $apellido, $dni, $telefono, $email, $direccion, $usuario, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Encriptar la contraseña
        $query = "INSERT INTO usuarios (nombre, apellido, dni, telefono, email, direccion, usuario, contrasena, fecha_registro) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($query);
        $fecha_registro = date('Y-m-d'); // O la fecha que desees
        $stmt->bind_param("sssssssss", $nombre, $apellido, $dni, $telefono, $email, $direccion, $usuario, $hashedPassword, $fecha_registro);
        return $stmt->execute();
    }

    public function modificarUsuario($id, $nombre, $apellido, $dni, $telefono, $email, $direccion, $usuario, $password)
    {
        try {
            $query = "UPDATE usuarios SET nombre = ?, apellido = ?, dni = ?, telefono = ?, email = ?, direccion = ?, usuario = ?, contrasena = ? WHERE id_usuario = ?"; // Cambiado 'password' a 'contrasena'
            $stmt = $this->conexion->prepare($query);
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt->bind_param("ssssssssi", $nombre, $apellido, $dni, $telefono, $email, $direccion, $usuario, $hashedPassword, $id);

            // Depuración: Imprimir la consulta y los parámetros
            echo "Ejecutando consulta: $query con parámetros: $nombre, $apellido, $dni, $telefono, $email, $direccion, $usuario, $hashedPassword, $id";

            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Error en modificarUsuario: " . $e->getMessage());
            return false;
        }
    }


    public function eliminarUsuario($id)
    {
        try {
            $query = "DELETE FROM usuarios WHERE id_usuario = ?";
            $stmt = $this->conexion->prepare($query);
            $stmt->bind_param("i", $id);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Error en eliminarUsuario: " . $e->getMessage());
            return false;
        }
    }

    public function verificarCredenciales($usuario, $password) {
        $stmt = $this->conexion->prepare("SELECT * FROM usuarios WHERE usuario = ?");
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();
    
        if ($resultado->num_rows > 0) {
            $usuarioDB = $resultado->fetch_assoc();
            if (password_verify($password, $usuarioDB['contrasena'])) { // Cambiado 'password' a 'contrasena'
                return $usuarioDB; // Devuelve los datos del usuario si son correctos
            }
        }
        return false; // Usuario o contraseña incorrectos
    }
    
}

