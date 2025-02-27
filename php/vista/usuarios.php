<?php 
include '../logico/conexion.php'; 

// Verifica si hay datos en POST
$abrirModal = !empty($_POST);
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
    <?php include '../vista/banner.php'; ?>

    <div class="container-fluid mt-4">
        <h1>USUARIOS</h1>
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#userModal">
            Agregar Usuario
        </button>
        <p></p>
        <div class="table-responsive">
            <table class="table table-striped text-center w-100">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellido Paterno</th>
                        <th>Apellido Materno</th>
                        <th>Cumpleaños</th>
                        <th>Departamento</th>
                        <th>Teléfono</th>
                        <th>Correo</th>
                        <th>Usuario</th>
                        <th>Reset Password</th>
                        <th>Cambiar Rol</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    // Verificar si hay resultados
                    if ($result->num_rows > 0) {
                        // Salida de cada fila
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . htmlspecialchars($row['nombre']) . "</td>
                                    <td>" . htmlspecialchars($row['paterno']) . "</td>
                                    <td>" . htmlspecialchars($row['materno']) . "</td>
                                    <td>" . htmlspecialchars($row['cumpleanos']) . "</td>
                                    <td>" . htmlspecialchars($row['departamento']) . "</td>
                                    <td>" . htmlspecialchars($row['telefono']) . "</td>
                                    <td>" . htmlspecialchars($row['correo']) . "</td>
                                    <td>" . htmlspecialchars($row['usuario']) . "</td>
                                    <td>
                                        <button class='btn btn-warning reset-btn' data-correo='" . htmlspecialchars($row['correo']) . "'>
                                            Reset
                                        </button>
                                    </td>
                                    <td>
                                        <button class='btn btn-info rol-btn' data-correo='" . htmlspecialchars($row['correo']) . "'>
                                            Cambiar
                                        </button>
                                    </td> 
                                    <td><button class='btn btn-primary'>Editar</button></td>
                                    <td>
                                        <button class='btn btn-danger delete-btn' data-correo='" . htmlspecialchars($row['correo']) . "'>
                                            Eliminar
                                        </button>
                                    </td>   
                                </tr>";

                        }
                    } else {
                        echo "<tr><td colspan='12'>No hay usuarios registrados </td></tr>";
                    }
                    // Cerrar la conexión
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include '../modales/agregaUser.php'; ?>

    <script>
        $(document).ready(function() {
            console.log("jQuery cargado correctamente.");

            if ($('#userModal').length) {
                console.log("Modal encontrado en el DOM.");
            } else {
                console.log("ERROR: Modal NO encontrado en el DOM.");
            }

            // Abre la modal si la página fue recargada con datos en POST
            <?php if ($abrirModal): ?>
                console.log("Página recargada desde un POST. Abriendo modal...");
                $('#userModal').modal('show');
            <?php endif; ?>

            // Abre la modal cuando se hace clic en el botón
            $('.btn-success').click(function() {
                console.log("Botón de agregar usuario clickeado.");
                $('#userModal').modal('show');
            });
        });
    </script>

</body>
</html>

<script>
    $(document).ready(function() {
        // Captura el evento click en los botones con la clase .reset-btn
        $('.reset-btn').click(function() {
            // Obtén el correo almacenado en el atributo data-correo del botón
            var correo = $(this).data('correo');

            // Realiza una solicitud AJAX para enviar el correo al servidor
            $.ajax({
                url: '../logico/usuarios/resetUser.php', // Ruta al archivo PHP donde procesarás la solicitud
                method: 'POST',
                data: { correo: correo }, // Enviar el correo a través de POST
                success: function(response) {
                    // Puedes mostrar una alerta de éxito o manejar la respuesta
                    alert('Correo enviado correctamente: ' + response);
                },
                error: function() {
                    // Manejo de errores si la solicitud falla
                    alert('Hubo un problema al enviar la solicitud.');
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function() {
        // Captura el evento click en los botones con la clase .reset-btn
        $('.rol-btn').click(function() {
            // Obtén el correo almacenado en el atributo data-correo del botón
            var correo = $(this).data('correo');

            // Realiza una solicitud AJAX para enviar el correo al servidor
            $.ajax({
                url: '../logico/usuarios/cambiarRolUser.php', // Ruta al archivo PHP donde procesarás la solicitud
                method: 'POST',
                data: { correo: correo }, // Enviar el correo a través de POST
                success: function(response) {
                    // Puedes mostrar una alerta de éxito o manejar la respuesta
                    alert('Correo enviado correctamente: ' + response);
                },
                error: function() {
                    // Manejo de errores si la solicitud falla
                    alert('Hubo un problema al enviar la solicitud.');
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function()
    {
        // Captura el evento click en los botones con la clase .delete-btn
        $('.delete-btn').click(function() {
            // Obtén el correo almacenado en el atributo data-correo del botón
            var correo = $(this).data('correo');

            // Muestra un mensaje de confirmación
            var confirmacion = confirm("¿Está seguro de que desea eliminar este usuario?");

            if (confirmacion) {
                // Si el usuario acepta, realiza la solicitud AJAX para eliminar al usuario
                $.ajax({
                    url: '../logico/usuarios/deleteUser.php', // Ruta al archivo PHP donde procesarás la solicitud
                    method: 'POST',
                    data: { correo: correo }, // Enviar el correo a través de POST
                    success: function(response) {
                        // Muestra una alerta de éxito
                        alert('Usuario eliminado correctamente.');

                        // Recarga la página después de eliminar al usuario
                        location.reload();  // Esto recarga la página actual
                    },
                    error: function() {
                        // Manejo de errores si la solicitud falla
                        alert('Hubo un problema al eliminar al usuario.');
                    }
                });
            } 
        });
    });

</script>

