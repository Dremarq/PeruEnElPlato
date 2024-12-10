<?php
require_once '../../config/conexion.php';
require_once('../../public/lib/TCPDF-main/tcpdf.php');

session_start();

// Verificar si hay un carrito en la sesión
if (!isset($_SESSION['carrito'])) {
    echo "No hay productos en el carrito.";
    exit();
}

// Datos del cliente
$nombreCliente = isset($_SESSION['nombre_cliente']) ? $_SESSION['nombre_cliente'] : 'Cliente Desconocido';
$carrito = $_SESSION['carrito'];
$total = 0;

// Calcular el total
foreach ($carrito as $plato) {
    $total += $plato['precio'] * $plato['cantidad'];
}

// Crear una nueva instancia de TCPDF con un tamaño de página personalizado
$pdf = new TCPDF('P', 'mm', [57, 200], true, 'UTF-8', false);
$pdf->SetMargins(2, 2, 2); // Márgenes reducidos
$pdf->SetAutoPageBreak(true, 10);
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 8);

// Encabezado de la boleta
$pdf->Cell(0, 0, 'Peru En El Plato', 0, 1, 'C');
$pdf->Ln(2);
$pdf->Cell(0, 0, 'RUC: 20100070970', 0, 1, 'C');
$pdf->Cell(0, 0, 'Lima - San Borja', 0, 1, 'C');
$pdf->Cell(0, 0, 'BOLETA DE VENTA ELECTRONICA', 0, 1, 'C');
$pdf->Ln(3);

// Número de boleta (simulado)
$pdf->Cell(0, 0, 'BA32-06281893', 0, 1, 'C');
$pdf->Ln(3);

// Detalle del cajero
$pdf->Cell(0, 0, 'CAJERO: 129', 0, 1, 'L');
$pdf->Ln(2);

// Detalle de los productos
foreach ($carrito as $plato) {
    $subtotal = $plato['precio'] * $plato['cantidad'];
    $pdf->Cell(0, 0, htmlspecialchars($plato['nombre']), 0, 1, 'L');
    $pdf->Cell(35, 0, htmlspecialchars($plato['cantidad'] . ' x S/' . number_format($plato['precio'], 2)), 0, 0, 'L');
    $pdf->Cell(20, 0, 'S/ ' . number_format($subtotal, 2), 0, 1, 'R');
    $pdf->Ln(1);
}

// Resumen de la venta
$pdf->Ln(2);
$pdf->Cell(35, 0, 'TOTAL DESCUENTO:', 0, 0, 'L');
$pdf->Cell(20, 0, 'S/ 0.00', 0, 1, 'R');
$pdf->Cell(35, 0, 'SUBTOTAL:', 0, 0, 'L');
$pdf->Cell(20, 0, 'S/ ' . number_format($total, 2), 0, 1, 'R');


$pdf->Ln(1);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->Cell(35, 0, 'TOTAL A PAGAR:', 0, 0, 'L');
$pdf->Cell(20, 0, 'S/ ' . number_format($total, 2), 0, 1, 'R');
$pdf->SetFont('helvetica', '', 8);

// Mensaje de agradecimiento
$pdf->Ln(3);
$pdf->Cell(0, 0, 'CIENTO TRECE Y 18/100 SOLES', 0, 1, 'L');
$pdf->Cell(0, 0, 'TOH! VISA', 0, 1, 'L');
$pdf->Ln(3);
$pdf->Cell(0, 0, 'Gracias por su compra', 0, 1, 'C');

// Salvar el PDF
$pdf->Output('Boleta.pdf', 'I');
?>
