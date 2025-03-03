<?php
// Conexión a la base de datos
$modo_local = true; // Cambia a false cuando subas a InfinityFree

if ($modo_local) {
    // Configuración para XAMPP (local)
    $servername = "localhost";
    $username = "root"; // XAMPP usa root por defecto
    $password = ""; // En XAMPP, sin contraseña por defecto
    $database = "servicedesk"; // Nombre de tu BD en local
} else {
    // Configuración para InfinityFree
    $servername = "sql111.infinityfree.com";
    $username = "if0_38412249"; // Usuario de InfinityFree
    $password = "tu_contraseña"; // Contraseña de InfinityFree
    $database = "if0_38412249_service"; // Nombre de la BD en InfinityFree
}

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>