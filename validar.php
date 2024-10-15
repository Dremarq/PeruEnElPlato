<?php

$usuario = $_POST['usuario'];
$contraseña = $_POST['contraseña'];
session_start();
$_SESSION['usuario'] = $usuario;

$conexion = mysqli_connect('localhost', 'root', '', 'restaurante');

$consulta = "SELECT * FROM usuario where usuario='$usuario' and contraseña='$contraseña' ";
$resultado = mysqli_query($conexion, $consulta);

$filas = mysqli_num_rows($resultado);

if ($filas) {
    header("location:admin.php");
} else {
?>
    <?php
    include("login.html");
    ?>
    <h1 class="bad">ERROR EN LA AUTENTICACION</h1>
<?php
}
mysqli_free_result($resultado);
mysqli_close($conexion);
