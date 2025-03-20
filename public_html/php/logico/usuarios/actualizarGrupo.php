<?php
// Incluir la conexión a la base de datos
include '../../logico/conexion.php';
session_start(); // Iniciar sesión si no está iniciada

// Verificar si hay un ID de grupo en la sesión
if (!isset($_SESSION['id'])) {
    echo json_encode(["status" => "error", "message" => "No se ha establecido el grupo"]);
    exit;
}

$id_grupo = intval($_SESSION['id']); // Obtener el ID del grupo desde la sesión

// Verificar si la solicitud es POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos JSON enviados desde JavaScript
    $datos = json_decode(file_get_contents("php://input"), true);

    // Verificar si los datos son válidos
    if (!is_array($datos) || empty($datos)) {
        echo json_encode(["status" => "error", "message" => "No se recibieron datos válidos"]);
        exit;
    }

    // Eliminar todos los registros de la tabla donde id_grupo = $_SESSION['id']
    $sqlDelete = "DELETE FROM grupo WHERE id_grupo = ?";
    $stmtDelete = $conn->prepare($sqlDelete);
    $stmtDelete->bind_param("i", $id_grupo);
    $stmtDelete->execute();
    $stmtDelete->close();

    // Insertar los nuevos registros
    $sqlInsert = "INSERT INTO grupo (id_user, id_grupo) VALUES (?, ?)";
    $stmtInsert = $conn->prepare($sqlInsert);

    foreach ($datos as $usuario) {
        $id_user = intval($usuario['id_user']); // Asegurar que sea un número entero
        $stmtInsert->bind_param("ii", $id_user, $id_grupo);
        $stmtInsert->execute();
    }

    $stmtInsert->close();
    $conn->close();

    // Responder con un JSON de éxito
    echo json_encode(["status" => "success", "message" => "Usuarios actualizados correctamente"]);
} else {
    // Responder con error si no es una solicitud POST
    echo json_encode(["status" => "error", "message" => "Método no permitido"]);
}
?>
