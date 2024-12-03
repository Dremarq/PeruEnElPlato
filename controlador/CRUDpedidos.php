<?php
require_once '../modelo/pedidos.php';
require_once '../modelo/cliente.php';
require_once '../config/conexion.php';
require_once('../public/lib/TCPDF-main/tcpdf.php');

class PedidoController {
    private $modelo;

    public function __construct() {
        global $conexion;
        $this->modelo = new Pedido($conexion);
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
        if (!empty($_POST['id_usuario']) && !empty($_POST['id_empleado']) && 
            !empty($_POST['fecha_pedido']) && !empty($_POST['estado']) && 
            !empty($_POST['tipo_pedido']) && !empty($_POST['total'])) {
            
            $resultado = $this->modelo->registrarPedido(
                $_POST['id_usuario'],
                $_POST['id_empleado'],
                $_POST['fecha_pedido'],
                $_POST['estado'],
                $_POST['tipo_pedido'],
                $_POST['total']
            );

            if ($resultado) {
                $_SESSION['mensaje'] = "Pedido registrado exitosamente";
                $_SESSION['tipo_mensaje'] = "success";
            } else {
                $_SESSION['mensaje'] = "Error al registrar pedido";
                $_SESSION['tipo_mensaje'] = "danger";
            }
        } else {
            $_SESSION['mensaje'] = "Todos los campos son requeridos";
            $_SESSION['tipo_mensaje'] = "warning";
        }
        header("Location: ../vista/pedidos.php");
        exit();
    }

    private function modificar() {
        if (!empty($_POST['id_pedido'])) {
            $resultado = $this->modelo->modificarPedido(
                $_POST['id_pedido'],
                $_POST['id_usuario'],
                $_POST['id_empleado'],
                $_POST['fecha_pedido'],
                $_POST['estado'],
                $_POST['tipo_pedido'],
                $_POST['total']
            );

            if ($resultado) {
                $_SESSION['mensaje'] = "Pedido modificado exitosamente";
                $_SESSION['tipo_mensaje'] = "success";
            } else {
                $_SESSION['mensaje'] = "Error al modificar pedido";
                $_SESSION['tipo_mensaje'] = "danger";
            }
        }
        header("Location: ../vista/pedidos.php");
        exit();
    }
    public function generarPDF()
    {
        $Pedido = $this->modelo->obtenerPedidos(); // Obtener todos los registros del almacén

        // Crear instancia de TCPDF
        $pdf = new TCPDF();
        $pdf->AddPage();
        $pdf->SetFont('helvetica', 'B', 16);
        $pdf->Cell(0, 10, 'Lista de Pedidos', 0, 1, 'C'); // Título centrado

        // Encabezados de la tabla
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(15, 10, 'id_ped', 1, 0, 'C');
        $pdf->Cell(20, 10, 'empleado', 1, 0, 'C');
        $pdf->Cell(80, 10, 'id_cliente', 1, 0, 'C');
        $pdf->Cell(30, 10, 'fecha', 1, 0, 'C');
        $pdf->Cell(40, 10, 'estado', 1, 0, 'C');
        $pdf->Cell(40, 10, 'tipo de pedido', 1, 0, 'C');
        $pdf->Cell(40, 10, 'total', 1, 1, 'C');


        // Contenido de la tabla
        $pdf->SetFont('helvetica', '', 12);
        while ($item = $Pedido->fetch_object()) {
            $pdf->Cell(15, 10, $item->id_pedido, 1, 0, 'C');
            $pdf->Cell(20, 10, $item->empleado, 1, 0, 'C');
            $pdf->Cell(80, 10, $item->id_usuario, 1, 0, 'C');
            $pdf->Cell(30, 10, $item->fecha_pedido, 1, 0, 'C');
            $pdf->Cell(40, 10, $item->estado, 1, 0, 'C');
            $pdf->Cell(40, 10, $item->tipo_pedido, 1, 0, 'C');
            $pdf->Cell(40, 10, $item->total, 1,1,'C');
        }

        // Salida del PDF
        $pdf->Output('Pedidos.pdf', 'I');
    }
    function generarExcel()  {
        $Pedido = $this->modelo->obtenerPedidos();
    
        // Configuración para la descarga de Excel
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="Pedido.xls"');
    
        echo "id_pedido\templeado\tid_usuario\tfecha\testado\ttipo de pedido\ttotal\n";
    
        while ($item = $Pedido->fetch_object()) {
            echo "{$item->id_pedido}\t{$item->empleado}\t{$item->id_usuario}\t{$item->fecha_pedido}\t{$item->estado}\t{$item->tipo_pedido}\t{$item->total}\n";
        }
    }

    private function eliminar($id) {
        if ($this->modelo->eliminarPedido($id)) {
            $_SESSION['mensaje'] = "Pedido eliminado exitosamente";
            $_SESSION['tipo_mensaje'] = "success";
        } else {
            $_SESSION['mensaje'] = "Error al eliminar pedido";
            $_SESSION['tipo_mensaje'] = "danger";
        }
        header("Location: ../vista/pedidos.php");
        exit();
    }
}

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Crear instancia del controlador y procesar la acción
$controller = new PedidoController();
$controller->procesarAccion();
?>