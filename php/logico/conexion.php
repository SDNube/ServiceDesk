<?php
// Conexión a la base de datos
$servername = "localhost";
$db_username = "root"; // Cambia si tienes otro usuario
$db_password = ""; // Cambia si tienes otra contraseña
$dbname = "servicedesk";

// Crear conexión
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta para obtener los datos de la tabla datos_usuarios
$sql = "SELECT * FROM datos_usuarios";
$result = $conn->query($sql);

?>