<?php
require_once '../modelo/plato.php'; 
require_once '../config/conexion.php';
require_once('../public/lib/TCPDF-main/tcpdf.php');

class PlatoController
{
    private $modelo;

    public function __construct()
    {
        global $conexion;
        $this->modelo = new Plato($conexion);
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
        if (
            !empty($_POST['nombre']) && !empty($_POST['descripcion']) && !empty($_POST['precio']) &&
            !empty($_POST['categoria'])
        ) {

            // Manejar la subida de la imagen
            $imagen = $_FILES['imagen']['name'];
            $ruta = "../public/img/" . $imagen; // Ajusta la ruta según tu estructura de carpetas
            move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta);

            $resultado = $this->modelo->registrarPlato(
                $_POST['nombre'],
                $_POST['descripcion'],
                $_POST['precio'],
                $_POST['categoria'],
                $imagen
            );
            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta)) {
                // La imagen se ha subido correctamente
            } else {
                $_SESSION['mensaje'] = "Error al subir la imagen";
                $_SESSION['tipo_mensaje'] = "danger";
            }
            if ($resultado) {
                $_SESSION['mensaje'] = "Plato registrado exitosamente";
                $_SESSION['tipo_mensaje'] = "success";
            } else {
                $_SESSION['mensaje'] = "Error al registrar plato";
                $_SESSION['tipo_mensaje'] = "danger";
            }
        } else {
            $_SESSION['mensaje'] = "Todos los campos son requeridos";
            $_SESSION['tipo_mensaje'] = "warning";
        }
        header("Location: ../vista/platos.php");
        exit();
    }

    private function modificar()
    {
        if (!empty($_POST['id_plato'])) {
            $resultado = $this->modelo->modificarPlato(
                $_POST['id_plato'],
                $_POST['nombre'],
                $_POST['descripcion'],
                $_POST['precio'],
                $_POST['categoria'],
                $_POST['estado'] // Asegúrate de que este valor es el que esperas
            );

            if ($resultado) {
                $_SESSION['mensaje'] = "Plato modificado exitosamente";
                $_SESSION['tipo_mensaje'] = "success";
            } else {
                $_SESSION['mensaje'] = "Error al modificar plato";
                $_SESSION['tipo_mensaje'] = "danger";
            }
        } else {
            $_SESSION['mensaje'] = "ID de plato requerido";
            $_SESSION['tipo_mensaje'] = "warning";
        }
        header("Location: ../vista/platos.php");
        exit();
    }
    public function generarPDF()
    {
        $Plato = $this->modelo->obtenerPlatos(); // Obtener todos los registros del almacén

        // Crear instancia de TCPDF
        $pdf = new TCPDF();
        $pdf->AddPage();
        $pdf->SetFont('helvetica', 'B', 16);
        $pdf->Cell(0, 10, 'Lista de Platos', 0, 1, 'C'); // Título centrado

        // Encabezados de la tabla
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(15, 10, 'id_plato', 1, 0, 'C');
        $pdf->Cell(20, 10, 'nombre', 1, 0, 'C');
        $pdf->Cell(80, 10, 'descripcion', 1, 0, 'C');
        $pdf->Cell(30, 10, 'precio', 1, 0, 'C');
        $pdf->Cell(40, 10, 'categoría', 1, 0, 'C');
        $pdf->Cell(40, 10, 'estado', 1, 1, 'C');
        


        // Contenido de la tabla
        $pdf->SetFont('helvetica', '', 12);
        while ($item = $Plato->fetch_object()) {
            $pdf->Cell(15, 10, $item->id_plato, 1, 0, 'C');
            $pdf->Cell(20, 10, $item->nombre, 1, 0, 'C');
            $pdf->Cell(80, 10, $item->descripcion, 1, 0, 'C');
            $pdf->Cell(30, 10, $item->precio, 1, 0, 'C');
            $pdf->Cell(40, 10, $item->categoria, 1, 0, 'C');
            $pdf->Cell(40, 10, $item->estado, 1, 1, 'C');
            
        }

        // Salida del PDF
        $pdf->Output('Platos.pdf', 'I');
    }
    function generarExcel()  {
        $Plato = $this->modelo->obtenerPlatos();
    
        // Configuración para la descarga de Excel
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="Platos.xls"');
    
        echo "id_plato\tnombre\tdescripcion\tprecio\tcategoría\testado\n";
    
        while ($item = $Plato->fetch_object()) {
            echo "{$item->id_plato}\t{$item->nombre}\t{$item->descripcion}\t{$item->precio}\t{$item->categoria}\t{$item->estado}\n";
        }
    }

    private function eliminar($id_plato)
    {
        $resultado = $this->modelo->eliminarPlato($id_plato);
        if ($resultado) {
            $_SESSION['mensaje'] = "Plato eliminado exitosamente";
            $_SESSION['tipo_mensaje'] = "success";
        } else {
            $_SESSION['mensaje'] = "Error al eliminar plato";
            $_SESSION['tipo_mensaje'] = "danger";
        }
        header("Location: ../vista/platos.php");
        exit();
    }
}

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Crear instancia del controlador y procesar la acción
$controller = new PlatoController();
$controller->procesarAccion();
