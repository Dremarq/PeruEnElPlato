
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/styles/login.css">

    <title>Iniciar Sesión</title>
</head>

<body>

    <form action="../controlador/AuthController.php" method="POST">
        <label for="username">Usuario:</label>
        <input type="text" name="username" required>
        <br>
        <label for="password">Contraseña:</label>
        <input type="password" name="password" required>
        <br>
        <button type="submit">Iniciar Sesión</button>
    </form>
    <?php if (isset($error)) {
        echo "<p style='color:red;'>$error</p>";
    } ?>
</body>

</html>