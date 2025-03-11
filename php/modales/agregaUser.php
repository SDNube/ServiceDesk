<?php include '../logico/conexion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Usuario</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<!-- Modal -->
<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Agregar Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="userForm" action="../logico/usuarios/addUser.php" method="POST">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="nombre">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="paterno">Apellido Paterno</label>
                            <input type="text" class="form-control" id="paterno" name="paterno" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="materno">Apellido Materno</label>
                            <input type="text" class="form-control" id="materno" name="materno" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="fechaNacimiento">Cumpleaños</label>
                            <input type="date" class="form-control" id="fechaNacimiento" name="fechaNacimiento" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="departamento">Departamento</label>
                            <select class="form-control" id="departamento" name="departamento" required>
                                <option></option>
                                <option value="Operaciones">Operaciones</option>
                                <option value="Administracion">Administracion</option>
                                <option value="Direccion">Direccion</option>
                                <option value="TI">TI</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="telefono">Teléfono</label>
                            <input type="text" class="form-control" id="telefono" name="telefono" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="correo">Correo</label>
                            <input type="email" class="form-control" id="correo" name="correo" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="password">Contraseña</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="id_rol">Rol</label>
                            <select class="form-control" id="id_rol" name="id_rol" required>
                                <option value=""></option>
                                <option value="1">Administrador</option>
                                <option value="2">Usuario</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Agregar Usuario</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Acción al enviar el formulario
    $("#userForm").submit(function(e) {
        e.preventDefault();  // Evita que el formulario se envíe inmediatamente

        var correo = $("#correo").val();  // Obtiene el correo ingresado

        // Realiza la validación AJAX para comprobar si el usuario existe
        $.ajax({
            url: "../logico/usuarios/validarUser.php",  // Ruta del archivo que verifica si el correo existe
            method: "POST",
            data: { correo: correo },
            dataType: "json",
            success: function(response) {
                if (response.exists) {
                    // Si el correo ya existe, muestra un mensaje de alerta
                    Swal.fire({
                        icon: 'error',
                        title: '¡Correo ya registrado!',
                        text: 'El correo ' + correo + ' ya está asociado a una cuenta.',
                    });
                } else {
                    // Si no existe, envía el formulario
                    $("#userForm")[0].submit();
                }
            }
        });
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
