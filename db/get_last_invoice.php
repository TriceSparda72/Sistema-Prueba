<?php
header("Content-Type: application/json");
include "db_connect.php";
session_start();

// 🔹 Obtener el último número de factura
$sqlFactura = "SELECT MAX(numero_factura) AS last_invoice FROM recibos";
$resultFactura = $conn->query($sqlFactura);
$lastInvoice = $resultFactura->fetch_assoc()["last_invoice"] ?? 0;
$newInvoice = $lastInvoice + 1;

// 🔹 Obtener el último número de control
$sqlControl = "SELECT MAX(numero_control) AS last_control FROM recibos";
$resultControl = $conn->query($sqlControl);
$lastControl = $resultControl->fetch_assoc()["last_control"] ?? 0;
$newControl = $lastControl + 1;

// 🔹 Formatear números con ceros a la izquierda
$response = [
    "invoice" => str_pad($newInvoice, 4, "0", STR_PAD_LEFT),  // 0001, 0002...
    "control" => str_pad($newControl, 6, "0", STR_PAD_LEFT)   // 000001, 000002...
];

echo json_encode($response);
$conn->close();
?>