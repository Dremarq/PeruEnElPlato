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
    public function contarUsuarios() {
        $query = "SELECT COUNT(*) as total FROM usuarios"; // Cambia 'usuarios' por el nombre de tu tabla
        $resultado = $this->conexion->query($query);
        $total = $resultado->fetch_assoc();
        return $total['total'];
    }
    
    public function obtenerUsuariosLimit($inicio, $registrosPorPagina) {
        $query = "SELECT * FROM usuarios LIMIT $inicio, $registrosPorPagina"; // Cambia 'usuarios' por el nombre de tu tabla
        return $this->conexion->query($query);
    }

    public function registrarUsuario($nombre, $apellido, $dni, $telefono, $email, $direccion, $usuario, $password) {
        // Verificar si el DNI ya existe
        if ($this->verificarDNIExistente($dni)) {
            return false; // Retorna false si el DNI ya existe
        }
    
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Encriptar la contraseña
        $query = "INSERT INTO usuarios (nombre, apellido, dni, telefono, email, direccion, usuario, contrasena, fecha_registro) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($query);
        $fecha_registro = date('Y-m-d'); // O la fecha que desees
        $stmt->bind_param("sssssssss", $nombre, $apellido, $dni, $telefono, $email, $direccion, $usuario, $hashedPassword, $fecha_registro);
        return $stmt->execute();
    }
    
    // Método para verificar si el DNI ya existe
    private function verificarDNIExistente($dni) {
        $stmt = $this->conexion->prepare("SELECT COUNT(*) as total FROM usuarios WHERE dni = ?");
        $stmt->bind_param("s", $dni);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $row = $resultado->fetch_assoc();
        return $row['total'] > 0; // Retorna true si el DNI ya existe
    }

    public function modificarUsuario($id, $nombre, $apellido, $dni, $telefono, $email, $direccion, $usuario, $password = null)
{
    try {
        if ($password) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $query = "UPDATE usuarios SET nombre = ?, apellido = ?, dni = ?, telefono = ?, email = ?, direccion = ?, usuario = ?, contrasena = ? WHERE id_usuario = ?";
            $stmt = $this->conexion->prepare($query);
            $stmt->bind_param("ssssssssi", $nombre, $apellido, $dni, $telefono, $email, $direccion, $usuario, $hashedPassword, $id);
        } else {
            $query = "UPDATE usuarios SET nombre = ?, apellido = ?, dni = ?, telefono = ?, email = ?, direccion = ?, usuario = ? WHERE id_usuario = ?";
            $stmt = $this->conexion->prepare($query);
            $stmt->bind_param("sssssssi", $nombre, $apellido, $dni, $telefono, $email, $direccion, $usuario, $id);
        }

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
            if (password_verify($password, $usuarioDB['contrasena'])) {
                return $usuarioDB; // Devuelve todos los datos del usuario
            }
        }
        return false; // Usuario o contraseña incorrectos
    }
    
}

