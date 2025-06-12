<?php
header("Content-Type: application/json");
include "db_connect.php";

// 🚀 Aseguramos que no haya ninguna salida antes del JSON
ob_clean();
flush();

$sql = "SELECT ID_Producto, Nombre_Producto, Stock_Local, Stock_Almacen, Precio_Unitario FROM producto";
$result = $conn->query($sql);

$productos = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $productos[] = $row;
    }
}

echo json_encode($productos);
$conn->close();
?>