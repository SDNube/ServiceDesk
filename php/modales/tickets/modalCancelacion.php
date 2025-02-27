<!-- Modal para Cancelación de Ticket -->
<div class="modal fade" id="modalCancelacion" tabindex="-1" role="dialog" aria-labelledby="modalCancelacionLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCancelacionLabel">Cancelar Ticket</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formCancelarTicket">
                    <div class="form-group">
                        <label for="motivoCancelacion">Motivo de Cancelación:</label>
                        <textarea id="motivoCancelacion" class="form-control" rows="3" required></textarea>
                    </div>
                    <input type="hidden" id="idTicketCancelar">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-danger" id="btnCancelarTicket">Cancelar Ticket</button>
            </div>
        </div>
    </div>
</div>
