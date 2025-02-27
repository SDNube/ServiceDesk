<div class="modal fade" id="ticketSolicitudEquipo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ticket Solicitud Equipo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="../../logico/tickets/agregarTicket.php" method="POST">
                    <!-- Campo de selección de categoría -->
                    <div class="form-group">
                        <label for="categoria">Selecciona una categoría:</label>
                        <select class="form-control" id="categoria" name="categoria" onchange="mostrarFormulario()">
                            <option value="">Selecciona...</option>
                            <option value="accesorios">Accesorios</option>
                            <option value="equipo">Equipo de computo</option>
                            <option value="correo">Correo</option>
                        </select>
                    </div>

                    <!-- Formulario para accesorios -->
                    <div id="form-accesorios" class="form-group" style="display: none;">
                        <select class="form-control" id="categoriaAccesorio" name="categoriaAccesorio" required>
                            <option value=""></option>
                            <option value="accesorios">Mouse</option>
                            <option value="equipo">Teclado</option>
                            <option value="correo">Pad</option>
                            <option value="correo">Case para celular</option>
                        </select>
                        <p></p>
                        <textarea class="form-control" name="descripcionAccesorio" id="descripcionAccesorio">Ingrese algún mesnaje</textarea>
                        
                    </div>

                    <!-- Formulario para equipo de cómputo -->
                    <div id="form-equipo" class="form-group" style="display: none;">
                        <label for="descripcion-equipo">Descripción del problema con el equipo de cómputo:</label>
                        <textarea class="form-control" id="descripcion-equipo" name="descripcion-equipo" placeholder="Descripción del problema con el equipo de cómputo" required></textarea>
                    </div>

                    <!-- Formulario para correo -->
                    <div id="form-correo" class="form-group" style="display: none;">
                        <label for="descripcion-correo">Descripción del problema con el correo:</label>
                        <input type="text" class="form-control" placeholder="Ingresa el nombre(s)">
                        <label for="">Nombre(s)</label>
                        <input type="text" class="form-control" placeholder="Ingresa los apellidos">
                        <label for="">Apellidos</label>
                        <p></p>
                        <textarea class="form-control" id="descripcion-correo" name="descripcion-correo" placeholder="Ingregse un mensjae" required></textarea>
                    </div>

                    
                    

                    <!-- Campo oculto para el origen del modal -->
                    <input type="hidden" name="modalOrigin" value="Solicitud"> <!-- Campo oculto con el origen del modal -->
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Función para mostrar el formulario correspondiente según la categoría seleccionada
function mostrarFormulario() {
    var categoria = document.getElementById("categoria").value;

    // Ocultar todos los formularios
    document.getElementById("form-accesorios").style.display = "none";
    document.getElementById("form-equipo").style.display = "none";
    document.getElementById("form-correo").style.display = "none";

    // Mostrar el formulario correspondiente
    if (categoria == "accesorios") {
        document.getElementById("form-accesorios").style.display = "block";
    } else if (categoria == "equipo") {
        document.getElementById("form-equipo").style.display = "block";
    } else if (categoria == "correo") {
        document.getElementById("form-correo").style.display = "block";
    }
}
</script>
