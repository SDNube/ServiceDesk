// Función para abrir la modal y cargar comentarios
function abrirModalComentarios(idTicket) {
    console.log("ID del Ticket enviado: " + idTicket);

    // Verificar si el modal existe en el DOM
    if (!$('#modalComentarios').length) {
        console.error("El modal con ID 'modalComentarios' no existe en el DOM.");
        return;
    }

    // Mostrar un mensaje de carga mientras se obtiene la respuesta
    $('.modal-body').html('<p>Cargando comentarios...</p>');

    // Enviar la petición AJAX
    $.ajax({
        url: '../../../php/modales/tickets/modalComentarios.php',
        method: 'POST',
        data: { idTicket: idTicket },
        success: function(response) {
            console.log("Respuesta del servidor: ", response);

            // Limpiar el contenido de la modal antes de insertar nuevos datos
            $('.modal-body').empty().html(response);

            // Mostrar la modal
            $('#modalComentarios').modal('show');
        },
        error: function(xhr, status, error) {
            console.error("Error al cargar los comentarios:", error);
            $('.modal-body').html('<p>Error al cargar los comentarios.</p>');
        }
    });
}

// Función para refrescar los comentarios automáticamente
function refrescarComentarios(idTicket) {
    setInterval(function() {
        abrirModalComentarios(idTicket);
    }, 5000); // Refresca cada 5 segundos
}

// Llamar a la función para abrir la modal y refrescar comentarios
$(document).ready(function() {
    const idTicket = 55; // ID del ticket a cargar (puedes cambiarlo según sea necesario)
    abrirModalComentarios(idTicket);
    refrescarComentarios(idTicket);
});