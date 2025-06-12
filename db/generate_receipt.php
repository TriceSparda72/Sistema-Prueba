<?php
header("Content-Type: application/json");
require "fpdf/fpdf.php";
include "db_connect.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $invoiceNumber = $_POST["invoiceNumber"] ?? "";

    // 🔹 Obtener los datos del recibo desde la base de datos
    $sql = "SELECT * FROM recibos WHERE numero_factura = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $invoiceNumber);
    $stmt->execute();
    $result = $stmt->get_result();
    $receiptData = $result->fetch_assoc();

    if (!$receiptData) {
        echo json_encode(["status" => "error", "message" => "No se encontró el recibo"]);
        exit();
    }

    // 🔹 Crear el PDF
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont("Arial", "B", 14);
    $pdf->Cell(190, 10, "Distribuidora ROCO C.A", 0, 1, "C");
    $pdf->SetFont("Arial", "", 12);
    $pdf->Cell(190, 10, "Recibo de Venta", 0, 1, "C");
    $pdf->Ln(5);

    // 🔹 Información del recibo
    foreach ($receiptData as $key => $value) {
        $label = ucwords(str_replace("_", " ", $key));
        $pdf->Cell(50, 10, "$label:", 0, 0);
        $pdf->Cell(100, 10, $value, 0, 1);
    }

    // 🔹 Guardar el PDF
    $pdfFilename = "receipts/recibo_" . $invoiceNumber . ".pdf";
    $pdf->Output("F", $pdfFilename);

    echo json_encode(["status" => "success", "message" => "Recibo generado correctamente", "pdfUrl" => $pdfFilename]);
} else {
    echo json_encode(["status" => "error", "message" => "Método no permitido"]);
}
?>