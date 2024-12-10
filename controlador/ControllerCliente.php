<?php
session_start();
require_once "../config/conexion.php";
require_once "../modelo/Cliente.php";
require_once "C:/xampp/htdocs/PeruEnElPlato/public/lib/PHPMailer/src/PHPMailer.php";
require_once "C:/xampp/htdocs/PeruEnElPlato/public/lib/PHPMailer/src/SMTP.php";
require_once "C:/xampp/htdocs/PeruEnElPlato/public/lib/PHPMailer/src/Exception.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


$clienteModelo = new Cliente($conexion);

if ($_POST['accion'] == 'login') {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena']; 

    // Verificar las credenciales del usuario
    $query = "SELECT * FROM usuarios WHERE usuario = '$usuario'";
    $result = mysqli_query($conexion, $query);
    
    if (mysqli_num_rows($result) > 0) {
        $usuarioData = mysqli_fetch_assoc($result);
        
        // Verificar la contraseña
        if (password_verify($contrasena, $usuarioData['contrasena'])) {
            // Almacenar datos en la sesión
            $_SESSION['nombre'] = $usuario['nombre'];
            $_SESSION['apellido'] = $usuario['apellido'];

            // Redirigir a la página de inicio
            header('Location: ../vista/clientes/inicio.php');
            exit();
        } else {
            // Contraseña incorrecta
            header('Location: ../vista/loginCliente.php?error=Contraseña incorrecta.');
            exit();
        }
    } else {
        // Usuario no encontrado
        header('Location: ../vista/loginCliente.php?error=Usuario no encontrado.');
        exit();
    }
}
if ($_POST['accion'] == 'enviar_enlace_restablecimiento') {
    $email = $_POST['email'];

    // Verificar si el correo existe en la base de datos
    $query = "SELECT * FROM usuarios WHERE email = '$email'";
    $result = mysqli_query($conexion, $query);

    if (mysqli_num_rows($result) > 0) {
        // Generar un token único
        $token = bin2hex(random_bytes(50));

        // Guardar el token en la base de datos con una fecha de expiración
        $query = "UPDATE usuarios SET token='$token', token_expires=DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE email='$email'";
        mysqli_query($conexion, $query);

        // Configurar PHPMailer
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Cambia por tu servidor SMTP
            $mail->SMTPAuth = true;
            $mail->Username = 'diegomartin1597534@gmail.com'; // Tu correo
            $mail->Password = 'serq wzas uhaa zqfe'; // Contraseña o token de aplicación
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Configurar destinatario y contenido
            $mail->setFrom('diegomartin1597534@gmail.com', 'PeruEnElPlato');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Restablecer Contraseña';
            $resetLink = "http://localhost/peruenelplato/controlador/restablecer_contrasena.php?token=$token";
            $mail->Body = "Haz clic en este enlace para restablecer tu contraseña: <a href='$resetLink'>$resetLink</a>";

            // Enviar correo
            $mail->send();
            echo "<script>
                    alert('Se ha enviado un enlace de restablecimiento a tu correo.');
                    window.location.href = '../vista/loginCliente.php';
                  </script>";
            exit();

        } catch (Exception $e) {
            echo "Error al enviar el correo: {$mail->ErrorInfo}";
        }
    } else {
        echo "<script>
                alert('El correo electrónico no está registrado.');
                window.location.href = '../vista/loginCliente.php';
              </script>";
        exit();
    }
}
if ($_POST['accion'] == 'cambiar_contrasena') {
    $token = $_POST['token'];
    $nuevaContrasena = $_POST['nueva_contrasena'];
    
    // Verifica si el token es válido
    $query = "SELECT * FROM usuarios WHERE token = '$token' AND token_expires > NOW()";
    $result = mysqli_query($conexion, $query);
    
    if (mysqli_num_rows($result) > 0) {
        // Hash de la nueva contraseña
        $hashedPassword = password_hash($nuevaContrasena, PASSWORD_DEFAULT);

        // Actualiza la contraseña en la base de datos
        $query = "UPDATE usuarios SET contrasena='$hashedPassword', token=NULL, token_expires=NULL WHERE token='$token'";
        if (mysqli_query($conexion, $query)) {
            // Redirigir al login con mensaje de éxito
            header('Location: ../vista/loginCliente.php?cambio=success');
            exit();
        } else {
            echo "Error al actualizar la contraseña.";
        }
    } else {
        echo "El token no es válido o ha expirado.";
    }
}

?>