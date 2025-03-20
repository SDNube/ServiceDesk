<?php
include '../../logico/conexion.php'; 

if (isset($_GET['idTicket'])) {
    $idTicket = intval($_GET['idTicket']); // Asegurar que sea un número
    error_log("Consulta recibida para idTicket: " . $idTicket);

    $query = "SELECT h.id, e.vista, h.mensaje, h.fecha 
              FROM historial h 
              INNER JOIN estado e ON h.accion = e.id 
              WHERE h.id_ticket = ?";
    
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $idTicket);
        $stmt->execute();
        $result = $stmt->get_result();

        $comentarios = [];
        while ($row = $result->fetch_assoc()) {
            $comentarios[] = $row;
        }

        error_log("Datos obtenidos: " . json_encode($comentarios));
        echo json_encode($comentarios);
    } else {
        error_log("Error en la consulta SQL: " . $conn->error);
        echo json_encode(["error" => "Error en la consulta"]);
    }
} else {
    
}

$conn->close();
