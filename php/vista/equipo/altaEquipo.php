<?php
    include('../banner.php');

include '../../logico/conexion.php'; 
include '../../modales/equipo/modalAltaEquipo.php';
include '../../modales/equipo/modalAsignarEquipo.php';

// Consulta para obtener los equipos y su tipo asociado
$sqlComputo = "SELECT e.id, e.descripcion, e.marca, e.modelo, e.sn, e.fechaAlta, e.estado, t.tipo 
        FROM equipo e 
        JOIN tipo_equipo t ON e.tipoequipo = t.id 
        WHERE e.asignado IS NULL AND t.id = 1";

$resultComputo = $conn->query($sqlComputo);

$sqlCelular = "SELECT e.id, e.descripcion, e.marca, e.modelo, e.sn, e.fechaAlta, e.estado, t.tipo 
        FROM equipo e 
        JOIN tipo_equipo t ON e.tipoequipo = t.id 
        WHERE e.asignado IS NULL AND t.id = 2";

$resultCelular = $conn->query($sqlCelular);

$sqlAccesorio = "SELECT e.id, e.descripcion, e.marca, e.modelo, e.sn, e.fechaAlta, e.estado, t.tipo 
        FROM equipo e 
        JOIN tipo_equipo t ON e.tipoequipo = t.id 
        WHERE e.asignado IS NULL AND t.id = 3";

$resultAccesorio = $conn->query($sqlAccesorio);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipos</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <script src="../../../js/asignarEquipo.js"></script>

