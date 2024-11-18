<?php
session_start(); // Iniciar la sesión
session_unset(); // Eliminar todas las variables de sesión
session_destroy(); // Destruir la sesión

// Redirigir a la página de inicio con un parámetro de éxito
header('Location: http://localhost/PeruEnElPlato/index.php?logout=success'); 
exit(); // Asegurarse de que no se ejecute más código
?>