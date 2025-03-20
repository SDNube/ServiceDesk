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

$result = $conn->query($query);
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
</head>
<body>

<div class="container-fluid mt-4">
    
    <h1>Tickets</h1>
    <br>
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#ticketTiComputadora">
        TI - Computadora
    </button>
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#ticketSistemaPlataforma">
        Sistema - Plataforma
    </button>
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#ticketSolicitudEquipo">
        Solicitud - Equipo
    </button>

    
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <button class="btn btn-primary" id="toggleFilters">Filtros</button>
    <button class="btn btn-success" id="exportExcel" hidden>Exportar a Excel</button>
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

<script>
$(document).ready(function() {
    // Mostrar u ocultar los filtros
    $('#toggleFilters').click(function() {
        $('#filterBanner').toggle();
    });

    // Función para aplicar filtros
    $('#applyFilters').click(function() {
        let filters = {
            path: $('#filterPath').val(),
            usuario: $('#filterUsuario').val().toLowerCase(),
            fecha: $('#filterFecha').val(),
            prioridad: $('#filterPrioridad').val(),
            status: $('#filterStatus').val(),
            statusText: $('#filterStatusText').val().toLowerCase()
        };

        // Filtrar las filas de la tabla
        $('#ticketsTable tbody tr').each(function() {
            let row = $(this);
            let isValid = true;

            // Revisar cada columna en función de los filtros
            row.find('td').each(function(index) {
                let cellText = $(this).text().toLowerCase();

                // Filtrar por cada campo según corresponda
                switch (index) {
                    case 0: // ID (no filtrar)
                        break;
                    case 1: // PATH
                        if (filters.path && !cellText.includes(filters.path.toLowerCase())) {
                            isValid = false;
                        }
                        break;
                    case 3: // Usuario
                        if (filters.usuario && !cellText.includes(filters.usuario)) {
                            isValid = false;
                        }
                        break;
                    case 4: // Fecha creación
                        if (filters.fecha && !cellText.includes(filters.fecha)) {
                            isValid = false;
                        }
                        break;
                    case 6: // Prioridad
                        if (filters.prioridad && !cellText.includes(filters.prioridad.toLowerCase())) {
                            isValid = false;
                        }
                        break;
                    case 7: // Status
                        if (filters.status && !cellText.includes(filters.status.toLowerCase())) {
                            isValid = false;
                        }
                        break;
                    case 9: // Asignado
                        if (filters.statusText && !cellText.includes(filters.statusText)) {
                            isValid = false;
                        }
                        break;
                }
            });

            // Mostrar u ocultar la fila según si es válida o no
            if (isValid) {
                row.show();
            } else {
                row.hide();
            }
        });
    });

    // Exportar a Excel (función como estaba antes)
    $('#exportExcel').click(function() {
        let table = document.getElementById('ticketsTable');
        let wb = XLSX.utils.table_to_book(table, {sheet: "Tickets"});
        XLSX.writeFile(wb, 'tickets.xlsx');
    });
});
}


</script>
