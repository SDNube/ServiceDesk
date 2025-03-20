<!-- Modal Computadora -->
<div class="modal fade" id="modalTiComputadoraEdicion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Ticket Computadora</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="../../logico/tickets/editarTicket.php" method="POST">
                    <div class="form-group">
                        <label for="problema">Problema:</label>
                        <input type="text" class="form-control" id="problemaEdicion" name="problema" required>
                    </div>
                    <div class="form-group">
                        <label for="descripcion">Descripción:</label>
                        <textarea class="form-control" id="descripcionEdicion" name="descripcion" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="pruebas">Pruebas:</label>
                        <textarea class="form-control" id="pruebasEdicion" name="pruebas" required rows="6"></textarea>
                    </div>
                    <input type="text" id="idTicketEdicion" name="idTicketEdicion" hidden>
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert2 -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.4/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.4/dist/sweetalert2.all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

<script>
    document.querySelectorAll('.modalEdicionComputadora form').forEach((form) => {
        form.addEventListener('submit', function (e) {
            e.preventDefault(); // Prevenir el envío normal del formulario
            var formData = new FormData(this); // Crear un objeto FormData con los datos del formulario

            fetch('../../logico/tickets/editarTicket.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json()) // Convertir la respuesta a JSON
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: data.message
                    }).then(() => {
                        // Cerrar la modal
                        $(this.closest('.modal')).modal('hide');
                        
                        // Aquí puedes actualizar la vista del ticket en la modal si es necesario
                        const ticketInfo = data.ticket; // Aquí obtienes el ticket actualizado de la respuesta
                        document.querySelector('#problemaEdicion').value = ticketInfo.problema;
                        document.querySelector('#descripcionEdicion').value = ticketInfo.descripcion;
                        // Otros campos según sea necesario
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: '¡Error!',
                        text: data.message
                    });
                }
            })
            .catch(error => {
                console.error('Error al enviar la solicitud:', error);
                Swal.fire({
                    icon: 'error',
                    title: '¡Error!',
                    text: 'Hubo un problema al procesar la solicitud.'
                });
            });
        });
    });
</script>
