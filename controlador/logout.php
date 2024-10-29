<?php
session_start(); // Iniciar la sesión
session_unset(); // Eliminar todas las variables de sesión
session_destroy(); // Destruir la sesión

header('Location: http://localhost/PeruEnElPlato/index.php'); // Redirigir a la página de inicio
exit(); // Asegurarse de que no se ejecute más código
?>