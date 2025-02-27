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
                    <!-- Campo para el Problema -->
                    <div class="form-group">
                        <label for="problema">Problema:</label>
                        <input type="text" class="form-control" id="problemaEdicion" name="problema" required>
                    </div>
                    <!-- Campo para la Descripción -->
                    <div class="form-group">
                        <label for="descripcion">Descripción:</label>
                        <textarea class="form-control" id="descripcionEdicion" name="descripcion" required></textarea>
                    </div>
                    <!-- Campo para las Pruebas -->
                    <div class="form-group">
                        <label for="pruebas">Pruebas:</label>
                        <textarea class="form-control" id="pruebasEdicion" name="pruebas" required rows="6"></textarea>
                    </div>
                    <!-- Campo oculto para el ID del ticket -->
                    <input type="text" id="idTicketEdicion" name="idTicketEdicion" hidden>
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </form>
            </div>
        </div>
    </div>
</div>
