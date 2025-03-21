<?php 
include '../banner.php';
include '../../logico/conexion.php'; 
include '../../modales/tickets/modalSolicitudEquipo.php';
include '../../modales/tickets/modalSistemaPlataforma.php';
include '../../modales/tickets/modalTiComputadora.php';
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
            AND e.vista NOT IN ('tarta')"; // Filtrando los estados no deseados

    $result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Tickets</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../../../css/filtros.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.4/dist/sweetalert2.min.css"></link>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.4/dist/sweetalert2.all.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="../../../js/cancelacionTicket.js"></script>
    <script src="../../../js/abrirModalVerTicket.js"></script>
    <script src="../../../js/abrirModalComentarios.js"></script>

</head>
<body>
<div class="container-fluid mt-4">
    <h1>Mis Tickets</h1>

    <!-- Botones para abrir modales -->
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#ticketTiComputadora">
        TI - Computadora
    </button>
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#ticketSistemaPlataforma">
        Sistema - Plataforma
    </button>
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#ticketSolicitudEquipo">
        Solicitud - Equipo
    </button>

    <div id="filters" style="display: none;">
    <div class="row my-3">
        <!-- Filtro por Status -->
        <div class="col-md-4">
            <h5>Status:</h5>
            <ul class="list-unstyled">
                <li class="d-flex align-items-center mb-2">
                    <div class="input_wrapper">
                        <input type="checkbox" class="filter-status" value="Nuevo" checked>
                    </div>
                    <span class="ml-2">Nuevo</span>
                </li>
                <li class="d-flex align-items-center mb-2">
                    <div class="input_wrapper">
                        <input type="checkbox" class="filter-status" value="En proceso" checked>
                    </div>
                    <span class="ml-2">En Proceso</span>
                </li>
                <li class="d-flex align-items-center mb-2">
                    <div class="input_wrapper">
                        <input type="checkbox" class="filter-status" value="Resuelto">
                    </div>
                    <span class="ml-2">Resuelto</span>
                </li>
                <li class="d-flex align-items-center mb-2">
                    <div class="input_wrapper">
                        <input type="checkbox" class="filter-status" value="Cerrado">
                    </div>
                    <span class="ml-2">Cerrado</span>
                </li>
                <li class="d-flex align-items-center mb-2">
                    <div class="input_wrapper">
                        <input type="checkbox" class="filter-status" value="En Pausa" checked>
                    </div>
                    <span class="ml-2">En Pausa</span>
                </li>
                <li class="d-flex align-items-center mb-2">
                    <div class="input_wrapper">
                        <input type="checkbox" class="filter-status" value="Cancelado">
                    </div>
                    <span class="ml-2">Cancelado</span>
                </li>
                <li class="d-flex align-items-center mb-2">
                    <div class="input_wrapper">
                        <input type="checkbox" class="filter-status" value="Actualizado" checked>
                    </div>
                    <span class="ml-2">Actualizado</span>
                </li>
                <li class="d-flex align-items-center mb-2">
                    <div class="input_wrapper">
                        <input type="checkbox" class="filter-status" value="Comentario" checked>
                    </div>
                    <span class="ml-2">Comentario</span>
                </li>
            </ul>
        </div>

        <!-- Filtro por Prioridad -->
        <div class="col-md-4">
            <h5>Prioridad:</h5>
            <ul class="list-unstyled">
            <li class="d-flex align-items-center mb-2">
                    <div class="input_wrapper">
                        <input type="checkbox" class="filter-priority" value="Critica" checked>
                    </div>
                    <span class="ml-2 ">Critica</span>
                </li>
                <li class="d-flex align-items-center mb-2">
                    <div class="input_wrapper">
                        <input type="checkbox" class="filter-priority" value="Urgente" checked>
                    </div>
                    <span class="ml-2 ">Urgente</span>
                </li>
                <li class="d-flex align-items-center mb-2">
                    <div class="input_wrapper">
                        <input type="checkbox" class="filter-priority" value="Alta" checked>
                    </div>
                    <span class="ml-2 ">Alta</span>
                </li>
                <li class="d-flex align-items-center mb-2">
                    <div class="input_wrapper">
                        <input type="checkbox" class="filter-priority" value="Media" checked>
                    </div>
                    <span class="ml-2 ">Media</span>
                </li>
                <li class="d-flex align-items-center mb-2">
                    <div class="input_wrapper">
                        <input type="checkbox" class="filter-priority" value="Baja" checked>
                    </div>
                    <span class="ml-2 ">Baja</span>
                </li>
            </ul>
        </div>

        <!-- Filtro por Path -->
        <div class="col-md-4">
            <h5>Path:</h5>
            <ul class="list-unstyled">
                <li class="d-flex align-items-center mb-2">
                    <div class="input_wrapper">
                        <input type="checkbox" class="filter-path" value="Computadora" checked>
                    </div>
                    <span class="ml-2">Computadora</span>
                </li>
                <li class="d-flex align-items-center mb-2">
                    <div class="input_wrapper">
                        <input type="checkbox" class="filter-path" value="Plataforma" checked>
                    </div>
                    <span class="ml-2">Plataforma</span>
                </li>
                <li class="d-flex align-items-center mb-2">
                    <div class="input_wrapper">
                        <input type="checkbox" class="filter-path" value="Solicitud" checked>
                    </div>
                    <span class="ml-2">Solicitud</span>
                </li>
            </ul>
        </div>
    </div>
