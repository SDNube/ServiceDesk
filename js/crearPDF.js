$(document).ready(function() {
    $('.seleccionar-btn').click(function() {
        var idEquipo = $(this).data('id_equipo');  
        var idNombre = $(this).data('id_nombre');  

        console.log('ID del equipo:', idEquipo);  
        console.log('ID del nombre:', idNombre);  

        // Realizar la solicitud AJAX
        $.ajax({
            url: '../../logico/equipo/crearPdf.php',  // Ruta al archivo PHP
            type: 'GET',  // Usamos GET para enviar los datos
            data: {
                id_equipo: idEquipo,
                id_nombre: idNombre
            },
            success: function(response) {
                console.log('Respuesta del servidor:', response);
                // Verifica si la respuesta contiene un mensaje que indique que todo salió bien
                if (response.includes('✅ PDF generado y registros actualizados correctamente')) {
                    
                    window.location.href = "../../vista/equipo/altaEquipo.php";  // Redirigir después de éxito
                } else {
                    alert('Hubo un problema: ' + response);
                }
            },
            error: function(xhr, status, error) {
                console.log('Hubo un error:', error);
                alert('Error al hacer la solicitud AJAX: ' + error);
            }
        });
    });
});
