<?php
require_once '../modelo/cliente.php';
require_once '../config/conexion.php';
require_once('../public/lib/TCPDF-main/tcpdf.php');

class ClienteController
{
    private $modelo;

    public function __construct()
    {
        global $conexion;
        $this->modelo = new Cliente($conexion);
    }

    public function procesarAccion()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['accion'])) {
                switch ($_POST['accion']) {
                    case 'registrar':
                        return $this->registrar();
                    case 'modificar':
                        return $this->modificar();
                }
            }
        } elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if (isset($_GET['accion'])) {
                switch ($_GET['accion']) {
                    case 'eliminar':
                        return $this->eliminar($_GET['id']);
                    case 'generar_pdf':
                        return $this->generarPDF(); // Llamar a la función para generar PDF
                }
            }
        }
    }

    private function registrar()
    {
        if (
            !empty($_POST['nombre']) && !empty($_POST['apellido']) && !empty($_POST['dni']) &&
            !empty($_POST['telefono']) && !empty($_POST['email']) && !empty($_POST['direccion']) &&
            !empty($_POST['usuario']) && !empty($_POST['contrasena'])
        ) { // Cambiado 'password' a 'contrasena'

            $resultado = $this->modelo->registrarUsuario(
                $_POST['nombre'],
                $_POST['apellido'],
                $_POST['dni'],
                $_POST['telefono'],
                $_POST['email'],
                $_POST['direccion'],
                $_POST['usuario'],
                $_POST['contrasena'] // Cambiado 'password' a 'contrasena'
            );

            if ($resultado) {
                $_SESSION['mensaje'] = "Usuario registrado exitosamente";
                $_SESSION['tipo_mensaje'] = "success";
            } else {
                $_SESSION['mensaje'] = "Error al registrar usuario";
                $_SESSION['tipo_mensaje'] = "danger";
            }
        } else {
            $_SESSION['mensaje'] = "Por favor, complete todos los campos requeridos";
            $_SESSION['tipo_mensaje'] = "warning";
        }
        header("Location: ../vista/usuario.php");
    }

    private function login()
    {
        // Validar que el usuario y la contraseña estén presentes
        if (!empty($_POST['usuario']) && !empty($_POST['contrasena'])) { // Cambiado 'password' a 'contrasena'
            $clienteEncontrado = $this->modelo->verificarCredenciales($_POST['usuario'], $_POST['contrasena']); // Cambiado 'password' a 'contrasena'

            if ($clienteEncontrado) {
                $_SESSION['cliente_id'] = $clienteEncontrado['id_usuario'];
                header('Location: ../vista/cliente/inicio.php'); // Redirigir a la página del cliente
                exit();
            } else {
                header('Location: ../vista/loginCliente.php?error=Credenciales incorrectas');
                exit();
            }
        } else {
            header('Location: ../vista/loginCliente.php?error=Por favor, ingresa usuario y contraseña');
            exit();
        }
    }

    private function modificar()


    {
        var_dump($_POST);
        if (
            !empty($_POST['id_usuario']) && !empty($_POST['nombre']) && !empty($_POST['apellido']) &&
            !empty($_POST['dni']) && !empty($_POST['telefono']) && !empty($_POST['email']) &&
            !empty($_POST['direccion']) && !empty($_POST['usuario'])
        ) {

            $resultado = $this->modelo->modificarUsuario(
                $_POST['id_usuario'], // Cambiado aquí
                $_POST['nombre'],
                $_POST['apellido'],
                $_POST['dni'],
                $_POST['telefono'],
                $_POST['email'],
                $_POST['direccion'],
                $_POST['usuario'],
                $_POST['password']
            );

            if ($resultado) {
                $_SESSION['mensaje'] = "Usuario modificado exitosamente";
                $_SESSION['tipo_mensaje'] = "success";
            } else {
                $_SESSION['mensaje'] = "Error al modificar usuario";
                $_SESSION['tipo_mensaje'] = "danger";
            }
        } else {
            $_SESSION['mensaje'] = "Por favor, complete todos los campos requeridos";
            $_SESSION['tipo_mensaje'] = "warning";
        }
        header("Location: ../vista/usuario.php");
        exit();
    }
    private function generarPDF()
    {
        $clientes = $this->modelo->obtenerUsuarios(); // Obtén los clientes de la base de datos

        // Crear una instancia de FPDF
        $pdf = new TCPDF();
        $pdf->AddPage();
        $pdf->SetFont('helvetica', 'B', 16);
        $pdf->Cell(0, 10, 'Lista de Clientes', 0, 1, 'C');

        // Encabezados de la tabla
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(10, 10, 'ID', 1);
        $pdf->Cell(40, 10, 'Nombre', 1);
        $pdf->Cell(40, 10, 'Apellido', 1);
        $pdf->Cell(30, 10, 'DNI', 1);
        $pdf->Cell(30, 10, 'Teléfono', 1);
        $pdf->Cell(25, 10, 'cod. postal', 1);
        //$pdf->Cell(40, 10, 'Email', 1);
        $pdf->Ln();

        // Agregar los clientes a la tabla
        $pdf->SetFont('helvetica', '', 12);
        while ($cliente = $clientes->fetch_object()) {
            $pdf->Cell(10, 10, $cliente->id_usuario, 1);
            $pdf->Cell(40, 10, $cliente->nombre, 1);
            $pdf->Cell(40, 10, $cliente->apellido, 1);
            $pdf->Cell(30, 10, $cliente->dni, 1);
            $pdf->Cell(30, 10, $cliente->telefono, 1);
            $pdf->Cell(25, 10, $cliente->direccion, 1);
           // $pdf->Cell(40, 10, $cliente->email, 1);
            $pdf->Ln();
        }

        // Salida del PDF
        //$pdf->Output('D', 'clientes.pdf');
        $pdf->Output('cliente.pdf', 'I'); // Forzar la descarga del archivo PDF
        
    }

    private function eliminar($id)
    {
        if ($this->modelo->eliminarUsuario($id)) {
            $_SESSION['mensaje'] = "Usuario eliminado exitosamente";
            $_SESSION['tipo_mensaje'] = "success";
        } else {
            $_SESSION['mensaje'] = "Error al eliminar usuario";
            $_SESSION['tipo_mensaje'] = "danger";
        }
        header("Location: ../vista/usuario.php");
        exit();
    }
}

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Crear instancia del controlador y procesar la acción
$controller = new ClienteController();
$controller->procesarAccion();