</div>
<p></p>
    <div class="row mb-3">
        <div class="col-md-12 d-flex justify-content-start">
            <div class="input-group" style="max-width: 300px;">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                </div>
                <input id="buscador" class="form-control" type="text" placeholder="Buscar por ID...">
            </div>
            
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12 d-flex justify-content-start">
            <div class="input-group" style="max-width: 300px;">
                <div class="input-group-prepend">
                <button id="toggle-filters" class="btn btn-primary mb-3">Mostrar Filtros</button>
                </div>
                
            </div>
        </div>
    </div>

    <!-- Tabla de Tickets -->
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
            <tbody id="ticketsTable">
                <?php
                while ($row = $result->fetch_assoc()) {
                    $clasePrioridad = ($row['prioridad'] == "Urgente" || $row['prioridad_id'] == 2) ? "urgente" : "";
                    echo "<tr data-status='{$row['status']}' data-priority='{$row['prioridad']}' data-path='{$row['path']}'>";
                    echo "<td>{$row['id']}</td>";
                    echo "<td>{$row['path']}</td>";
                    echo "<td>{$row['problema']}</td>";
                    echo "<td>{$row['creacion']}</td>";
                    echo "<td>{$row['actualizacion']}</td>";
                    echo "<td class='$clasePrioridad'>{$row['prioridad']}</td>";
                    echo "<td>{$row['status']}</td>";
                    echo "<td>{$row['nombre']} {$row['paterno']}</td>";
                    echo "<td>{$row['descripcion_corta']}</td>";
                    echo "<td class='text-center align-middle'>
                            <button class='btn btn-danger' onclick='abrirModalCancelacion({$row['id']})'>X</button>
                            <button class='btn btn-info' onclick='abrirModalVerTicket({$row['id']}, \"{$row['path']}\")'>
                                <img src='../../../imagenes/ver.png' style='width: 22px; height: 25px;'>
                            </button>
                            <button class='btn btn-warning' onclick='abrirModalComentarios({$row['id']})'>
                                <img src='../../../imagenes/comentario.png' style='width: 22px; height: 25px;'>
                            </button>
                          </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<?php 
include '../../modales/tickets/modalComentarios.php';
include '../../modales/tickets/modalCancelacion.php';
include '../../modales/tickets/modalTiComputadoraEdicion.php'; 
include '../../modales/tickets/modalSistemaPlataformaEdicion.php';
?>

<script src="../../../js/filtros.js"></script>
