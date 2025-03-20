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

<!-- Barra de navegación -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Service Desk</a>
</nav>

<div class="container mt-5">
    <h1 class="text-center">Dashboard - Service Desk</h1>
    
    <!-- Gráfico de Tickets Abiertos vs Cerrados -->
    <div class="row mt-5">
        <div class="col-md-6">
            <canvas id="ticketChart"></canvas>
        </div>
        <div class="col-md-6">
            <canvas id="userChart"></canvas>
        </div>
    </div>
    
    <!-- Estadísticas -->
    <div class="row mt-5">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Tickets Abiertos</div>
                <div class="card-body">
                    <h3 class="text-center">30</h3>
                    <p class="text-center">Pendientes por resolución</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Tickets Cerrados</div>
                <div class="card-body">
                    <h3 class="text-center">150</h3>
                    <p class="text-center">Resueltos</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Usuarios Activos</div>
                <div class="card-body">
                    <h3 class="text-center">120</h3>
                    <p class="text-center">Usuarios actualmente activos</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Gráfico de Tickets
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

    // Gráfico de Usuarios
    var ctx2 = document.getElementById('userChart').getContext('2d');
    var userChart = new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: ['Activos', 'Inactivos'],
            datasets: [{
                data: [120, 50],
                backgroundColor: ['#007bff', '#dc3545'],
                borderColor: ['#0056b3', '#c82333'],
                borderWidth: 1
            }]
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.0/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
