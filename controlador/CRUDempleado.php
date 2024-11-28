<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

require_once '../modelo/Empleado.php';
require_once '../config/conexion.php';
require_once('../public/lib/TCPDF-main/tcpdf.php');

class EmpleadoController
{
    private $modelo;

    public function __construct()
    {
        global $conexion;
        $this->modelo = new Empleado($conexion);
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
                        case 'generar_excel':
                            return $this->generarExcel();
                    case 'generar_pdf':
                        return $this->generarPDF();
                  
                }
            }
        }
    }

    private function registrar()
    {
        // Verificar que todos los campos requeridos estén llenos
        if (
            !empty($_POST['nombre']) && !empty($_POST['apellido']) && !empty($_POST['dni']) &&
            !empty($_POST['telefono']) && !empty($_POST['email']) &&
            !empty($_POST['rol']) && !empty($_POST['direccion']) &&
            !empty($_POST['fecha_contratacion'])
        ) {

            // Verificar si el DNI ya existe
            if ($this->modelo->verificarDNI($_POST['dni'])) {
                $_SESSION['mensaje'] = "El DNI ya está registrado.";
                $_SESSION['tipo_mensaje'] = "danger";
                header("Location: ../vista/empleados.php");
                exit();
            }

            // Verificar si el teléfono ya existe
            if ($this->modelo->verificarTelefono($_POST['telefono'])) {
                $_SESSION['mensaje'] = "El teléfono ya está registrado.";
                $_SESSION['tipo_mensaje'] = "danger";
                header("Location: ../vista/empleados.php");
                exit();
            }

            // Si no existen, registrar el empleado
            $resultado = $this->modelo->registrarEmpleado(
                $_POST['nombre'],
                $_POST['apellido'],
                $_POST['dni'],
                $_POST['telefono'],
                $_POST['email'],
                $_POST['direccion'],
                $_POST['fecha_contratacion'],
                $_POST['rol']
            );

            if ($resultado) {
                $_SESSION['mensaje'] = "Empleado registrado exitosamente";
                $_SESSION['tipo_mensaje'] = "success";
            } else {
                $_SESSION['mensaje'] = "Error al registrar empleado";
                $_SESSION['tipo_mensaje'] = "danger";
            }
        } else {
            $_SESSION['mensaje'] = "Todos los campos son requeridos";
            $_SESSION['tipo_mensaje'] = "warning";
        }
        header("Location: ../vista/empleados.php");
        exit();
    }

    private function modificar()
    {
        if (!empty($_POST['id_empleado'])) {
            // Verificar si el DNI ya existe (excepto para el empleado actual)
            if ($this->modelo->verificarDNI($_POST['dni'], $_POST['id_empleado'])) {
                $_SESSION['mensaje'] = "El DNI ya está registrado.";
                $_SESSION['tipo_mensaje'] = "danger";
                header("Location: ../vista/empleados.php");
                exit();
            }

            // Verificar si el teléfono ya existe (excepto para el empleado actual)
            if ($this->modelo->verificarTelefono($_POST['telefono'], $_POST['id_empleado'])) {
                $_SESSION['mensaje'] = "El teléfono ya está registrado.";
                $_SESSION['tipo_mensaje'] = "danger";
                header("Location: ../vista/empleados.php");
                exit();
            }

            $resultado = $this->modelo->modificarEmpleado(
                $_POST['id_empleado'],
                $_POST['nombre'],
                $_POST['apellido'],
                $_POST['dni'],
                $_POST['telefono'],
                $_POST['email'],
                $_POST['direccion'],
                $_POST['fecha_contratacion'],
                $_POST['rol']
            );

            if ($resultado) {
                $_SESSION['mensaje'] = "Empleado modificado exitosamente";
                $_SESSION['tipo_mensaje'] = "success";
            } else {
                $_SESSION['mensaje'] = "Error al modificar empleado";
                $_SESSION['tipo_mensaje'] = "danger";
            }
        } else {
            $_SESSION['mensaje'] = "ID de empleado requerido";
            $_SESSION['tipo_mensaje'] = "warning";
        }

        header("Location: ../vista/empleados.php");
        exit();
    }
    private function generarPDF()
    {
        $empleado = $this->modelo->obtenerEmpleados(); // Obtén los clientes de la base de datos

        // Crear una instancia de FPDF
        $pdf = new TCPDF();
        $pdf->AddPage();
        $pdf->SetFont('helvetica', 'B', 15);
        $pdf->Cell(0, 10, 'Lista de Empleados', 0, 1, 'C');

        // Encabezados de la tabla
        $pdf->SetFont('helvetica', 'B', 11,);
        $pdf->Cell(10, 10, 'ID', 1, 0, 'C');
        $pdf->Cell(40, 10, 'Nombre', 1, 0, 'C');
        $pdf->Cell(40, 10, 'Apellido', 1, 0, 'C');
        $pdf->Cell(23, 10, 'DNI', 1, 0, 'C');
        $pdf->Cell(25, 10, 'Teléfono', 1, 0, 'C');
        $pdf->Cell(25, 10, 'cod. postal', 1, 0, 'C');
        $pdf->Cell(25, 10, 'fech_con', 1, 0, 'C');
        //$pdf->Cell(40, 10, 'Email', 1);
        $pdf->Ln();

        // Agregar los clientes a la tabla
        $pdf->SetFont('helvetica', '', 10);
        while ($cliente = $empleado->fetch_object()) {
            $pdf->Cell(10, 10, $cliente->id_empleado, 1, 0, 'C');
            $pdf->Cell(40, 10, $cliente->nombre, 1, 0, 'C');
            $pdf->Cell(40, 10, $cliente->apellido, 1, 0, 'C');
            $pdf->Cell(23, 10, $cliente->dni, 1, 0, 'C');
            $pdf->Cell(25, 10, $cliente->telefono, 1, 0, 'C');
            $pdf->Cell(25, 10, $cliente->direccion, 1, 0, 'C');
            $pdf->Cell(25, 10, $cliente->fecha_contratacion, 1, 0, 'C');
            // $pdf->Cell(40, 10, $cliente->email, 1);
            $pdf->Ln();
        }

        // Salida del PDF
        //$pdf->Output('D', 'clientes.pdf');
        $pdf->Output('cliente.pdf', 'I'); // Forzar la descarga del archivo PDF

    }
    function generarExcel() {
        $empleado = $this->modelo->obtenerEmpleados();
    
        // Configuración para la descarga de Excel
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="empleados.xls"');
    
        echo "ID\tNOMBRE\tAPELLIDO\tDNI\tTELEFONO\tDIRECCION\tFECHA DE CONTRATACION\n";
    
        while ($item = $empleado->fetch_object()) {
            echo "{$item->id_empleado}\t{$item->nombre}\t{$item->apellido}\t{$item->dni}\t{$item->telefono}\t{$item->direccion}\t{$item->fecha_contratacion}\n";
        }
    }
    
    

    private function eliminar($id)
    {
        if ($this->modelo->eliminarEmpleado($id)) {
            $_SESSION['mensaje'] = "Empleado eliminado exitosamente";
            $_SESSION['tipo_mensaje'] = "success";
        } else {
            $_SESSION['mensaje'] = "Error al eliminar empleado";
            $_SESSION['tipo_mensaje'] = "danger";
        }
        header("Location: ../vista/empleados.php");
        exit();
    }
}

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Crear instancia del controlador y procesar la acción
$controller = new EmpleadoController();
$controller->procesarAccion();
