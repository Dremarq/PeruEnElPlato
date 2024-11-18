<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/styles/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    <title>Iniciar Sesión</title>
</head>
<body>

   <form action="../controlador/AuthController.php" method="POST">
    <br>
    <label for="username">Usuario:</label>
    <input type="text" name="username" required>
    <br>
    <label for="password">Contraseña:</label>
    <input type="password" name="password" required>
    <br>
    <button type="submit">Iniciar Sesión</button>
    
</form>
<?php if (isset($_GET['error'])) {
        $error = htmlspecialchars($_GET['error'], ENT_QUOTES, 'UTF-8'); // Sanitizar el mensaje
        echo "<script>
            swal({
                title: 'Error',
                text: '$error',
                type: 'error',
                confirmButtonText: 'Aceptar'
            });
        </script>";
    } ?>

</body>
</html>