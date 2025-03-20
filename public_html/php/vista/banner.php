<?php
session_start(); // Iniciar la sesión

// Verificar si el usuario está autenticado
if (!isset($_SESSION['id_rol'])) {
    // Redirigir a la página de inicio de sesión o mostrar un mensaje de error
    header("Location: ../../../logico/usuarios/login.php");
    exit();
}

// Obtener el id_roll y el nombre del usuario de la sesión
$id_roll = $_SESSION['id_rol'];
$nombreCompleto = $_SESSION['nombreCompleto']; // Asegúrate de que 'username' esté almacenado en la sesión
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SD PuntoActivo</title>
    <link rel="icon" type="image/x-icon" href="../../imagenes/icono_nav.jpg">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

    <!-- Barra de Navegación -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Soporte PA</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <?php if ($id_roll == 1): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/php/vista/tickets/tickets.php">Tickets</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/php/vista/usuarios.php">Usuarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/php/vista/equipo/altaEquipo.php">Equipo de computo</a>
                    </li>
                <?php endif; ?>

                <?php if ($id_roll == 2): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/public_html/php/vista/tickets/ticketscliente.php">Tickets de soporte</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/php/vista/usuarios/test.php" hidden>miUSuario</a>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                        <a class="nav-link" href="/php/vista/usuarios/miUSuario.php"><?php echo htmlspecialchars($nombreCompleto); ?><span class="sr-only">(actual)</span></a>
                </li>
            </ul>
            <form class="form-inline ml-auto" action="/php/logico/usuarios/logout.php" method="POST">
                <button class="btn btn-danger my-2 my-sm-0" type="submit">Cerrar sesión</button>
            </form>
        </div>
    </nav>
</body>
</html>