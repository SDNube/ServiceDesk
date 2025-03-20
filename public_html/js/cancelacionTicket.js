function abrirModalCancelacion(idTicket) {
    $('#idTicketCancelar').val(idTicket);
    $('#modalCancelacion').modal('show');
}


$(document).on('click', '#btnCancelarTicket', function() {
    var motivoCancelacion = $('#motivoCancelacion').val().trim();
    var idTicket = $('#idTicketCancelar').val().trim();
    var idMovimiento = 6;

    if (!motivoCancelacion) {
        alert("Por favor, escribe un motivo para la cancelación.");
        return;
    }

    console.log("Enviando AJAX con los siguientes datos:");
    console.log("Motivo: " + motivoCancelacion);
    console.log("ID Ticket: " + idTicket);

    $.ajax({
        url: '../../logico/tickets/cancelarTicket.php',  // Asegúrate de que la ruta sea correcta
        type: 'POST',
        data: {
            motivoCancelacion: motivoCancelacion,
            idTicket: idTicket,
            idMovimiento: idMovimiento
        },
        dataType: 'json',
        success: function(response) {
            console.log("Respuesta AJAX: ", response);
            if (response.status === 'success') {
                $('#modalCancelacion').modal('hide');
                location.reload();
            } else {
                alert("Error: " + response.message);
            }
        },
        error: function(xhr) {
            console.error("Error en AJAX:", xhr.responseText);
            alert("Error en la solicitud. Por favor, intenta de nuevo.");
        }
        
    });
});
