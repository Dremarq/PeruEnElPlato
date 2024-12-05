<?php
session_start();
require_once "../config/conexion.php";
require_once "../modelo/Cliente.php";
// Verificar el token
if (isset($_GET['token'])) {
    $token = $_GET['token'];
    
    // Verificar si el token es válido
    $query = "SELECT * FROM usuarios WHERE token='$token' AND token_expires > NOW()";
    $result = mysqli_query($conexion, $query);
    
    if (mysqli_num_rows($result) > 0) {
        // Mostrar formulario para restablecer la contraseña
        ?>
        <form action="../controlador/ControllerCliente.php" method="POST">
            <input type="hidden" name="accion" value="cambiar_contrasena">
            <input type="hidden" name="token" value="<?= $token ?>">
            <div>
                <label for="nueva_contrasena">Nueva Contraseña:</label>
                <input type="password" id="nueva_contrasena" name="nueva_contrasena" required>
            </div>
            <button type="submit">Cambiar Contraseña</button>
        </form>
        <?php
    } else {
        echo "El token es inválido o ha expirado.";
    }
}
?>
