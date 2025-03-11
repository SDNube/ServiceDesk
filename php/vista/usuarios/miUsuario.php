<?php
    include('../banner.php');
    include ('../../modales/usuarios/miUser.php');
    include ('../../modales/usuarios/miGrupo.php');
    include ('../../modales/usuarios/miAsignado.php');
    include ('../../modales/usuarios/miCumpleanos.php');

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../css/panelUser.css">
    
</head>
<body>

<div class="container-fluid panel-container">
    
        <div>
            <h1>Mi usuario</h1>
        </div>
        <div class="row">
        
        <div class="col-md-4 mb-4">
            <div class="card" data-toggle="modal" data-target="#modal1">
                <div class="card-body">
                    <h5 class="card-title">Datos de usuario</h5>
                    <p class="card-text">Descripción de la tarjeta 1.</p>
                </div>
                <div class="card-footer">
                    <small>Ver mi informacion</small>
                </div>
            </div>
        </div>

        <!-- Tarjeta 2 -->
        <div class="col-md-4 mb-4">
            <div class="card" data-toggle="modal" data-target="#modal2">
                <div class="card-body">
                    <h5 class="card-title">Mi grupo de trabajo</h5>
                    <p class="card-text">Selecciona quien ve tus tickets</p>
                </div>
                <div class="card-footer">
                    <small>Ver grupo</small>
                </div>
            </div>
        </div>

        <!-- Tarjeta 3 -->
        <div class="col-md-4 mb-4">
            <div class="card" data-toggle="modal" data-target="#modal3">
                <div class="card-body">
                    <h5 class="card-title">Equipo asignado</h5>
                    <p class="card-text">Ve que materiales tienes</p>
                </div>
                <div class="card-footer">
                    <small>Ver mis asignados</small>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Tarjeta 4 -->
        <div class="col-md-4 mb-4">
            <div class="card" data-toggle="modal" data-target="#modal4">
                <div class="card-body">
                    <h5 class="card-title">Cumpleañeros</h5>
                    <p class="card-text">Ve quien festeja este mes</p>
                </div>
                <div class="card-footer">
                    <small>Ver Cumpleañeros</small>
                </div>
            </div>
        </div>

        <!-- Tarjeta 5 -->
        <div class="col-md-4 mb-4">
            <div class="card" data-toggle="modal" data-target="#modal5">
                <div class="card-body">
                    <h5 class="card-title">Mis tickets</h5>
                    <p class="card-text">Revisa con graficas tus tickets</p>
                </div>
                <div class="card-footer">
                    <small>Ver Graficas</small>
                </div>
            </div>
        </div>

        <!-- Tarjeta 6 -->
        <div class="col-md-4 mb-4">
            <div class="card" data-toggle="modal" data-target="#modal6">
                <div class="card-body">
                    <h5 class="card-title">Avisos</h5>
                    <p class="card-text">Enterate de lo que esta pasando</p>
                </div>
                <div class="card-footer">
                    <small>Ver Avisos</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal 1 -->


<!-- Modal 2 -->


<!-- Modal 3 -->


<!-- Modal 4 -->


<!-- Modal 5 -->
<div class="modal fade" id="modal5" tabindex="-1" role="dialog" aria-labelledby="modalLabel5" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel5">Modal 5</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Contenido de la Modal 5.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal 6 -->
<div class="modal fade" id="modal6" tabindex="-1" role="dialog" aria-labelledby="modalLabel6" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel6">Modal 6</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Contenido de la Modal 6.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
