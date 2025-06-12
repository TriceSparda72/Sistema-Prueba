<?php
require('fpdf/fpdf.php');
include "db_connect.php"; 

// 🔹 Obtener los productos de la última venta
$sql = "SELECT v.ID_Venta, v.Fecha, v.Total, dv.id_producto, p.Nombre_Producto, dv.cantidad, dv.precio_unitario, dv.subtotal 
        FROM venta v
        INNER JOIN detalle_venta dv ON v.ID_Venta = dv.id_venta
        INNER JOIN producto p ON dv.id_producto = p.ID_Producto
        WHERE v.ID_Venta = (SELECT MAX(ID_Venta) FROM venta)";

$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("❌ No se encontró ninguna venta.");
}

// 🔹 Crear el PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(190, 10, 'Distribuidora ROCO C.A - Recibo de Venta', 0, 1, 'C');
$pdf->Ln(10);

$pdf->SetFont('Arial', '', 12);
$venta = $result->fetch_assoc();
$pdf->Cell(50, 10, "Fecha: " . $venta['Fecha'], 0, 1);
$pdf->Cell(50, 10, "ID Venta: " . $venta['ID_Venta'], 0, 1);
$pdf->Ln(5);

// 🔹 Tabla de productos
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(80, 10, "Producto", 1);
$pdf->Cell(30, 10, "Cantidad", 1);
$pdf->Cell(40, 10, "Precio Unitario", 1);
$pdf->Cell(40, 10, "Subtotal", 1);
$pdf->Ln();

$pdf->SetFont('Arial', '', 12);
$total = 0;

do {
    $pdf->Cell(80, 10, $venta['Nombre_Producto'], 1);
    $pdf->Cell(30, 10, $venta['cantidad'], 1);
    $pdf->Cell(40, 10, "$" . number_format($venta['precio_unitario'], 2), 1);
    $pdf->Cell(40, 10, "$" . number_format($venta['subtotal'], 2), 1);
    $pdf->Ln();
    $total += $venta['subtotal'];
} while ($venta = $result->fetch_assoc());

// 🔹 Calcular IVA y total a pagar
$iva = $total * 0.16;
$total_pagar = $total + $iva;

$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(80, 10, "Total:", 0);
$pdf->Cell(40, 10, "$" . number_format($total, 2), 0);
$pdf->Ln();
$pdf->Cell(80, 10, "IVA (16%):", 0);
$pdf->Cell(40, 10, "$" . number_format($iva, 2), 0);
$pdf->Ln();
$pdf->Cell(80, 10, "Total a pagar:", 0);
$pdf->Cell(40, 10, "$" . number_format($total_pagar, 2), 0);
$pdf->Ln(10);

// 🔹 Forzar la descarga del PDF
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="Recibo_Venta.pdf"');
$pdf->Output('D', 'Recibo_Venta.pdf');
?>