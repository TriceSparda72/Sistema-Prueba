<?php
include "db_connect.php";

// Verificar si la solicitud es POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cliente = $_POST["Cliente"] ?? "";
    $producto = $_POST["Producto"] ?? "";
    $cantidad = $_POST["Cantidad"] ?? 0;
    $precioUnitario = $_POST["Precio_Unitario"] ?? 0;
    $fecha = date("Y-m-d"); // Capturar fecha automática

    // Validar que los datos sean correctos
    if (empty($cliente) || empty($producto) || $cantidad <= 0 || $precioUnitario <= 0) {
        echo json_encode(["status" => "error", "message" => "Datos inválidos"]);
        exit;
    }

    // Preparar la consulta SQL para registrar la venta
    $stmt = $conn->prepare("INSERT INTO Ventas (Fecha, Cliente, Producto, Cantidad, Precio_Unitario) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssii", $fecha, $cliente, $producto, $cantidad, $precioUnitario);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Venta registrada exitosamente"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error al registrar la venta"]);
    }

    // Cerrar conexión
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["status" => "error", "message" => "Método no permitido"]);
}
?>