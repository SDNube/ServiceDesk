$(document).ready(function() {
    var idEquipo;  // Variable global para almacenar el id_equipo

    // Capturar el ID del equipo cuando se presiona el botón "Asignar"
    $('.asignar-btn').click(function() {
        idEquipo = $(this).data('id_equipo');  // ID del equipo
        console.log('ID del equipo:', idEquipo); // Verifica en consola si se está obteniendo correctamente
    });

    
    // Búsqueda en tiempo real en la base de datos
    $('#busquedaUsuario').keyup(function() {
        var query = $(this).val();  // Obtener el valor de búsqueda
        
        console.log('id_equipo:', idEquipo); // Verificar si se está enviando correctamente
    
        if (query.length > 1 && idEquipo) {  // Solo hacer la búsqueda si hay más de 1 carácter y el id_equipo está definido
            console.log('query:', query);
            console.log('idEquipo:', idEquipo);  // Verifica que este valor esté correctamente asignado

            $.ajax({
                url: '../../logico/equipo/buscarUsuarios.php',
                method: 'POST',
                data: { 
                    query: query,
                    idEquipo: idEquipo // Usamos el mismo nombre en ambos lugares
                },
                success: function(data) {
                    $('#resultadoBusqueda').html(data);  // Mostrar los resultados de la búsqueda
                }
            });
        } else {
            $('#resultadoBusqueda').html('');  // Limpiar resultados si la búsqueda es demasiado corta
        }
    });
});
