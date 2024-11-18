<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Cliente</title>
    <link rel="stylesheet" href="../public/styles/login.css">
</head>
<body>
    <div class="container">
        
        <form action="../controlador/CRUDcliente.php" method="POST">
            <label for="usuario">Usuario:</label>
            <input type="text" id="usuario" name="usuario" required>

            <label for="contrasena">Contraseña:</label> <!-- Cambiado 'password' a 'contrasena' -->
            <input type="password" id="contrasena" name="contrasena" required> <!-- Cambiado 'password' a 'contrasena' -->

            <button type="submit" name="accion" value="login">Iniciar Sesión</button>
        </form>
        <?php if (isset($_GET['error'])): ?>
            <p style="color: red;"><?= htmlspecialchars($_GET['error']) ?></p>
        <?php endif; ?>
    </div>
</body>
</html>