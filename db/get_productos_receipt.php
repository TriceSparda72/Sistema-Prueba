<?php
header("Content-Type: application/json");
include "db_connect.php"; 

$sql = "SELECT DISTINCT p.ID_Producto, p.Nombre_Producto, p.Precio_Unitario 
        FROM producto p
        INNER JOIN detalle_venta dv ON p.ID_Producto = dv.id_producto";

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