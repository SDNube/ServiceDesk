<?php
// Conexión a la base de datos
$modo_local = false ; // Cambia a false cuando subas a InfinityFree

if ($modo_local) {
    // Configuración para XAMPP (local)
    $servername = "localhost";
    $username = "root"; // XAMPP usa root por defecto
    $password = ""; // En XAMPP, sin contraseña por defecto
    $database = "servicedesk"; // Nombre de tu BD en local
} else {
    // Configuración para InfinityFree
    $servername = "localhost";
    $username = "u419414544_intranet"; // Usuario de InfinityFree
    $password = "Puntoactivo.23"; // Contraseña de InfinityFree
    $database = "u419414544_intranet"; // Nombre de la BD en InfinityFree
}

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>