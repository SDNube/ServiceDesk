<div class="modal fade" id="ticketTiComputadora" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ticket Computadora</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form action="../../logico/tickets/agregarTicket.php" method="POST">
                    <!-- Campo para el Problema -->
                    <div class="form-group">
                        <label for="problema">Problema:</label>
                        <input type="text" class="form-control" id="problema" name="problema" placeholder="¿Cuál es el problema?" required >
                    </div>
                    <!-- Campo para la Descripción -->
                    <div class="form-group">
                        <label for="descripcion">Descripción:</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" placeholder="Descripción detallada del problema" required ></textarea>
                    </div>
                    <!-- Campo para las Pruebas -->
                    <div class="form-group">
                        <label for="pruebas">Pruebas:</label>
                        <textarea class="form-control" id="pruebas" name="pruebas" placeholder="Pruebas realizadas para diagnosticar el problema" required rows="6" ></textarea>
                    </div>
                    <!-- Botón de Enviar (solo para ver los datos, no para enviar) -->
                    <input type="hidden" name="modalOrigin" value="Computadora"> 
                    <button type="submit" class="btn btn-primary" >Enviar</button>
                </form>
            </div>
        </div>
    </div>
</div>
