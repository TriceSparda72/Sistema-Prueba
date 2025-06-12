<?php
header("Content-Type: application/json");
include "db_connect.php"; 

// 🔹 Recibir datos del formulario
$razonSocial = $_POST['razonSocial'];
$clientName = $_POST['clientName'];
$telefono = $_POST['telefono'];
$domicilioFiscal = $_POST['domicilioFiscal'];
$id_producto = $_POST['productDescription'];
$cantidad = $_POST['quantity'];
$precio_unitario = $_POST['unitPrice'];
$total = $cantidad * $precio_unitario;
$iva = $total * 0.16;
$total_pagar = $total + $iva;

// 🔹 Insertar la venta en la tabla `venta`
$sqlVenta = "INSERT INTO venta (Fecha, Tipo, Cantidad, Total, ID_Cliente) 
             VALUES (NOW(), 'Contado', ?, ?, 1)";
$stmtVenta = $conn->prepare($sqlVenta);
$stmtVenta->bind_param("ii", $cantidad, $total_pagar);
$stmtVenta->execute();
$id_venta = $stmtVenta->insert_id; // 🔹 Obtener el ID de la venta recién creada

// 🔹 Insertar el producto en `detalle_venta`
$sqlDetalle = "INSERT INTO detalle_venta (id_venta, id_producto, cantidad, precio_unitario, subtotal) 
               VALUES (?, ?, ?, ?, ?)";
$stmtDetalle = $conn->prepare($sqlDetalle);
$stmtDetalle->bind_param("iiidd", $id_venta, $id_producto, $cantidad, $precio_unitario, $total);
$stmtDetalle->execute();

echo json_encode(["success" => true, "message" => "Venta registrada correctamente"]);
$conn->close();
?>