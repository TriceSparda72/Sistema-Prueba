<?php
include "db_connect.php";

// Verificar si la solicitud es POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombreProducto = $_POST["Nombre_Producto"] ?? "";
    $stockLocal = $_POST["Stock_Local"] ?? 0;
    $stockAlmacen = $_POST["Stock_Almacén"] ?? 0;
    $precioUnitario = $_POST["Precio_Unitario"] ?? 0;

    // Validar que el nombre del producto no esté vacío
    if (empty($nombreProducto)) {
        echo json_encode(["status" => "error", "message" => "El nombre del producto es obligatorio"]);
        exit;
    }

    // Preparar consulta para insertar un nuevo producto
    $stmt = $conn->prepare("INSERT INTO Producto (Nombre_Producto, Stock_Local, Stock_Almacén, Precio_Unitario) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("siii", $nombreProducto, $stockLocal, $stockAlmacen, $precioUnitario);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Producto agregado exitosamente"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error al agregar el producto"]);
    }

    // Cerrar la conexión
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["status" => "error", "message" => "Método no permitido"]);
}
?>