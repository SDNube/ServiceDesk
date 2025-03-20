<?php
session_start();
include('../conexion.php'); // Asegúrate de incluir tu archivo de conexión

// Obtener los datos enviados por POST
$idTicket = isset($_POST['idTicket']) ? $_POST['idTicket'] : null;
$mensaje = isset($_POST['mensaje']) ? $_POST['mensaje'] : '';
$accion = '8'; // Estático
$idUser = isset($_SESSION['id']) ? $_SESSION['id'] : null; // ID de usuario de la sesión

// Validar los datos recibidos
error_log("Datos recibidos en el servidor: ");
error_log("idTicket: " . $idTicket);
error_log("mensaje: " . $mensaje);
error_log("accion: " . $accion);
error_log("idUser: " . $idUser);

if ($idTicket && $mensaje && $accion && $idUser) {
    // Insertar el comentario en la base de datos de forma segura (usando sentencias preparadas)
    $fecha = date('Y-m-d H:i:s');  // Fecha actual

    // Preparar la consulta SQL
    $query = "INSERT INTO historial (fecha, id_ticket, mensaje, accion, id_user) 
              VALUES (?, ?, ?, ?, ?)";

    // Usar sentencias preparadas para evitar inyecciones SQL
    if ($stmt = mysqli_prepare($conn, $query)) {
        // Vincular los parámetros
        mysqli_stmt_bind_param($stmt, "sssss", $fecha, $idTicket, $mensaje, $accion, $idUser);

        // Ejecutar la consulta
        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(['success' => true]);
        } else {
            // Error al ejecutar la consulta
            error_log("Error al ejecutar la consulta: " . mysqli_error($conn));
            echo json_encode(['success' => false, 'message' => 'Error al insertar comentario']);
        }

        // Cerrar la declaración
        mysqli_stmt_close($stmt);
    } else {
        // Error al preparar la consulta
        error_log("Error al preparar la consulta: " . mysqli_error($conn));
        echo json_encode(['success' => false, 'message' => 'Error al preparar la consulta']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
}

mysqli_close($conn);  // Cerrar la conexión
?>
