<?php include '../banner.php'; ?>
<?php 
include '../../logico/conexion.php'; 

// Obtener los datos de los tickets desde la base de datos
$query = "SELECT id, path, problema, usuario, creacion, actualizacion, prioridad, status, departamento, asignado, descripcion_corta, mensaje FROM tickets";
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
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#ticketTiComputadora">
        TI - Computadora
    </button>
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#ticketSistemaPlataforma">
        Sistema - Plataforma
    </button>
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#ticketSolicitudEquipo">
        Solicitud - Equipo
    </button>
    <p></p>

    <div class="table-responsive">
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
                        echo "<td>{$row['usuario']}</td>";
                        echo "<td>{$row['creacion']}</td>";
                        echo "<td>{$row['actualizacion']}</td>";
                        echo "<td>{$row['prioridad']}</td>";
                        echo "<td>{$row['status']}</td>";
                        echo "<td>{$row['departamento']}</td>";
                        echo "<td>{$row['asignado']}</td>";
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