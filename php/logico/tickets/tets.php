<script>
        function abrirModalComentarios(idTicket) {
            $('#idTicket').val(idTicket);
            $('#modalComenrtarios').modal('show');
        }

        $(document).on('click', '#btnCancelarTicket', function() {
            var motivoCancelacion = $('#motivoCancelacion').val().trim();
            var idTicket = $('#idTicketCancelar').val().trim();
            var idUsuario = <?php echo $_SESSION['id']; ?>;
            var idMovimiento = 6;

            if (!motivoCancelacion) {
                alert("Por favor, escribe un motivo para la cancelación.");
                return;
            }

            $.ajax({
                url: '../../logico/tickets/cancelarTicket.php',
                type: 'POST',
                data: {
                    motivoCancelacion: motivoCancelacion,
                    idTicket: idTicket,
                    idUsuario: idUsuario,
                    idMovimiento: idMovimiento
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        alert("Ticket cancelado correctamente.");
                        $('#modalCancelacion').modal('hide');
                        location.reload();
                    } else {
                        alert("Error: " + response.message);
                    }
                },
                error: function(xhr) {
                    console.error("Error en AJAX:", xhr.responseText);
                    window.location.href = "ticketscliente.php";  
                }
            });
        });
    </script>