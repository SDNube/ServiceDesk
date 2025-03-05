$(document).ready(function() {
    // Capturar el ID del equipo y nombre cuando se presiona el botón "Seleccionar"
    $('.seleccionar-btn').click(function() {
        var idEquipo = $(this).data('id_equipo');  // ID del equipo
        var idNombre = $(this).data('id_nombre');  // ID del nombre

        console.log('ID del equipo:', idEquipo);  // Para depuración
        console.log('ID del nombre:', idNombre);  // Para depuración

        // Enviar los datos a crearPdf.php con AJAX
        $.ajax({
            url: '../../logico/equipo/crearPdf.php',  // Ruta a tu archivo PHP
            method: 'POST',
            data: {
                id_equipo: idEquipo,
                id_nombre: idNombre
            },
            success: function(response) {
                // Mostrar la respuesta del servidor (si la hay)
                console.log('Respuesta de crearPdf.php:', response);
                
                // Aquí puedes procesar la respuesta o mostrarla en el HTML
                $('#resultado').html(response);  // Asume que tienes un div con id="resultado" para mostrar el resultado
            },
            error: function(xhr, status, error) {
                // Manejar errores si hay algún problema con la solicitud AJAX
                console.log('Error:', error);
            }
        });
    });
});
