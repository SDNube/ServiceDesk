<?php
session_start();
include('../conexion.php'); // Asegúrate de incluir tu archivo de conexión

// Obtener los datos enviados por POST
$idTicket = isset($_POST['idTicket']) ? $_POST['idTicket'] : null;
$mensaje = isset($_POST['mensaje']) ? $_POST['mensaje'] : '';
$accion = '8'; // Estático
$idUser = $_SESSION['id']; // ID de usuario de la sesión

// Validar los datos recibidos
error_log("Datos recibidos en el servidor: ");
error_log("idTicket: " . $idTicket);
error_log("mensaje: " . $mensaje);
error_log("accion: " . $accion);
error_log("idUser: " . $idUser);

if ($idTicket && $mensaje && $accion && $idUser) {
    // Insertar el comentario en la base de datos
    $fecha = date('Y-m-d H:i:s');  // Fecha actual
    $query = "INSERT INTO historial (fecha, id_ticket, mensaje, accion, id_user) 
              VALUES ('$fecha', '$idTicket', '$mensaje', '$accion', '$idUser')";

    if (mysqli_query($conn, $query)) {  // Usar $conn en lugar de $conexion
        // Si el insert fue exitoso, devolver una respuesta positiva
        echo json_encode(['success' => true]);
    } else {
        // Si hubo un error al insertar, devolver una respuesta de error
        echo json_encode(['success' => false, 'message' => 'Error al insertar comentario']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
}

mysqli_close($conn);  // Usar $conn en lugar de $conexion
?>
