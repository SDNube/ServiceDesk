function abrirModalVerTicket(idTicket, path) {
    console.log('Se ha llamado a abrirModalVerTicket con idTicket:', idTicket, 'y path:', path);

    if (!idTicket || !path) {
        console.error('Faltan los parámetros idTicket o path.');
        alert('Faltan los parámetros idTicket o path.');
        return;
    }

    $.ajax(
        {
        url: '../../logico/tickets/obtenerTicket.php',
        type: 'GET',
        data: {idTicket: idTicket, path: path},
        dataType: 'json',
        success: function(response) {
            console.log('Respuesta recibida de obtenerTicket.php:', response);
            
            // Verificar que la respuesta es un objeto y tiene las propiedades esperadas
            if (!response || typeof response !== 'object') {
                console.error('La respuesta no es un objeto o está vacía');
                alert("La respuesta del servidor no es válida.");
                return;
            }
        
            if (response.error) {
                console.error('Error al obtener los datos del ticket:', response.error);
                alert("Hubo un error al obtener los datos del ticket: " + response.error);
                console.log('✅ Respuesta recibida de obtenerTicket.php:', response);
            } else {
                if (path == "Computadora") {
                    $('#problemaEdicion').val(response.problema);
                    $('#descripcionEdicion').val(response.descripcion_corta);
                    $('#pruebasEdicion').val(response.pruebas);
                    $('#idTicketEdicion').val(idTicket);
                    $('#modalTiComputadoraEdicion').modal('show');
                } else if (path == "Plataforma") {
                    // Verifica que los datos estén presentes antes de usarlos
                    console.log('Largo:', response.largo, 'Alto:', response.peso, 'Peso:', response.alto, 'Ancho:', response.ancho, 'ID Cliente:', response.id_cliente);
                    console.log('CP Origen:', response.cp_origen, 'CP Destino:', response.cp_destino);
        
                    // Asegúrate de que las propiedades sean válidas
                    $('#largoPlataforma').val(response.largo || '0');
                    $('#altoPlataforma').val(response.alto || '0');
                    $('#anchoPlataforma').val(response.ancho || '0');
                    $('#pesoPlataforma').val(response.peso || '666');
                    $('#idClientePlataforma').val(response.id_cliente || '0');
                    $('#cpDestinoPlataforma').val(response.cp_destino || '0');
                    $('#cpOrigenPlataforma').val(response.cp_origen || '0');
                    $('#problemaEdicionPlataforma').val(response.problema);
                    $('#descripcionEdicionPlataforma').val(response.descripcion_corta);
                    $('#pruebasEdicionPlataforma').val(response.pruebas);
                    $('#idTicketEdicionPlataforma').val(idTicket);
                    $('#modalSistemaPlataformaEdicion').modal('show');
                }
            }
        },
        error: function(xhr, status, error) {
            console.error('Error al hacer la solicitud AJAX:', error);
            console.log('Respuesta del servidor:', xhr.responseText); // Muestra el contenido de la respuesta
            console.log('Código de estado:', xhr.status); // Código de estado HTTP
            alert("Error al cargar los datos del ticket.");
        }
    });
}
