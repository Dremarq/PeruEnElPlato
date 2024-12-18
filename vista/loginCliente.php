
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Cliente</title>
    <link rel="stylesheet" href="../public/styles/login.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
   
</head>
<style>
        /* Estilo para centrar el formulario */
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }
       
            
        .modal-content { border-radius: 15px; } 
        .modal-dialog{max-width: 26%;}
        .modal-content{width: 100%;}
        .modal-header { background-color: #007bff; color: white; border-top-left-radius: 10px; border-top-right-radius: 10px; } 
        .modal-title { font-weight: bold; } 
        .modal-body { padding: 20px; } 
        .form-label { font-weight: bold; } 
        .form-control { border-radius: 5px; border: 1px solid #ced4da; } 
        .btn-primary { background-color: #007bff; border: none; border-radius: 5px; } 
        .btn-primary:hover { background-color: #0056b3; } 
        .mb-3 { margin-bottom: 15px; }
    </style>
    
<body>
    <div class="container">
        <form action="../controlador/CRUDcliente.php" method="POST">
            <label for="usuario">Usuario:</label>
            <input type="text" id="usuario" name="usuario" required>

            <label for="contrasena">Contraseña:</label>
            <input type="password" id="contrasena" name="contrasena" required>

            <button type="submit" name="accion" value="login">Iniciar Sesión</button>
            <br>
            <br>
            <div>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#registroModal">
                    Registrar Nuevo Usuario
                </button>
            </div>
            <div>
                <a href="#" data-bs-toggle="modal" data-bs-target="#resetPasswordModal">¿Olvidaste tu contraseña?</a>
            </div>
        </form>



        <?php if (isset($_GET['error'])): ?>
            <p style="color: red;"><?= htmlspecialchars($_GET['error']) ?></p>
        <?php endif; ?>
    </div>

    <!-- Modal de registro -->
    <div class="modal fade" id="registroModal" tabindex="-1" aria-labelledby="registroModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registroModalLabel">Registro de Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="../controlador/ControllerCliente.php" method="POST">
                        <input type="hidden" name="accion" value="registrar">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre:</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="apellido" class="form-label">Apellido:</label>
                            <input type="text" class="form-control" id="apellido" name="apellido" required>
                        </div>
                        <div class="mb-3">
                            <label for="dni" class="form-label">DNI:</label>
                            <input type="text" class="form-control" id="dni" name="dni" required>
                        </div>
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono:</label>
                            <input type="text" class="form-control" id="telefono" name="telefono" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección:</label>
                            <input type="text" class="form-control" id="direccion" name="direccion" required>
                        </div>
                        <div class="mb-3">
                            <label for="usuarioRegistro" class="form-label">Usuario:</label>
                            <input type="text" class="form-control" id="usuarioRegistro" name="usuario" required>
                        </div>
                        <div class="mb-3">
                            <label for="contrasenaRegistro" class="form-label">Contraseña:</label>
                            <input type="password" class="form-control" id="contrasenaRegistro" name="contrasena" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal para restablecer la contraseña -->
<div class="modal fade" id="resetPasswordModal" tabindex="-1" aria-labelledby="resetPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="resetPasswordModalLabel">Restablecer Contraseña</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="../controlador/ControllerCliente.php" method="POST">
                    <input type="hidden" name="accion" value="enviar_enlace_restablecimiento">
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo Electrónico:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Enviar Enlace</button>
                </form>
            </div>
        </div>
    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>