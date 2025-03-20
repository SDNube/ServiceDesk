<?php
    include('../banner.php');

include '../../logico/conexion.php'; 
include '../../modales/equipo/modalAltaEquipo.php';
include '../../modales/equipo/modalAsignarEquipo.php';
include '../../modales/equipo/modalFirmarResponsiva.php';

// Consulta para equipos sin asignar y sin responsiva (asignado != NULL y firmado = NULL)
    $sqlSinResponsiva = "SELECT e.asignado, e.id, e.descripcion, e.marca, e.modelo, e.sn, e.fechaAlta, e.estado, t.tipo, u.nombre, u.paterno 
    FROM equipo e 
    JOIN tipo_equipo t ON e.tipoequipo = t.id 
    JOIN datos_usuarios u ON e.asignado = u.id_user
    WHERE e.asignado IS NOT NULL AND e.firmado IS NULL 
    LIMIT 5;";

// Consulta para equipos sin asignar y con responsiva (asignado != NULL y firmado != NULL)
    $sqlConResponsiva = "SELECT e.asignado, e.id, e.descripcion, e.marca, e.modelo, e.sn, e.firmado, e.fechaAlta, e.estado, t.tipo, u.nombre, u.paterno 
    FROM equipo e 
    JOIN tipo_equipo t ON e.tipoequipo = t.id 
    JOIN datos_usuarios u ON e.asignado = u.id_user
    WHERE e.asignado IS NOT NULL AND e.firmado IS NOT NULL LIMIT 5";

    $sqlComputo = "SELECT e.id, e.descripcion, e.marca, e.modelo, e.sn, e.fechaAlta, e.estado, t.tipo 
    FROM equipo e 
    JOIN tipo_equipo t ON e.tipoequipo = t.id 
    WHERE e.asignado IS NULL AND t.id = 1 LIMIT 5";

    $sqlCelular = "SELECT e.id, e.descripcion, e.marca, e.modelo, e.sn, e.fechaAlta, e.estado, t.tipo 
    FROM equipo e 
    JOIN tipo_equipo t ON e.tipoequipo = t.id 
    WHERE e.asignado IS NULL AND t.id = 2 LIMIT 5";

    $sqlAccesorio = "SELECT e.id, e.descripcion, e.marca, e.modelo, e.sn, e.fechaAlta, e.estado,  t.tipo 
    FROM equipo e 
    JOIN tipo_equipo t ON e.tipoequipo = t.id 
    WHERE e.asignado IS NULL AND t.id = 3 LIMIT 5";

    $resultComputo = $conn->query($sqlComputo);
    $resultCelular = $conn->query($sqlCelular);
    $resultAccesorio = $conn->query($sqlAccesorio);
    $resultSinResponsiva = $conn->query($sqlSinResponsiva);
    $resultConResponsiva = $conn->query($sqlConResponsiva);

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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script src="../../../js/asignarEquipo.js"></script>
    <script src="../../../js/firmarResponsiva.js"></script><!-- Asegúrate de incluir jQuery antes de tu archivo script.js -->

</body>


    <style>
        .table-container {
            max-height: 300px;
            overflow-y: auto;
        }
        .search-wrapper {
            margin-bottom: 10px;
        }
        .search-wrapper input {
            width: 100%;
        }
    </style>
    <script>
    $(document).ready(function() {
        $('.pdf-btn').click(function() {
            var sn = $(this).data('sn');  // Obtener número de serie de la fila
            
            $.ajax({
                url: '../../logico/equipo/obtenerPdf.php', // Archivo PHP que obtiene el PDF de la DB
                type: 'POST',
                data: { sn: sn },
                success: function(response) {
                    if (response.trim() !== "") {
                        window.open("../../../pdf/responsivas/" + response.trim(), '_blank'); // Redirigir al PDF
                    } else {
                        alert("No se encontró un PDF para este equipo.");
                    }
                },
                error: function() {
                    alert("Error al obtener el PDF.");
                }
            });
        });
    });
    </script>

    <script>
        // Función para filtrar las tablas
        $(document).ready(function () {
            // Filtro para la tabla de Equipo de Cómputo
            $("#searchComputo").on("keyup", function () {
                var value = $(this).val().toLowerCase();
                $("#computoTable tbody tr").filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });

            // Filtro para la tabla de Telefonía
            $("#searchTelefonia").on("keyup", function () {
                var value = $(this).val().toLowerCase();
                $("#telefoniaTable tbody tr").filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });

            // Filtro para la tabla de Accesorios
            $("#searchAccesorios").on("keyup", function () {
                var value = $(this).val().toLowerCase();
                $("#accesoriosTable tbody tr").filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });

            // Filtro para la tabla Sin Responsiva
            $("#searchSinResponsiva").on("keyup", function () {
                var value = $(this).val().toLowerCase();
                $("#sinResponsivaTable tbody tr").filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });

            // Filtro para la tabla Con Responsiva
            $("#searchConResponsiva").on("keyup", function () {
                var value = $(this).val().toLowerCase();
                $("#conResponsivaTable tbody tr").filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });
        });
    </script>

