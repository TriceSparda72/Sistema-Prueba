<?php
header("Content-Type: application/json");
include "db_connect.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Content-Type: application/json"); // 👈 Aseguramos que solo devuelve JSON

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $productName = $_POST["productName"] ?? "";
    $stockLocal = $_POST["stockLocal"] ?? 0;
    $stockAlmacen = $_POST["stockAlmacen"] ?? 0;
    $unitPrice = $_POST["unitPrice"] ?? 0.00;

    if (empty($productName) || $stockLocal < 0 || $stockAlmacen < 0 || $unitPrice < 0) {
        echo json_encode(["status" => "error", "message" => "Datos inválidos"]);
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO producto (Nombre_Producto, Stock_Local, Stock_Almacen, Precio_Unitario) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sddd", $productName, $stockLocal, $stockAlmacen, $unitPrice);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Producto registrado correctamente"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error en la BD: " . $conn->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["status" => "error", "message" => "Método no permitido"]);
}
?>