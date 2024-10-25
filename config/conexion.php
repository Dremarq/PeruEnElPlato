<?php 

// Habilitar el reporte de errores
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Establecer conexión
try {
    $conexion = mysqli_connect('localhost', 'root', '', 'restaurante');
    // Establecer el conjunto de caracteres
    mysqli_set_charset($conexion, 'utf8');
} catch (mysqli_sql_exception $e) {
    die('Error de conexión: ' . $e->getMessage());
}

// Aquí puedes cerrar la conexión cuando ya no la necesites
// mysqli_close($conexion);

?>