</head>
<body>

    <div class="container mt-4">
        <h1 class="mb-3">Equipos sin asignar</h1>
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#equipoModal">
            Agregar Equipo
        </button>

        <p></p>
        <p></p>
        <p></p>
        <!-- Primeras tres pestañas: Equipo de Cómputo, Telefonía y Accesorios -->
        <ul class="nav nav-tabs" id="formTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="computo-tab" data-toggle="tab" href="#computo" role="tab">Equipo de Cómputo</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="telefonia-tab" data-toggle="tab" href="#telefonia" role="tab">Telefonía</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="accesorios-tab" data-toggle="tab" href="#accesorios" role="tab">Accesorios</a>
            </li>
        </ul>

        <div class="tab-content mt-3" id="formTabsContent">

            <!-- Formulario de Equipo de Cómputo -->
            <div class="tab-pane fade show active" id="computo" role="tabpanel">
                <!-- Buscador de la tabla de Equipo de Cómputo -->
                <div class="search-wrapper">
                    <input type="text" id="searchComputo" class="form-control" placeholder="Buscar...">
                </div>
                <!-- Tabla de Equipo de Cómputo -->
                <div class="table-container">
                    <table class="table table-striped text-center" id="computoTable">
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
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Formulario de Telefonía -->
            <div class="tab-pane fade" id="telefonia" role="tabpanel">
                <!-- Buscador de la tabla de Telefonía -->
                <div class="search-wrapper">
                    <input type="text" id="searchTelefonia" class="form-control" placeholder="Buscar...">
                </div>
                <!-- Tabla de Telefonía -->
                <div class="table-container">
                    <table class="table table-striped text-center" id="telefoniaTable">
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
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Formulario de Accesorios -->
            <div class="tab-pane fade" id="accesorios" role="tabpanel">
                <!-- Buscador de la tabla de Accesorios -->
                <div class="search-wrapper">
                    <input type="text" id="searchAccesorios" class="form-control" placeholder="Buscar...">
                </div>
                <!-- Tabla de Accesorios -->
                <div class="table-container">
                    <table class="table table-striped text-center" id="accesoriosTable">
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
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Segunda serie de pestañas para las dos últimas tablas -->
        <ul class="nav nav-tabs mt-4" id="otherTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="sinResponsiva-tab" data-toggle="tab" href="#sinResponsiva" role="tab">Sin Responsiva</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="conResponsiva-tab" data-toggle="tab" href="#conResponsiva" role="tab">Con Responsiva</a>
            </li>
        </ul>

        <div class="tab-content mt-3" id="otherTabsContent">
                <div class="tab-pane fade show active" id="sinResponsiva" role="tabpanel">
                    <div class="search-wrapper">
                        <input type="text" id="searchSinResponsiva" class="form-control" placeholder="Buscar equipos sin responsiva...">
                    </div>
                    <div class="table-container">
                        <table class="table table-striped text-center" id="sinResponsivaTable">
                            <thead>
                                <tr>
                                    <th>Descripción</th>
                                    <th>Marca</th>
                                    <th>Modelo</th>
                                    <th>Serie</th>
                                    <th>Estado</th>
                                    <th>Fecha Alta</th>
                                    <th>Tipo</th>
                                    <th>Nombre</th>
                                    <th>PDF</th>
                                    <th>Cancelar</th>
                                    <th>Asignar</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                // Ejecutar la consulta para equipos sin responsiva
                                $resultSinResponsiva = $conn->query($sqlSinResponsiva);
                                if ($resultSinResponsiva->num_rows > 0) {
                                    while ($row = $resultSinResponsiva->fetch_assoc()) {
                                        echo "<tr>
                                                <td>" . htmlspecialchars($row['descripcion']) . "</td>
                                                <td>" . htmlspecialchars($row['marca']) . "</td>
                                                <td>" . htmlspecialchars($row['modelo']) . "</td>
                                                <td>" . htmlspecialchars($row['sn']) . "</td>
                                                <td>" . htmlspecialchars($row['estado']) . "</td>
                                                <td>" . htmlspecialchars($row['fechaAlta']) . "</td>
                                                <td>" . htmlspecialchars($row['tipo']) . "</td>
                                                <td>" 
                                                    . htmlspecialchars($row['nombre']) . " " 
                                                    . htmlspecialchars($row['paterno']) . "
                                                </td>

                                                
                                                <td>
                                                    <button  class='btn btn-danger pdf-btn' data-sn='" . $row['sn'] . "'>
                                                        <img src='../../../imagenes/iconoPdf.png' width='30' height='25'>

                                                    </button>
                                                </td>
                                                <td><button style='width:65px;' class='btn btn-danger'>X</button></td>
                                                <td>
                                                    <button class='btn btn-warning asignar-btn' 
                                                            data-id_equipo='" . $row["id"] . "' 
                                                            data-toggle='modal' 
                                                            data-target='#firmarResponsiva'>
                                                        Firmar
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
                <div class="tab-pane fade" id="conResponsiva" role="tabpanel">
                    <div class="search-wrapper">
                        <input type="text" id="searchConResponsiva" class="form-control" placeholder="Buscar equipos con responsiva...">
                    </div>
                    <div class="table-container">
                        <table class="table table-striped text-center" id="conResponsivaTable">
                            <thead>
                                <tr>
                                    <th>Descripción</th>
                                    <th>Marca</th>
                                    <th>Modelo</th>
                                    <th>Serie</th>
                                    <th>Estado</th>
                                    <th>Fecha Alta</th>
                                    <th>Tipo</th>
                                    <th>Nombre</th>
                                    <th>PDF</th>
                                    <th>Revocar</th>
                                    <th>Asignar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                // Ejecutar la consulta para equipos con responsiva
                                    $resultConResponsiva = $conn->query($sqlConResponsiva);
                                    if ($resultConResponsiva->num_rows > 0) {
                                        while ($row = $resultConResponsiva->fetch_assoc()) {
                                            echo "<tr>
                                                    <td>" . htmlspecialchars($row['descripcion']) . "</td>
                                                    <td>" . htmlspecialchars($row['marca']) . "</td>
                                                    <td>" . htmlspecialchars($row['modelo']) . "</td>
                                                    <td>" . htmlspecialchars($row['sn']) . "</td>
                                                    <td>" . htmlspecialchars($row['estado']) . "</td>
                                                    <td>" . htmlspecialchars($row['fechaAlta']) . "</td>
                                                    <td>" . htmlspecialchars($row['tipo']) . "</td>
                                                    <td>" 
                                                        . htmlspecialchars($row['nombre']) . " " 
                                                        . htmlspecialchars($row['paterno']) . "
                                                    </td>
                                                    <td>
                                                    <button class='btn btn-danger pdf-btn' data-sn='" . $row['sn'] . "'>
                                                        <img src='../../../imagenes/iconoPdf.png' width='30' height='25'>

                                                    </button>
                                                </td>
                                                    <td>
                                                        <button class='btn btn-danger delete-btn' data-id='" . $row['id'] . "'>
                                                            Revocar
                                                        </button>
                                                    </td>
                                                    <td>
                                                        <button class='btn btn-warning asignar-btn' 
                                                                data-id_equipo='" . $row["firmado"] . "' 
                                                                data-toggle='modal' 
                                                                data-target='#asignarModal'>
                                                            Asignar
                                                        </button>
                                                    </td>
                                                </tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='10'>No hay equipos con responsiva.</td></tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

