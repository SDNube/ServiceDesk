<?php
// Incluir el archivo de conexión a la base de datos
session_start();
include('../conexion.php'); // Ajusta la ruta según tu estructura
date_default_timezone_set('America/Mexico_City');

// Verificar si la sesión está iniciada y el usuario está autenticado
if (!isset($_SESSION['id'])) {
    die(json_encode(['status' => 'error', 'message' => 'Sesión no iniciada. Inicia sesión nuevamente.']));
}

$idUser = $_SESSION['id'];

// Verificar si los datos del formulario han sido enviados
if (isset($_POST['idTicketEdicion'], $_POST['problema'], $_POST['descripcion'])) {
    // Recibir los datos del formulario
    $idTicket = $_POST['idTicketEdicion'];
    $problema = $_POST['problema'];
    $descripcion = $_POST['descripcion'];
    $pruebas = $_POST['pruebas'] ?? ''; // Solo se toma si existe
    $path = $_POST['modalOrigin'] ?? ''; // Evita el error si no está definido

    $fecha_actualizacion = date('Y-m-d H:i:s');

    // Obtener los valores actuales del ticket antes de la actualización
    $querySelect = "SELECT problema, descripcion_corta, mensaje FROM tickets WHERE id = ?";
    $stmtSelect = $conn->prepare($querySelect);
    $stmtSelect->bind_param("i", $idTicket);
    $stmtSelect->execute();
    $resultSelect = $stmtSelect->get_result();
    $ticketActual = $resultSelect->fetch_assoc();
    $stmtSelect->close();

    // Determinar qué columnas han cambiado
    $columnasEditadas = [];
    $nuevoMensaje = '';

    if ($ticketActual) {
        if ($ticketActual['problema'] !== $problema) $columnasEditadas[] = 'problema';
        if ($ticketActual['descripcion_corta'] !== $descripcion) $columnasEditadas[] = 'descripcion_corta';

        // **Caso Plataforma**
        if ($path == 'Plataforma') {
            $idCliente = $_POST['idCliente'] ?? '';
            $cpOrigen = $_POST['cpOrigen'] ?? '';
            $cpDestino = $_POST['cpDestino'] ?? '';
            $largo = $_POST['largo'] ?? '';
            $alto = $_POST['alto'] ?? '';
            $ancho = $_POST['ancho'] ?? '';
            $peso = $_POST['peso'] ?? '';

            $nuevoMensaje = "Problema: $problema\nDescripción: $descripcion\n" .
                            "ID Cliente: $idCliente\nCP Origen: $cpOrigen\nCP Destino: $cpDestino\n" .
                            "Largo: $largo cm\nAlto: $alto cm\nAncho: $ancho cm\nPeso: $peso kg";
        }
        // **Caso Computadora**
        elseif ($path == 'Computadora') {
            $nuevoMensaje = "Problema: $problema\nDescripción: $descripcion\nPruebas: $pruebas";
        }
        // **Otros casos**
        else {
            $nuevoMensaje = $pruebas;
        }

        // Validar si el mensaje ha cambiado
        if ($ticketActual['mensaje'] !== $nuevoMensaje) {
            $columnasEditadas[] = 'mensaje';
        }
    }

    // Evitar error si no hay cambios
    if (empty($columnasEditadas)) {
        echo json_encode(['status' => 'info', 'message' => 'No hubo cambios en el ticket.']);
        exit();
    }

    $mensajeHistorial = "Se actualizó:\n" . implode(", ", $columnasEditadas);

    // **Actualizar el ticket**
    $queryUpdate = "UPDATE tickets SET 
                        problema = ?, 
                        descripcion_corta = ?, 
                        mensaje = ?, 
                        actualizacion = ? 
                    WHERE id = ?";
    $stmtUpdate = $conn->prepare($queryUpdate);
    $stmtUpdate->bind_param("ssssi", $problema, $descripcion, $nuevoMensaje, $fecha_actualizacion, $idTicket);

    if ($stmtUpdate->execute()) {
        $stmtUpdate->close();

        // **Insertar en historial**
        $queryHistorial = "INSERT INTO historial (id_ticket, id_user, mensaje, accion, fecha) 
                           VALUES (?, ?, ?, ?, NOW())";
        $stmtHistorial = $conn->prepare($queryHistorial);
        $accion = 7;
        
        if (!empty($mensajeHistorial) && !empty($accion)) {
            $stmtHistorial->bind_param("iisi", $idTicket, $idUser, $mensajeHistorial, $accion);

            if ($stmtHistorial->execute()) {
                $stmtHistorial->close();
                header("Location: ../../vista/tickets/ticketscliente.php");
                exit();
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al registrar en historial.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error: Mensaje de historial o acción vacíos.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error al actualizar el ticket.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Faltan los datos necesarios: ID Ticket, Problema, Descripción.']);
}

$conn->close();
?>
