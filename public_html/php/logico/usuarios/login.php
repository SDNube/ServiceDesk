<?php
session_start(); // Inicia la sesión
ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../conexion.php';
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
header('Content-Type: application/json');

$response = array(); // Array para la respuesta

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Consulta para verificar el usuario y obtener la contraseña y el id_rol
    $sql = "SELECT id, password, id_rol, username FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_id = $row['id']; // Obtener el ID del usuario

        // Comparar directamente la contraseña en texto plano (se recomienda usar hashing en producción)
        if ($pass === $row['password']) {
            // Almacenar datos en la sesión
            $_SESSION['id'] = $row['id'];
            $_SESSION['id_rol'] = $row['id_rol'];
            $_SESSION['username'] = $row['username'];

            // Nueva consulta para obtener el nombre, paterno y materno desde datos_usuarios
            $sql2 = "SELECT nombre, paterno, materno FROM datos_usuarios WHERE id_user = ?";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->bind_param("i", $user_id);
            $stmt2->execute();
            $result2 = $stmt2->get_result();

            if ($result2->num_rows > 0) {
                $row2 = $result2->fetch_assoc();
                $nombreCompleto = $row2['nombre'] . " " . $row2['paterno'] . " " . $row2['materno'];
                $_SESSION['nombreCompleto'] = $nombreCompleto; // Guardar en sesión
            } else {
                $_SESSION['nombreCompleto'] = "Nombre no encontrado";
            }

            // Respuesta exitosa
            $response['status'] = 'success';
            $response['message'] = 'Inicio de sesión exitoso';
        } else {
            // Respuesta de error por contraseña incorrecta
            $response['status'] = 'error';
            $response['message'] = 'Contraseña incorrecta.';
        }
    } else {
        // Respuesta de error por usuario no encontrado
        $response['status'] = 'error';
        $response['message'] = 'Usuario no encontrado.';
    }
}
ini_set('display_errors', 1);
error_reporting(E_ALL);
// Enviar la respuesta en formato JSON
echo json_encode($response);

// Cerrar la conexión
$conn->close();
?>
