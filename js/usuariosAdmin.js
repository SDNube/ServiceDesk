$(document).ready(function() 
{
    // Script para filtrar la tabla
    $('#searchInput').on('keyup', function() {
        var value = $(this).val().toLowerCase();
        var column = $('#filterSelect').val(); // Obtener la columna seleccionada

        // Asegurarse de que el filtro solo se aplique a las filas dentro de <tbody>
        $('#userTable tbody tr').filter(function() {
            $(this).toggle($(this).find("td[data-column='" + column + "']").text().toLowerCase().indexOf(value) > -1);
        });
    });

    // Verifica si el modal está presente y se abre si es necesario
    console.log("jQuery cargado correctamente.");
    if ($('#userModal').length) {
        console.log("Modal encontrado en el DOM.");
    } else {
        console.log("ERROR: Modal NO encontrado en el DOM.");
    }

    // Abre la modal si la página fue recargada con datos en POST
    

    // Abre la modal cuando se hace clic en el botón de agregar usuario
    $('.btn-success').click(function() {
        console.log("Botón de agregar usuario clickeado.");
        $('#userModal').modal('show');
    });

    // Función para resetear contraseña
    $('.reset-btn').click(function() {
        var correo = $(this).data('correo');
        $.ajax({
            url: '../logico/usuarios/resetUser.php', 
            method: 'POST',
            data: { correo: correo },
            success: function(response) {
                alert('Correo enviado correctamente: ' + response);
            },
            error: function() {
                alert('Hubo un problema al enviar la solicitud.');
            }
        });
    });

    // Función para cambiar el rol
    $('.rol-btn').click(function() {
        var correo = $(this).data('correo');
        $.ajax({
            url: '../logico/usuarios/cambiarRolUser.php',
            method: 'POST',
            data: { correo: correo },
            success: function(response) {
                alert('Correo enviado correctamente: ' + response);
            },
            error: function() {
                alert('Hubo un problema al enviar la solicitud.');
            }
        });
    });

    // Función para eliminar usuario
    $('.delete-btn').click(function() {
        var correo = $(this).data('correo');
        var confirmacion = confirm("¿Está seguro de que desea eliminar este usuario?");
        
        if (confirmacion) {
            $.ajax({
                url: '../logico/usuarios/deleteUser.php', 
                method: 'POST',
                data: { correo: correo },
                success: function(response) {
                    alert('Usuario eliminado correctamente.');
                    location.reload(); // Recargar la página
                },
                error: function() {
                    alert('Hubo un problema al eliminar al usuario.');
                }
            });
        }
    });
});
