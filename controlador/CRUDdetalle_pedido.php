<?php
require_once '../modelo/detalle_pedido.php';
require_once '../config/conexion.php';
require_once('../public/lib/TCPDF-main/tcpdf.php');

class DetallePedidoController {
    private $modelo;

    public function __construct() {
        global $conexion;
        $this->modelo = new DetallePedido($conexion);
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
                    case 'generar_pdf':
                        return $this->generarPDFAlmacen(); // Llamar a la función para generar PDF
                        case 'generar_excel':
                            return $this->generarExcel();
                }
            }
        }
    }


    private function registrar() {
        if (!empty($_POST['id_pedido']) && !empty($_POST['id_plato']) && // Cambiado de id_producto a id_plato
            !empty($_POST['cantidad']) && !empty($_POST['precio_unitario'])) {
            
            $resultado = $this->modelo->registrarDetallePedido(
                $_POST['id_pedido'],
                $_POST['id_plato'], // Cambiado de id_producto a id_plato
                $_POST['cantidad'],
                $_POST['precio_unitario']
            );

            if ($resultado) {
                $_SESSION['mensaje'] = "Detalle de pedido registrado exitosamente";
                $_SESSION['tipo_mensaje'] = "success";
            } else {
                $_SESSION['mensaje'] = "Error al registrar detalle de pedido";
                $_SESSION['tipo_mensaje'] = "danger";
            }
        } else {
            $_SESSION['mensaje'] = "Todos los campos son requeridos";
            $_SESSION['tipo_mensaje'] = "warning";
        }
        header("Location: ../vista/detalle_pedido.php");
        exit();
    }

    private function modificar() {
        if (!empty($_POST['id_detalle'])) {
            $resultado = $this->modelo->modificarDetallePedido(
                $_POST['id_detalle'],
                $_POST['id_plato'], // Cambiado de id_producto a id_plato
                $_POST['cantidad'],
                $_POST['precio_unitario']
            );

            if ($resultado) {
                $_SESSION['mensaje'] = "Detalle de pedido modificado exitosamente";
                $_SESSION['tipo_mensaje'] = "success";
            } else {
                $_SESSION['mensaje'] = "Error al modificar detalle de pedido";
                $_SESSION['tipo_mensaje'] = "danger";
            }
        }
        header("Location: ../vista/detalle_pedido.php");
        exit();
    }
    public function generarPDFAlmacen()
    {
        $almacen = $this->modelo->obtenerDetallesPedido(); // Obtener todos los registros del almacén

        // Crear instancia de TCPDF
        $pdf = new TCPDF();
        $pdf->AddPage();
        $pdf->SetFont('helvetica', 'B', 16);
        $pdf->Cell(0, 10, 'Detalle de pedido', 0, 1, 'C'); // Título centrado

        // Encabezados de la tabla
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(15, 10, 'id_det', 1, 0, 'C');
        $pdf->Cell(20, 10, 'plato', 1, 0, 'C');
        $pdf->Cell(80, 10, 'cantidad', 1, 0, 'C');
        $pdf->Cell(30, 10, 'precio', 1, 0, 'C');
        $pdf->Cell(40, 10, 'subtotal', 1, 1, 'C');


        // Contenido de la tabla
        $pdf->SetFont('helvetica', '', 12);
        while ($item = $almacen->fetch_object()) {
            $pdf->Cell(15, 10, $item->id_pedido, 1, 0, 'C');
            $pdf->Cell(20, 10, $item->plato, 1, 0, 'C');
            $pdf->Cell(80, 10, $item->cantidad, 1, 0, 'C');
            $pdf->Cell(30, 10, $item->precio_unitario, 1, 0, 'C');
            $pdf->Cell(40, 10, $item->subtotal, 1, 1, 'C');
        }

        // Salida del PDF
        $pdf->Output('Detalle_Pedido.pdf', 'I');
    }
    function generarExcel() {
        $DetallePedido = $this->modelo->obtenerDetallesPedido();
    
        // Configuración para la descarga de Excel
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="DETALLE_PEDIDO.xls"');
    
        echo "id_detalle\tplato\tcantidad\tprecio_unitario\tsubtotal\n";
    
        while ($item = $DetallePedido->fetch_object()) {
            echo "{$item->id_pedido}\t{$item->plato}\t{$item->cantidad}\t{$item->precio_unitario}\t{$item->subtotal}\n";
        }
    }

    private function eliminar($id) {
        if ($this->modelo->eliminarDetallePedido($id)) {
            $_SESSION['mensaje'] = "Detalle de pedido eliminado exitosamente";
            $_SESSION['tipo_mensaje'] = "success";
        } else {
            $_SESSION['mensaje'] = "Error al eliminar detalle de pedido";
            $_SESSION['tipo_mensaje'] = "danger";
        }
        header("Location: ../vista/detalle_pedido.php");
        exit();
    }
}

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Crear instancia del controlador y procesar la acción
$controller = new DetallePedidoController();
$controller->procesarAccion();
?>