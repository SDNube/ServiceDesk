<div class="modal fade" id="ticketSistemaPlataforma" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ticket Plataforma</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="../../logico/tickets/agregarTicket.php" method="POST" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="col-8">
                            <label for="problema">Problema:</label>
                            <input type="text" class="form-control" id="problema" name="problema" required>
                        </div>
                        <div class="col-4">
                            <label for="idCliente">ID de Cliente:</label>
                            <input type="number" class="form-control" id="idCliente" name="idCliente" required>
                        </div>
                    </div>
                    <div class="form-row mt-3">
                        <div class="col">
                            <label for="cpOrigen">Código Postal de Origen:</label>
                            <input type="number" class="form-control" id="cpOrigen" name="cpOrigen" required>
                        </div>
                        <div class="col">
                            <label for="cpDestino">Código Postal de Destino:</label>
                            <input type="number" class="form-control" id="cpDestino" name="cpDestino" required>
                        </div>
                    </div>
                    <div class="form-row mt-3">
                        <div class="col">
                            <label for="largo">Largo (cm):</label>
                            <input type="number" class="form-control" id="largo" name="largo" required>
                        </div>
                        <div class="col">
                            <label for="alto">Alto (cm):</label>
                            <input type="number" class="form-control" id="alto" name="alto" required>
                        </div>
                        <div class="col">
                            <label for="ancho">Ancho (cm):</label>
                            <input type="number" class="form-control" id="ancho" name="ancho" required>
                        </div>
                        <div class="col">
                            <label for="peso">Peso (kg):</label>
                            <input type="number" class="form-control" id="peso" name="peso" required>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <label for="descripcion">Descripción del problema:</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="4" required></textarea>
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
                    <input type="hidden" name="modalOrigin" value="Plataforma"> 
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("paste", function(event) {
    let items = (event.clipboardData || event.originalEvent.clipboardData).items;
    for (let index in items) {
        let item = items[index];
        if (item.kind === 'file') { 
            let blob = item.getAsFile();
            let reader = new FileReader();
            reader.onload = function(event) {
                // Actualizamos el contenido del área con la imagen y el botón de eliminar
                document.getElementById("drop-area").innerHTML = '<img src="' + event.target.result + '" class="img-fluid">';

                // Asegurarnos de que el botón de eliminar se inserte y sea visible
                const removeButton = document.getElementById("removeImage");
                if (removeButton) {
                    removeButton.style.display = 'block';
                } else {
                    const newRemoveButton = document.createElement('button');
                    newRemoveButton.type = 'button';
                    newRemoveButton.id = 'removeImage';
                    newRemoveButton.className = 'btn btn-danger';
                    newRemoveButton.style.position = 'absolute';
                    newRemoveButton.style.top = '5px';
                    newRemoveButton.style.right = '5px';
                    newRemoveButton.textContent = 'X';
                    newRemoveButton.addEventListener("click", function() {
                        // Eliminar la imagen y el botón
                        document.getElementById("drop-area").innerHTML = '<img src="../../../imagenes/add.png" alt="" width="20" height="20">';
                        document.getElementById("imagenPegada").value = '';
                        newRemoveButton.style.display = 'none';
                    });
                    document.getElementById("drop-area").appendChild(newRemoveButton);
                }

                // Establecer la imagen pegada en el campo oculto
                document.getElementById("imagenPegada").value = event.target.result;
            };
            reader.readAsDataURL(blob);
        }
    }
});

// Inicializar el tooltip de Bootstrap
$(function () {
  $('[data-toggle="tooltip"]').tooltip();
});
</script>
