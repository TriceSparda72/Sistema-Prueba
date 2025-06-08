<?php
$server = "localhost";
$user = "root";
$password = "";
$database = "inventario_sistema";

// Crear conexión
$conn = new mysqli($server, $user, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Configurar el conjunto de caracteres para evitar errores con acentos y caracteres especiales
$conn->set_charset("utf8mb4");

?>