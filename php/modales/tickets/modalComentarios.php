<?php
$nombre = "Auan Perez";
$inicial = strtoupper(substr($nombre, 0, 1));

$idTicket = isset($_POST['idTicket']) ? $_POST['idTicket'] : "3"; // Valor por defecto es 3
error_log("ID del Ticket recibido: " . $idTicket);

include('../../logico/conexion.php'); // Asegúrate de que la ruta sea correcta
date_default_timezone_set('America/Mexico_City');

// Consulta SQL para obtener historial
$query = "SELECT h.fecha, h.mensaje, h.id_user, e.vista 
          FROM historial h
          JOIN estado e ON h.accion = e.id
          WHERE h.id_ticket = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $idTicket);
$stmt->execute();
$result = $stmt->get_result();

error_log("Número de registros encontrados: " . $result->num_rows);
?>

<link href="../../../css/comentarios.css" type="text/css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<div class="modal fade" id="modalComentarios" tabindex="-1" role="dialog" aria-labelledby="modalComentariosLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalComentariosLabel">Ticket ID: <?php echo $idTicket; ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="messaging">
          <div class="inbox_msg">
            <div class="inbox_people">
              <div class="headind_srch">
                <div class="recent_heading">
                  <h4>Actualizaciones</h4>
                </div>
              </div>
              <div class="inbox_chat">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        // Obtener nombre y apellido del usuario
                        $userQuery = "SELECT nombre, paterno FROM datos_usuarios WHERE id_user = ?";
                        $userStmt = $conn->prepare($userQuery);
                        $userStmt->bind_param('i', $row['id_user']);
                        $userStmt->execute();
                        $userResult = $userStmt->get_result();

                        if ($userResult->num_rows > 0) {
                            $user = $userResult->fetch_assoc();
                            $nombreCompleto = $user['nombre'] . " " . $user['paterno'];
                        } else {
                            $nombreCompleto = "Usuario desconocido";
                            error_log("Usuario no encontrado para ID: " . $row['id_user']);
                        }

                        // Verificación de fecha y mensaje
                        $fecha = date("M d", strtotime($row['fecha']));
                        $mensaje = $row['mensaje'];
                        $estadoVista = $row['vista'];
                        $inicial = strtoupper(substr($nombreCompleto, 0, 1));

                        // Verificar si los datos se están mostrando correctamente en el log
                        error_log("Actualización: " . $nombreCompleto . " - " . $fecha . " - " . $mensaje);

                        echo "
                        <script>console.log('Mostrando actualización: " . $nombreCompleto . " - " . $fecha . " - " . addslashes($mensaje) . "');</script>
                        <div class='chat_list active_chat'>
                          <div class='chat_people'>
                            <div class='chat_img'>
                              <span class='initial'>" . $inicial . "</span>
                            </div>
                            <div class='chat_ib'>
                              <h5>" . $nombreCompleto . " <span class='chat_date'>" . $fecha . "</span></h5>
                              <p><strong>Que se hizo: </strong>" . $estadoVista . "</p>
                              <p>" . $mensaje . "</p>
                            </div>
                          </div>
                        </div>";
                    }
                } else {
                    echo "<p>No se encontraron actualizaciones para este ticket.</p>";
                    error_log("No se encontraron actualizaciones para el ticket con ID: " . $idTicket);
                }
                ?>
              </div>
            </div>
            <div class="mesgs">
              <div class="msg_history">
                <!-- Historial de mensajes -->
              </div>
              <div class="type_msg">
                <div class="input_msg_write">
                  <input type="text" class="write_msg" placeholder="Escribe un mensaje" />
                  <button class="msg_send_btn" type="button">
                    <img src="../../../imagenes/comentario.png" alt="Enviar comentario">
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