</head>
<body>

    <div class="container mt-4">
        <h1 class="mb-3">Equipos sin asignar</h1>
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#equipoModal">
            Agregar Equipo
        </button>
        
        <p></p>
        <ul class="nav nav-tabs" id="formTabs" role="tablist">
            <li class="nav-item">
                <button class="nav-link active" id="computo-tab" data-bs-toggle="tab" data-bs-target="#computo" type="button" role="tab">Equipo de Cómputo</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="telefonia-tab" data-bs-toggle="tab" data-bs-target="#telefonia" type="button" role="tab">Telefonía</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="accesorios-tab" data-bs-toggle="tab" data-bs-target="#accesorios" type="button" role="tab">Accesorios</button>
            </li>
        </ul>


        <div class="tab-content mt-3" id="formTabsContent">
        
            <!-- Formulario de Equipo de Cómputo -->
            <div class="tab-pane fade show active" id="computo" role="tabpanel">
                <div class="table-responsive-lg">
                    <table class="table table-striped text-center">
                        <thead>
                            <tr>
                                <th>Descripción</th>
                                <th>Marca</th>
                                <th>Modelo</th>
                                <th>Serie</th>
                                <th>Estado</th>
                                <th>Fecha Alta</th>
                                
                                <th>Tipo</th>
                                <th>Editar</th>
                                <th>Eliminar</th>
                                <th>Asignar</th>
                            </tr> 
                        </thead>
                        <tbody>
                        <?php
                            if ($resultComputo->num_rows > 0) {
                                while ($row = $resultComputo->fetch_assoc()) {
                                    echo "<tr>
                                            <td>" . htmlspecialchars($row['descripcion']) . "</td>
                                            <td>" . htmlspecialchars($row['marca']) . "</td>
                                            <td>" . htmlspecialchars($row['modelo']) . "</td>
                                            <td>" . htmlspecialchars($row['sn']) . "</td>
                                            <td>" . htmlspecialchars($row['estado']) . "</td>
                                            <td>" . htmlspecialchars($row['fechaAlta']) . "</td>
                                            
                                            <td>" . htmlspecialchars($row['tipo']) . "</td>
                                            <td><button class='btn btn-primary'>Editar</button></td>
                                            <td>
                                                <button class='btn btn-danger delete-btn' data-id='" . $row['id'] . "'>
                                                    Eliminar
                                                </button>
                                            </td>  
                                            <td>
                                                <button class='btn btn-warning asignar-btn' 
                                                        data-id_equipo='" . $row["id"] . "' 
                                                        data-toggle='modal' 
                                                        data-target='#asignarModal'>
                                                    Asignar
                                                </button>
                                            </td>
                                        </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='10'>No hay equipos registrados.</td></tr>";
                            }
                            $conn->close();
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="tab-pane fade show " id="telefonia" role="tabpanel">
                <div class="table-responsive">
                    <table class="table table-striped text-center">
                        <thead>
                            <tr>
                                <th>Descripción</th>
                                <th>Marca</th>
                                <th>Modelo</th>
                                <th>Serie</th>
                                <th>Estado</th>
                                <th>Fecha Alta</th>
                                <th>Tipo</th>
                                <th>Editar</th>
                                <th>Eliminar</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            if ($resultCelular->num_rows > 0) {
                                while ($row = $resultCelular->fetch_assoc()) {
                                    echo "<tr>
                                            <td>" . htmlspecialchars($row['descripcion']) . "</td>
                                            <td>" . htmlspecialchars($row['marca']) . "</td>
                                            <td>" . htmlspecialchars($row['modelo']) . "</td>
                                            <td>" . htmlspecialchars($row['sn']) . "</td>
                                            <td>" . htmlspecialchars($row['estado']) . "</td>
                                            <td>" . htmlspecialchars($row['fechaAlta']) . "</td>
                                            
                                            <td>" . htmlspecialchars($row['tipo']) . "</td>
                                            <td><button class='btn btn-primary'>Editar</button></td>
                                            <td>
                                                <button class='btn btn-danger delete-btn' data-id='" . $row['id'] . "'>
                                                    Eliminar
                                                </button>
                                            </td>   
                                        </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='10'>No hay equipos registrados.</td></tr>";
                            }
                            
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="tab-pane fade show " id="accesorios" role="tabpanel">
                <div class="table-responsive">
                    <table class="table table-striped text-center">
                        <thead>
                            <tr>
                                <th>Descripción</th>
                                <th>Marca</th>
                                <th>Modelo</th>
                                <th>Serie</th>
                                <th>Estado</th>
                                <th>Fecha Alta</th>
                                
                                <th>Tipo</th>
                                <th>Editar</th>
                                <th>Eliminar</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            if ($resultAccesorio->num_rows > 0) {
                                while ($row = $resultAccesorio->fetch_assoc()) {
                                    echo "<tr>
                                            <td>" . htmlspecialchars($row['descripcion']) . "</td>
                                            <td>" . htmlspecialchars($row['marca']) . "</td>
                                            <td>" . htmlspecialchars($row['modelo']) . "</td>
                                            <td>" . htmlspecialchars($row['sn']) . "</td>
                                            <td>" . htmlspecialchars($row['estado']) . "</td>
                                            <td>" . htmlspecialchars($row['fechaAlta']) . "</td>
                                            
                                            <td>" . htmlspecialchars($row['tipo']) . "</td>
                                            <td><button class='btn btn-primary'>Editar</button></td>
                                            <td>
                                                <button class='btn btn-danger delete-btn' data-id='" . $row['id'] . "'>
                                                    Eliminar
                                                </button>
                                            </td>   
                                        </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='10'>No hay equipos registrados.</td></tr>";
                            }
                            
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>          
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<script>
    $(document).ready(function() {
        $('.delete-btn').click(function() {
            var id = $(this).data('id');
            var confirmacion = confirm("¿Está seguro de que desea eliminar este equipo?");
            if (confirmacion) {
                $.ajax({
                    url: '../logico/eliminarEquipo.php',
                    method: 'POST',
                    data: { id: id },
                    success: function(response) {
                        alert('Equipo eliminado correctamente.');
                        location.reload();
                    },
                    error: function() {
                        alert('Hubo un problema al eliminar el equipo.');
                    }
                });
            }
        });
    });
</script>
