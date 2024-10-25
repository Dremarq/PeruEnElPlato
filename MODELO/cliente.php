<?php
class Usuario {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion; // Conexión a la base de datos
    }

    // Método para obtener todos los usuarios
    public function obtenerUsuarios() {
        $sql = "SELECT `id_usuario`, `nombre`, `apellido`, `dni`, `telefono`, `email`, `direccion`, `fecha_registro` FROM `usuarios`";
        $result = mysqli_query($this->conexion, $sql);
        
        $usuarios = [];
        while($row = mysqli_fetch_assoc($result)) {
            $usuarios[] = $row; // Almacenar cada fila en un array
        }
        return $usuarios; // Retornar el array de usuarios
    }
}
?>