<?php 
include '../banner.php';
include '../../logico/conexion.php'; 
$idUsuario = $_SESSION['id']; // Obtener el ID del usuario de la sesión

// Obtener los tickets del usuario con la prioridad y estado, excluyendo los estados "Cancelado", "Cerrado" y "Resuelto"
    $query = "SELECT 
                t.id, 
                t.path, 
                t.problema, 
                t.usuario, 
                t.creacion, 
                t.actualizacion, 
                p.ID AS prioridad_id, 
                p.vista AS prioridad, 
                e.vista AS status, 
                t.asignado, 
                t.descripcion_corta,
                u.nombre, 
                u.paterno
            FROM tickets t
            LEFT JOIN prioridad p ON t.prioridad = p.ID
            LEFT JOIN estado e ON t.status = e.ID
            LEFT JOIN datos_usuarios u ON t.asignado = u.id_user
            WHERE t.usuario = '$idUsuario' 
            AND e.vista NOT IN ('Cancelado', 'Cerrado', 'Resuelto')"; // Filtrando los estados no deseados

    $result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Tickets</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <!-- Cargar jQuery completo -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Incluir el archivo JavaScript externo para la cancelación -->
    <script src="../../../js/cancelacionTicket.js"></script> <!-- Ruta correcta -->
    <script src="../../../js/abrirModalVerTicket.js"></script>
    <script src="../../../js/abrirModalComentarios.js"></script>


    <style>
        /* Animación para prioridad urgente */
        @keyframes parpadeo {
            0% { color: red; }
            50% { color: black; }
            100% { color: red; }
        }
        .urgente {
            animation: parpadeo 1s infinite;
            font-weight: bold;
        }
    </style>

    <script>
        $(document).ready(function() {
            $('#buscador').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                
                $('table tbody tr').filter(function() {
                    var text = $(this).find('td').eq(0).text().toLowerCase(); // Buscar solo en la columna de ID
                    $(this).toggle(text.indexOf(value) > -1);
                });
            })
        });
    </script>

</head>
<body>

<div class="container-fluid mt-4">
    <h1>Mis Tickets</h1>
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#ticketTiComputadora">
        TI - Computadora
    </button>
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#ticketSistemaPlataforma">
        Sistema - Plataforma
    </button>
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#ticketSolicitudEquipo">
        Solicitud - Equipo
    </button>
    <!-- Buscador con Bootstrap alineado a la derecha -->
    <div class="row mb-3">
        <div class="col-md-12 d-flex justify-content-end">
            <div class="input-group" style="max-width: 300px;">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                </div>
                <input id="buscador" class="form-control" type="text" placeholder="Buscar por ID...">
            </div>
        </div>
    </div>
    <p></p>

    <div class="table-responsive">
        <table class="table table-striped text-center w-100">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>PATH</th>
                    <th>Problema</th>
                    <th>Fecha creación</th>
                    <th>Fecha actualización</th>
                    <th>Prioridad</th>
                    <th>Status</th>
                    <th>Asignado a</th>
                    <th>Descripción corta</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $clasePrioridad = ($row['prioridad'] == "Urgente" || $row['prioridad_id'] == 2) ? "urgente" : "";

                        echo "<tr>";
                        echo "<td>{$row['id']}</td>";
                        echo "<td>{$row['path']}</td>";
                        echo "<td>{$row['problema']}</td>";
                        echo "<td>{$row['creacion']}</td>";
                        echo "<td>{$row['actualizacion']}</td>";
                        echo "<td class='$clasePrioridad'>{$row['prioridad']}</td>";
                        echo "<td>{$row['status']}</td>";
                        echo "<td>{$row['nombre']} {$row['paterno']}</td>";
                        echo "<td>{$row['descripcion_corta']}</td>";
                        echo "<td class='text-center align-middle' style='display: flex; justify-content: center; align-items: center; gap: 5px;'>
                                <button class='btn btn-danger d-flex justify-content-center align-items-center' 
                                        style='width: 30px; height: 30px; font-size: 18px; color: white;' 
                                        onclick='abrirModalCancelacion({$row['id']})'>
                                    X
                                </button>
                                <button class='btn btn-info d-middle' justify-content-center align-items-center' 
                                        style='width: 31px; height: 31px; padding: 0;' 
                                        onclick='abrirModalVerTicket({$row['id']}, \"{$row['path']}\")'>
                                    <img src='../../../imagenes/ver.png' alt='Ver' style='width: 22px; height: 25px;'>
                                </button>
                                 
                                <button class='btn btn-warning d-middle' 
                                        style='width: 31px; height: 31px; padding: 0;' 
                                        onclick='abrirModalComentarios({$row['id']})'>
                                    <img src='../../../imagenes/comentario.png' alt='Ver' style='width: 22px; height: 25px;'>
                                </button>

                                ";

                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='10'>No tienes tickets registrados</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modales -->
<?php 
include '../../modales/tickets/modalComentarios.php';
include '../../modales/tickets/modalCancelacion.php';
include '../../modales/tickets/modalSistemaPlataforma.php';
include '../../modales/tickets/modalTiComputadora.php';
include '../../modales/tickets/modalSolicitudEquipo.php';
include '../../modales/tickets/modalTiComputadoraEdicion.php'; 
include '../../modales/tickets/modalSistemaPlataformaEdicion.php';
?>

</body>
</html>
