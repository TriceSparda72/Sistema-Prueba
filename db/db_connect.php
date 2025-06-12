<?php
$servername = "localhost";
$username = "root"; // Ajusta si tienes otro usuario
$password = ""; // Ajusta si tienes contraseña
$database = "inventario_sistema"; // Confirma que este es el nombre correcto

$conn = new mysqli($servername, $username, $password, $database);

// 🔹 Activar la visualización de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
} else {
    
}
?>