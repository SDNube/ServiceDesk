<?php include '../banner.php'; ?>
<?php 
include '../../logico/conexion.php'; 

// Obtener los datos de los tickets desde la base de datos
$query = "SELECT 
    t.id,
    t.path,
    t.problema,
    t.usuario,
    t.creacion,
    t.actualizacion,
    t.prioridad,
    t.status,
    t.departamento,
    t.asignado,
    t.descripcion_corta,
    t.mensaje,
    p.vista AS pvista,
    e.vista AS evista,
    u.nombre AS nombre_usuario,         -- Nombre del usuario
    u.paterno AS paterno_usuario,       -- Apellido paterno del usuario
    a.nombre AS nombre_asignado,        -- Nombre del asignado
    a.paterno AS paterno_asignado,      -- Apellido paterno del asignado
    p.vista AS prioridad_vista          -- Vista de la prioridad
FROM tickets t
JOIN prioridad p ON t.prioridad = p.ID
JOIN estado e ON t.status = e.ID
JOIN datos_usuarios u ON t.usuario = u.id_user    -- Para obtener los datos del 'usuario'
JOIN datos_usuarios a ON t.asignado = a.id_user  -- Para obtener los datos del 'asignado'
;
";


$query = "SELECT u.id, d.nombre, d.paterno 
          FROM users u 
          JOIN datos_usuarios d ON u.id = d.id_user 
          WHERE u.id_rol = 2";
$result = mysqli_query($conn, $query);

$users = [];
while ($row = mysqli_fetch_assoc($result)) {
    $users[] = $row;
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tickets</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <!-- Cargar jQuery completo (no la versión slim) -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../../../css/filtros.css">
</head>
<body>

<div class="container-fluid mt-4">
    
    <h1>Tickets</h1>
    <br>
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
                            <input type="checkbox" class="filter-status" value="En Proceso" checked>
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
                            <input type="checkbox" class="filter-priority" value="Urgente" checked>
                        </div>
                        <span class="ml-2 text-danger">Urgente</span>
                    </li>
                    <li class="d-flex align-items-center mb-2">
                        <div class="input_wrapper">
                            <input type="checkbox" class="filter-priority" value="Alta" checked>
                        </div>
                        <span class="ml-2 text-warning">Alta</span>
                    </li>
                    <li class="d-flex align-items-center mb-2">
                        <div class="input_wrapper">
                            <input type="checkbox" class="filter-priority" value="Media" checked>
                        </div>
                        <span class="ml-2 text-success">Media</span>
                    </li>
                    <li class="d-flex align-items-center mb-2">
                        <div class="input_wrapper">
                            <input type="checkbox" class="filter-priority" value="Baja" checked>
                        </div>
                        <span class="ml-2 text-muted">Baja</span>
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

            <!-- Nueva columna para Filtrar por Usuario Asignado -->
            <div class="col-md-4">
                <h5>Asignado a:</h5>
                <select id="filter-user" class="form-control">
                    <option value="">Todos</option>
                </select>
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
    <div id="filterBanner" class="mt-3 p-3 border rounded" style="display: none; background: #f8f9fa;">
    <div class="row">
        <div class="col-md-3">
            <label>Path</label>
            <select class="form-control" id="filterPath">
                <option value="">Todos</option>
                <option>Plataforma</option>
                <option>Computadora</option>
                <option>Solicitud</option>
            </select>
        </div>
        <div class="col-md-3">
            <label>Usuario</label>
            <input type="text" class="form-control" id="filterUsuario">
        </div>
        <div class="col-md-3">
            <label>Fecha Creación</label>
            <input type="date" class="form-control" id="filterFecha">
        </div>
        <div class="col-md-3">
            <label>Prioridad</label>
            <select class="form-control" id="filterPrioridad">
                <option value="">Todas</option>
                <option>Critica</option>
                <option>Urgente</option>
                <option>Alta</option>
                <option>Media</option>
                <option>Baja</option>
            </select>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-3">
            <label>Status</label>
            <select class="form-control" id="filterStatus">
                <option value="">Todos</option>
                <option>Nuevo</option>
                <option>En proceso</option>
                <option>Resuelto</option>
                <option>Cerrado</option>
                <option>En pausa</option>
                <option>Cancelado</option>
                <option>Actualizado</option>
                <option>Comentario</option>
            </select>
        </div>
        <div class="col-md-3">
            <label>Status (Texto)</label>
            <input type="text" class="form-control" id="filterStatusText">
        </div>
        <div class="col-md-3">
            <button class="btn btn-primary mt-4" id="applyFilters">Aplicar Filtros</button>
        </div>
    </div>
</div>

    <div class="table-responsive"><br><br>
        
        <table class="table table-striped text-center w-100">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>PATH</th>
                    <th>Problema</th>
                    <th>Usuario</th>
                    <th>Fecha creación</th>
                    <th>Fecha actualización</th>
                    <th>Prioridad</th>
                    <th>Status</th>
                    <th>Departamento</th>
                    <th>Asignado a</th>
                    <th>Descripción corta</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$row['id']}</td>";
                        echo "<td>{$row['path']}</td>";
                        echo "<td>{$row['problema']}</td>";
                        echo "<td>{$row['nombre_usuario']} {$row['paterno_usuario']}</td>";
                        echo "<td>{$row['creacion']}</td>";
                        echo "<td>{$row['actualizacion']}</td>";
                        echo "<td>{$row['pvista']}</td>";
                        echo "<td>{$row['evista']}</td>";
                        echo "<td>{$row['departamento']}</td>";
                        echo "<td>{$row['nombre_asignado']} {$row['paterno_asignado']}</td>";
                        echo "<td>{$row['descripcion_corta']}</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='11'>No hay tickets registrados</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Incluir los modales -->
<?php 
include '../../modales/tickets/modalSistemaPlataforma.php';
include '../../modales/tickets/modalTiComputadora.php';
include '../../modales/tickets/modalSolicitudEquipo.php';
?>

</body>
</html>
<script src="../../../js/filtros.js"></script>