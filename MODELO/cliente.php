<?php
class ClientesModel {
    private $conn;

    public function __construct($conexion) {
        $this->conn = $conexion;
    }

    public function getAllClientes() {
        $query = "SELECT `id_usuario`, `nombre`, `apellido`, `dni`, `telefono`, `email`, `direccion`, `fecha_registro` FROM `usuarios`";
        $result = mysqli_query($this->conn, $query);

        if (!$result) {
            die("Error en la consulta: " . mysqli_error($this->conn));
        }

        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
}
?>