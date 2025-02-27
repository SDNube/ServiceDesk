<?php
include '../../logico/conexion.php';

header('Content-Type: application/json');  // Asegúrate de enviar el encabezado correcto para JSON

// Verificamos que se haya enviado el 'idTicket' y 'path'
if (isset($_GET['idTicket']) && isset($_GET['path'])) {
    $idTicket = $_GET['idTicket'];
    $path = $_GET['path'];  // Recibimos el 'path' desde el JS

    // Consulta común para obtener los datos del ticket
    $query = "SELECT problema, descripcion_corta, mensaje, id FROM tickets WHERE id = '$idTicket'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $ticket = $result->fetch_assoc();
        
        // Si el path es 'Computadora'
        if ($path == 'Computadora') {
            // Extraemos las pruebas del campo mensaje
            $pruebas = $ticket['mensaje']; // Solo lo que está después de "Pruebas:"
            
            // Armamos la respuesta
            $response = [
                'problema' => $ticket['problema'],
                'descripcion_corta' => $ticket['descripcion_corta'],
                'pruebas' => $pruebas,
                
            ];
        }
        // Si el path es 'Plataforma'
        elseif ($path == 'Plataforma') {
            // Extraemos los datos del campo 'mensaje' usando expresiones regulares
            preg_match('/Problema:\s*(.*)/', $ticket['mensaje'], $problema);
            preg_match('/Descripción:\s*(.*)/', $ticket['mensaje'], $descripcion);
            preg_match('/ID Cliente:\s*(\d+)/', $ticket['mensaje'], $idCliente);
            preg_match('/CP Origen:\s*(\d+)/', $ticket['mensaje'], $cpOrigen);
            preg_match('/CP Destino:\s*(\d+)/', $ticket['mensaje'], $cpDestino);
            preg_match('/Largo:\s*(\d+)\s*cm/', $ticket['mensaje'], $largo);
            preg_match('/Alto:\s*(\d+)\s*cm/', $ticket['mensaje'], $alto);
            preg_match('/Ancho:\s*(\d+)\s*cm/', $ticket['mensaje'], $ancho);
            preg_match('/Peso:\s*(\d+)\s*kg/', $ticket['mensaje'], $peso);

            // Armamos la respuesta para 'Plataforma'
            $response = [
                'id' => $ticket['id'],
                'problema' => isset($problema[1]) ? $problema[1] : '',
                'descripcion_corta' => isset($descripcion[1]) ? $descripcion[1] : '',
                'id_cliente' => isset($idCliente[1]) ? $idCliente[1] : '',
                'cp_origen' => isset($cpOrigen[1]) ? $cpOrigen[1] : '',
                'cp_destino' => isset($cpDestino[1]) ? $cpDestino[1] : '',
                'largo' => isset($largo[1]) ? $largo[1] : '',
                'alto' => isset($alto[1]) ? $alto[1] : '',
                'ancho' => isset($ancho[1]) ? $ancho[1] : '',
                'peso' => isset($peso[1]) ? $peso[1] : '',
                'pruebas' => isset($ticket['mensaje']) ? $ticket['mensaje'] : '' // Mostramos todo el mensaje
            ];
        } else {
            // Si el path no es 'Computadora' ni 'Plataforma', enviamos un error
            $response = ['error' => 'Path no válido'];
        }
    } else {
        // Si no se encuentra el ticket
        $response = ['error' => 'Ticket no encontrado'];
    }
} else {
    // Si no se envían los parámetros 'idTicket' o 'path'
    $response = ['error' => 'ID del ticket o path no proporcionados'];
}

// Devolvemos la respuesta en formato JSON
echo json_encode($response);
?>
