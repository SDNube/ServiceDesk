<?php
include '../conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST["correo"];

    // Extraemos el nombre de usuario antes del '@'
    $usuario = explode('@', $correo)[0];

    // Consulta para verificar si el nombre de usuario ya está registrado
    $sql_check = "SELECT id FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql_check);
    $stmt->bind_param("s", $usuario);  // Usamos el nombre de usuario sin el '@'
    $stmt->execute();
    $result = $stmt->get_result();

    // Retorna si existe el usuario o no
    echo json_encode(["exists" => $result->num_rows > 0]);

    // Cierra la conexión
    $stmt->close();
    $conn->close();
}
?>
