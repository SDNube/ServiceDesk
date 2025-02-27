<?php
// Conexión a la base de datos
$servername = "sql111.infinityfree.com";
$db_username = "if0_38412249"; // Cambia si tienes otro usuario
$db_password = "Puntoactivo23"; // Cambia si tienes otra contraseña
$dbname = "if0_38412249_servicedesk";

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