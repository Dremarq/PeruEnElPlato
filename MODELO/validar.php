<?php

$username = $_POST['usuario'];
$password = $_POST['contraseña'];
session_start();
$_SESSION['usuario'] = $username;

$conexion = mysqli_connect('localhost', 'root', '', 'restaurante');

$consulta = "SELECT * FROM admin where username='$username' and password='$password' ";
$resultado = mysqli_query($conexion, $consulta);

$filas = mysqli_num_rows($resultado);

if ($filas) {
    header("location:../VISTA/admi.html");
} else {
?>
    <?php
    include("../VISTA/login.html");
    ?>
    <h1 class="bad">ERROR EN LA AUTENTICACION</h1>
<?php
}
mysqli_free_result($resultado);
mysqli_close($conexion);
