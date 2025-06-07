<?php
include "db_connect.php";

// Consultar productos
$sql = "SELECT id, Nombre_Producto, Stock_Local, Stock_Almacén, Precio_Unitario FROM Producto";
$result = $conn->query($sql);

$productos = [];

// Organizar los datos en formato JSON
while ($row = $result->fetch_assoc()) {
    $productos[] = $row;
}

// Devolver los datos en formato JSON
header("Content-Type: application/json");
echo json_encode($productos);

$conn->close();
?>