<?php
include '../conexion.php';
session_start();
$idUsuario = $_SESSION['id'];

// Verifica si los datos necesarios fueron enviados
if (isset($_POST['motivoCancelacion'], $_POST['idTicket'])) {
    $motivoCancelacion = $_POST['motivoCancelacion'];
    $idTicket = $_POST['idTicket'];

    $nuevoEstado = 6; // Estado "Cancelado"
    
    // Inicia la transacción
    $conn->begin_transaction();

    try {
        // Actualizar el estado del ticket
        $queryUpdateTicket = "UPDATE tickets SET status = ? WHERE id = ?";
        $stmt = $conn->prepare($queryUpdateTicket);
        $stmt->bind_param('ii', $nuevoEstado, $idTicket);
        $stmt->execute();
        $stmt->close();

        // Insertar en el historial
        $queryInsertHistorial = "INSERT INTO historial (id_ticket, id_user, mensaje, accion, fecha) VALUES (?, ?, ?, ?, NOW())";
        $stmtHistorial = $conn->prepare($queryInsertHistorial);
        $stmtHistorial->bind_param('iisi', $idTicket, $idUsuario, $motivoCancelacion, $nuevoEstado);
        $stmtHistorial->execute();
        $stmtHistorial->close();

        // Commit de la transacción
        $conn->commit();

        // Retorna un mensaje de éxito
        echo json_encode(['status' => 'success']);
        exit;
    } catch (Exception $e) {
        // En caso de error, revertir la transacción
        $conn->rollback();
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        exit;
    }
} else {
    // Si faltan datos
    echo json_encode(['status' => 'error', 'message' => 'Faltan datos para procesar la cancelación.']);
    exit;
}
?>
