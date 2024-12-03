<?php
require_once '../modelo/proveedores.php';
require_once '../config/conexion.php';
require_once('../public/lib/TCPDF-main/tcpdf.php');

class ProveedorController {
    private $modelo;

    public function __construct() {
        global $conexion;
        $this->modelo = new Proveedor($conexion);
    }

    public function procesarAccion() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['accion'])) {
                switch ($_POST['accion']) {
                    case 'registrar':
                        return $this->registrar();
                    case 'modificar':
                        return $this->modificar();
                }
            }
        }elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
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

    private function registrar() {
        if (!empty($_POST['nombre_empresa']) && !empty($_POST['ruc']) && !empty($_POST['telefono']) && 
            !empty($_POST['email']) && !empty($_POST['direccion'])) {
            
            $resultado = $this->modelo->registrarProveedor(
                $_POST['nombre_empresa'],
                $_POST['ruc'],
                $_POST['telefono'],
                $_POST['email'],
                $_POST['direccion']
            );

            if ($resultado) {
                $_SESSION['mensaje'] = "Proveedor registrado exitosamente";
                $_SESSION['tipo_mensaje'] = "success";
            } else {
                $_SESSION['mensaje'] = "Error al registrar proveedor";
                $_SESSION['tipo_mensaje'] = "danger";
            }
        } else {
            $_SESSION['mensaje'] = "Todos los campos son requeridos";
            $_SESSION['tipo_mensaje'] = "warning";
        }
        header("Location: ../vista/proveedores.php");
        exit();
    }
    private function modificar() {
        if (!empty($_POST['id_proveedor'])) {
            $resultado = $this->modelo->modificarProveedor(
                $_POST['id_proveedor'],
                $_POST['nombre_empresa'],
                $_POST['ruc'],
                $_POST['telefono'],
                $_POST['email'],
                $_POST['direccion'],
                $_POST['estado']
            );
    
            if ($resultado) {
                $_SESSION['mensaje'] = "Proveedor modificado exitosamente";
                $_SESSION['tipo_mensaje'] = "success";
            } else {
                $_SESSION['mensaje'] = "Error al modificar proveedor";
                $_SESSION['tipo_mensaje'] = "danger";
            }
        }
        header("Location: ../vista/proveedores.php");
        exit();
    }

    public function generarPDF()
    {
        $Proveedores = $this->modelo->obtenerProveedores(); // Obtener todos los registros del almacén

        // Crear instancia de TCPDF
        $pdf = new TCPDF();
        $pdf->AddPage();
        $pdf->SetFont('helvetica', 'B', 16);
        $pdf->Cell(0, 10, 'Lista de Proveedores', 0, 1, 'C'); // Título centrado

        // Encabezados de la tabla
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(15, 10, 'id', 1, 0, 'C');
        $pdf->Cell(20, 10, 'Nombre Empresa', 1, 0, 'C');
        $pdf->Cell(80, 10, 'ruc', 1, 0, 'C');
        $pdf->Cell(30, 10, 'teléfono', 1, 0, 'C');
        $pdf->Cell(40, 10, 'email', 1, 0, 'C');
        $pdf->Cell(40, 10, 'direccion', 1, 0, 'C');
        $pdf->Cell(40, 10, 'estado', 1, 1, 'C');
        


        // Contenido de la tabla
        $pdf->SetFont('helvetica', '', 12);
        while ($item = $Proveedores->fetch_object()) {
            $pdf->Cell(15, 10, $item->id_proveedor, 1, 0, 'C');
            $pdf->Cell(20, 10, $item->nombre_empresa, 1, 0, 'C');
            $pdf->Cell(80, 10, $item->ruc, 1, 0, 'C');
            $pdf->Cell(30, 10, $item->telefono, 1, 0, 'C');
            $pdf->Cell(40, 10, $item->email, 1, 0, 'C');
            $pdf->Cell(40, 10, $item->direccion, 1, 0, 'C');
            $pdf->Cell(40, 10, $item->estado, 1, 1, 'C');
        }

        // Salida del PDF
        $pdf->Output('Proveedor.pdf', 'I');
    }
    function generarExcel()  {
        $Proveedores = $this->modelo->obtenerProveedores();
    
        // Configuración para la descarga de Excel
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="Proveedor.xls"');
    
        echo "id\tNombre Empresa\truc\tteléfono\temail\tdireccion\testado\n";
    
        while ($item = $Proveedores->fetch_object()) {
            echo "{$item->id_proveedor}\t{$item->nombre_empresa}\t{$item->ruc}\t{$item->telefono}\t{$item->email}\t{$item->direccion}\t{$item->estado}\n";
        }
    }

    private function eliminar($id) {
        if ($this->modelo->eliminarProveedor($id)) {
            $_SESSION['mensaje'] = "Proveedor eliminado exitosamente";
            $_SESSION['tipo_mensaje'] = "success";
        } else {
            $_SESSION['mensaje'] = "Error al eliminar proveedor";
            $_SESSION['tipo_mensaje'] = "danger";
        }
        header("Location: ../vista/proveedores.php");
        exit();
    }
}

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Crear instancia del controlador y procesar la acción
$controller = new ProveedorController();
$controller->procesarAccion();
?>