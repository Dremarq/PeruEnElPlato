<?php
require_once '../modelo/reservas.php';
require_once '../config/conexion.php';
require_once('../public/lib/TCPDF-main/tcpdf.php');

class ReservaController {
    private $modelo;

    public function __construct() {
        global $conexion;
        $this->modelo = new Reserva($conexion);
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

    private function registrar() {
        if (!empty($_POST['id_usuario']) && !empty($_POST['numero_mesa']) && 
            !empty($_POST['fecha_reserva']) && !empty($_POST['hora_reserva']) && 
            !empty($_POST['cantidad_personas']) && !empty($_POST['estado'])) {
            
            $resultado = $this->modelo->registrarReserva(
                $_POST['id_usuario'],
                $_POST['numero_mesa'],
                $_POST['fecha_reserva'],
                $_POST['hora_reserva'],
                $_POST['cantidad_personas'],
                $_POST['estado']
            );

            if ($resultado) {
                $_SESSION['mensaje'] = "Reserva registrada exitosamente";
                $_SESSION['tipo_mensaje'] = "success";
            } else {
                $_SESSION['mensaje'] = "Error al registrar reserva";
                $_SESSION['tipo_mensaje'] = "danger";
            }
        } else {
            $_SESSION['mensaje'] = "Todos los campos son requeridos";
            $_SESSION['tipo_mensaje'] = "warning";
        }
        header("Location: ../vista/reservas.php");
        exit();
    }

    private function modificar() {
        if (!empty($_POST['id_reserva'])) {
            $resultado = $this->modelo->modificarReserva(
                $_POST['id_reserva'],
                $_POST['id_usuario'],
                $_POST['numero_mesa'],
                $_POST['fecha_reserva'],
                $_POST['hora_reserva'],
                $_POST['cantidad_personas'],
                $_POST['estado']
            );

            if ($resultado) {
                $_SESSION['mensaje'] = "Reserva modificada exitosamente";
                $_SESSION['tipo_mensaje'] = "success";
            } else {
                $_SESSION['mensaje'] = "Error al modificar reserva";
                $_SESSION['tipo_mensaje'] = "danger";
            }
        }
        header("Location: ../vista/reservas.php");
        exit();
    }

    public function generarPDF()
    {
        $reservas = $this->modelo->obtenerReservas(); // Obtener todos los registros del almacén

        // Crear instancia de TCPDF
        $pdf = new TCPDF();
        $pdf->AddPage();
        $pdf->SetFont('helvetica', 'B', 16);
        $pdf->Cell(0, 10, 'Lista de Reservas', 0, 1, 'C'); // Título centrado

        // Encabezados de la tabla
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(15, 10, 'id', 1, 0, 'C');
        $pdf->Cell(20, 10, 'N° mesa', 1, 0, 'C');
        $pdf->Cell(80, 10, 'fecha', 1, 0, 'C');
        $pdf->Cell(30, 10, 'hora', 1, 0, 'C');
        $pdf->Cell(40, 10, 'N° personas', 1, 0, 'C');
        $pdf->Cell(40, 10, 'estado', 1, 1, 'C');
        


        // Contenido de la tabla
        $pdf->SetFont('helvetica', '', 12);
        while ($item = $reservas->fetch_object()) {
            $pdf->Cell(15, 10, $item->id_usuario, 1, 0, 'C');
            $pdf->Cell(20, 10, $item->numero_mesa, 1, 0, 'C');
            $pdf->Cell(80, 10, $item->fecha_reserva, 1, 0, 'C');
            $pdf->Cell(30, 10, $item->hora_reserva, 1, 0, 'C');
            $pdf->Cell(40, 10, $item->cantidad_personas, 1, 0, 'C');
            $pdf->Cell(40, 10, $item->estado, 1, 1, 'C');
        }

        // Salida del PDF
        $pdf->Output('Reservas.pdf', 'I');
    }
    function generarExcel()  {
        $reservas = $this->modelo->obtenerReservas();
    
        // Configuración para la descarga de Excel
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="Reservas.xls"');
    
        echo "id\tN° mesa\tfecha\thora\tN° personas\testado\n";
    
        while ($item = $reservas->fetch_object()) {
            echo "{$item->id_usuarior}\t{$item->numero_mesa}\t{$item->fecha_reserva}\t{$item->hora_reserva}\t{$item->cantidad_personas}\t{$item->estado}\n";
        }
    }
    private function eliminar($id) {
        if ($this->modelo->eliminarReserva($id)) {
            $_SESSION['mensaje'] = "Reserva eliminada exitosamente";
            $_SESSION['tipo_mensaje'] = "success";
        } else {
            $_SESSION['mensaje'] = "Error al eliminar reserva";
            $_SESSION['tipo_mensaje'] = "danger";
        }
        header("Location: ../vista/reservas.php");
        exit();
    }
}

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Crear instancia del controlador y procesar la acción
$controller = new ReservaController();
$controller->procesarAccion();
?>