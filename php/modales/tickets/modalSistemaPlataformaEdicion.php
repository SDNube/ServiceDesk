<div class="modal fade" id="modalSistemaPlataformaEdicion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ticket Plataforma</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="../../logico/tickets/editarTicket.php" method="POST" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="col-8">
                            <label for="problema">Problema:</label>
                            <input type="text" class="form-control" id="problemaEdicionPlataforma" name="problema" required>
                        </div>
                        <div class="col-4">
                            <label for="idCliente">ID de Cliente:</label>
                            <input type="number" class="form-control" id="idClientePlataforma" name="idCliente" required>
                        </div>
                    </div>
                    <div class="form-row mt-3">
                        <div class="col">
                            <label for="cpOrigen">Código Postal de Origen:</label>
                            <input type="number" class="form-control" id="cpOrigenPlataforma" name="cpOrigen" required>
                        </div>
                        <div class="col">
                            <label for="cpDestino">Código Postal de Destino:</label>
                            <input type="number" class="form-control" id="cpDestinoPlataforma" name="cpDestino" required>
                        </div>
                    </div>
                    <div class="form-row mt-3">
                        <div class="col">
                            <label for="largo">Largo (cm):</label>
                            <input type="number" class="form-control" id="largoPlataforma" name="largo" required>
                        </div>
                        <div class="col">
                            <label for="alto">Alto (cm):</label>
                            <input type="number" class="form-control" id="altoPlataforma" name="alto" required>
                        </div>
                        <div class="col">
                            <label for="ancho">Ancho (cm):</label>
                            <input type="number" class="form-control" id="anchoPlataforma" name="ancho" required>
                        </div>
                        <div class="col">
                            <label for="peso">Peso (kg):</label>
                            <input type="number" class="form-control" id="pesoPlataforma" name="peso" required>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <label for="descripcion">Descripción del problema:</label>
                        <textarea class="form-control" id="descripcionEdicionPlataforma" name="descripcion" rows="4" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Da click y 'ctrl + v' para agregar una captura de pantalla</label>
                        <div id="drop-area" class="border p-3 text-center" style="position: relative;">
                            <img src="../../../imagenes/add.png" alt="" width="20" height="20">
                            <!-- Aquí va el botón de eliminar que está inicialmente oculto -->
                            <button type="button" id="removeImage" class="btn btn-danger" style="display: none; position: absolute; top: 5px; right: 5px;">X</button>
                        </div>
                        <input type="hidden" name="imagenPegada" id="imagenPegada">
                    </div>
                    <input type="text" id="idTicketEdicionPlataforma" name="idTicketEdicion" hidden>
                    <input type="hidden" name="modalOrigin" value="Plataforma"> 
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </form>
            </div>
        </div>
    </div>
</div>
