<?php
include('../banner.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control - Service Desk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>


<div class="container mt-5">
    <h1 class="text-center">Panel de Control</h1>
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Tickets creados</div> 
                        <div class="row mt-6">
                            <canvas id="ticketChart">                      
                            </canvas>
                            <p></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Tickets Cerrados</div>
                <div class="card-body">
                    <h3 class="text-center">45</h3>
                    <p class="text-center">Tickets resueltos</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Usuarios Registrados</div>
                <div class="card-body">
                    <h3 class="text-center">150</h3>
                    <p class="text-center">Usuarios en total</p>
                </div>
            </div>
        </div>
    </div>
    <h3 class="mt-4">Últimos Tickets</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Estado</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>#123</td>
                <td>Problema con acceso</td>
                <td><span class="badge bg-warning">Abierto</span></td>
                <td>01/03/2025</td>
            </tr>
            <tr>
                <td>#124</td>
                <td>Error en el sistema</td>
                <td><span class="badge bg-success">Cerrado</span></td>
                <td>28/02/2025</td>
            </tr>
        </tbody>
    </table>
</div>
<script>
    var ctx = document.getElementById('ticketChart').getContext('2d');
        var ticketChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Abiertos', 'Cerrados'],
                datasets: [{
                    data: [12, 150],
                    backgroundColor: ['#ffcc00', '#4caf50'],
                    hoverOffset: 4
                }]
            }
        });
</script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.0/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>
</body>
</html>
