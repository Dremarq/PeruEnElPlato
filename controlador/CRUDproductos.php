<?php
require_once '../modelo/producto.php';
require_once '../config/conexion.php';
require_once('../public/lib/TCPDF-main/tcpdf.php');

class ProductoController
{
    private $modelo;

    public function __construct()
    {
        global $conexion;
        $this->modelo = new Producto($conexion);
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
            !empty($_POST['nombre']) && !empty($_POST['descripcion']) && !empty($_POST['costo']) &&
            !empty($_POST['id_proveedor'])
        ) {

            $resultado = $this->modelo->registrarProducto(
                $_POST['nombre'],
                $_POST['descripcion'],
                $_POST['costo'],
                $_POST['id_proveedor'] // Asegúrate de que esto sea el ID del proveedor
            );

            if ($resultado) {
                $_SESSION['mensaje'] = "Producto registrado exitosamente";
                $_SESSION['tipo_mensaje'] = "success";
            } else {
                $_SESSION['mensaje'] = "Error al registrar producto";
                $_SESSION['tipo_mensaje'] = "danger";
            }
        } else {
            $_SESSION['mensaje'] = "Todos los campos son requeridos";
            $_SESSION['tipo_mensaje'] = "warning";
        }
        header("Location: ../vista/productos.php");
        exit();
    }
    public function generarPDF()
    {
        $productos = $this->modelo->obtenerProductos(); // Obtener todos los productos
    
        // Crear instancia de TCPDF
        $pdf = new TCPDF();
    
        // Establecer márgenes
        $pdf->SetMargins(10, 30, 10); // márgenes de 10 en los laterales y 30 en la parte superior
    
        // Añadir página
        $pdf->AddPage();
    
        // Obtener el tamaño de la página (en mm)
        $paginaAncho = $pdf->getPageWidth();
        $paginaAlto = $pdf->getPageHeight();
    
        // Tamaño de la imagen en la izquierda, ajustado a 20% del ancho de la página
        $anchoImagen = $paginaAncho * 0.2;  // 20% del ancho de la página
        $altoImagen = 0;  // Deja la altura automática para mantener la proporción
    
        // Colocar la imagen en la esquina superior izquierda
        // Ajustar a las dimensiones necesarias
        $pdf->Image('../public/img/fondo.jpg', 10, 15, $anchoImagen, $altoImagen, 'JPG');  // Imagen ajustada a 20% del ancho de la página
    
        // Marca de agua con el nombre de la empresa (solo la marca de agua será rotada)
        $pdf->SetFont('helvetica', 'I', 50);
        $pdf->SetTextColor(200, 200, 200);  // Color gris claro
        $pdf->Text(20, 150, 'PERU EN EL PLATO');
    
        // Información de la empresa (Nombre, RUC, Dirección, Teléfono)
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->SetY(15);  // Posicionar debajo del logo
        $pdf->Cell(0, 10, 'PERU EN EL PLATO', 0, 1, 'C');  // Nombre de la empresa
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(0, 10, 'RUC: 12345678901', 0, 1, 'C');  // RUC de la empresa
        $pdf->Cell(0, 10, 'Dirección: Av. Siempre Viva 123', 0, 1, 'C');  // Dirección de la empresa
        $pdf->Cell(0, 10, 'Teléfono: (01) 234-5678', 0, 1, 'C');  // Teléfono de la empresa
    
        // Título del reporte
        $pdf->SetFont('helvetica', 'B', 18);  // Mayor tamaño de fuente para el título
        $pdf->SetTextColor(255, 0, 0);  // Rojo (RGB: 255, 0, 0)
        $pdf->Cell(0, 10, 'Lista de Productos', 0, 1, 'C');
    
        // Agregar borde a la página (si deseas un marco alrededor de toda la página)
        $pdf->SetLineWidth(0.5);
        $pdf->Rect(5, 5, 200, 287);  // Coordenadas (X, Y, ancho, alto)
    
        // Encabezados de la tabla - Rojo fuerte para el fondo
        $pdf->SetFillColor(255, 0, 0); // Rojo (RGB: 255, 0, 0)
        $pdf->SetTextColor(255, 255, 255); // Texto en blanco
        $pdf->SetFont('helvetica', 'B', 12);
    
        // Definir el ancho de las columnas
        $pdf->Cell(10, 10, 'ID', 1, 0, 'C', 1);
        $pdf->Cell(80, 10, 'Nombre', 1, 0, 'C', 1);
        $pdf->Cell(30, 10, 'Costo', 1, 0, 'C', 1);
        $pdf->Cell(40, 10, 'Proveedor', 1, 0, 'C', 1);
        $pdf->Cell(30, 10, 'Estado', 1, 1, 'C', 1);
    
        // Contenido de la tabla - Gris y rojo alternado para las filas
        $pdf->SetTextColor(0, 0, 0); // Texto en negro
        $pdf->SetFont('helvetica', '', 12);
    
        $fill = true; // Variable para alternar el color de fondo de las filas
        while ($producto = $productos->fetch_object()) {
            // Filas con colores gris y rojo alternados
            if ($fill) {
                $pdf->SetFillColor(245, 245, 245); // Gris suave para una fila (RGB: 245, 245, 245)
            } else {
                $pdf->SetFillColor(255, 204, 204); // Rojo suave para la siguiente fila (RGB: 255, 204, 204)
            }
    
            $pdf->Cell(10, 10, $producto->id_producto, 1, 0, 'C', $fill);
            $pdf->Cell(80, 10, $producto->nombre, 1, 0, 'C', $fill);
            $pdf->Cell(30, 10, number_format($producto->costo, 2), 1, 0, 'C', $fill);
            $pdf->Cell(40, 10, $producto->id_proveedor, 1, 0, 'C', $fill);
            $pdf->Cell(30, 10, $producto->estado ? 'Activo' : 'Inactivo', 1, 1, 'C', $fill);
    
            $fill = !$fill; // Alternar color
        }
    
        // Pie de página (sin cambios)
        $pdf->SetY(-20);  // Mover el pie de página hacia abajo
        $pdf->SetFont('helvetica', 'I', 8);
        $pdf->SetTextColor(150, 150, 150);  // Gris suave
        $pdf->Cell(0, 10, 'Reporte generado el ' . date('d/m/Y') . ' - Página ' . $pdf->PageNo(), 0, 0, 'C');
    
        // Salida del PDF
        $pdf->Output('PRODUCTOS.pdf', 'I');
    }
    function generarExcel()  {
        $Pedido = $this->modelo->obtenerProductos();
    
        // Configuración para la descarga de Excel
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="Productos.xls"');
    
        echo "id_producto\tnombre\tcosto\tid_proveedor\testado\n";
    
        while ($item = $Pedido->fetch_object()) {
            echo "{$item->id_producto}\t{$item->nombre}\t{$item->costo}\t{$item->id_proveedor}\t{$item->estado}\n";
        }
    }


    private function modificar()
    {
        if (!empty($_POST['id_producto'])) {
            $resultado = $this->modelo->modificarProducto(
                $_POST['id_producto'],
                $_POST['nombre'],
                $_POST['descripcion'],
                $_POST['costo'],
                $_POST['estado'],
                $_POST['id_proveedor']
            );

            if ($resultado) {
                $_SESSION['mensaje'] = "Producto modificado exitosamente";
                $_SESSION['tipo_mensaje'] = "success";
            } else {
                $_SESSION['mensaje'] = "Error al modificar producto";
                $_SESSION['tipo_mensaje'] = "danger";
            }
        } else {
            $_SESSION['mensaje'] = "ID de producto requerido";
            $_SESSION['tipo_mensaje'] = "warning";
        }
        header("Location: ../vista/productos.php");
        exit();
    }

    private function eliminar($id_producto)
    {
        if ($this->modelo->eliminarProducto($id_producto)) {
            $_SESSION['mensaje'] = "Producto eliminado exitosamente";
            $_SESSION['tipo_mensaje'] = "success";
        } else {
            $_SESSION['mensaje'] = "Error al eliminar producto";
            $_SESSION['tipo_mensaje'] = "danger";
        }
        header("Location: ../vista/productos.php");
        exit();
    }
}

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Crear instancia del controlador y procesar la acción
$controller = new ProductoController();
$controller->procesarAccion();
