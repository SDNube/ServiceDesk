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
                <form action="../../logico/tickets/agregarTicket.php" method="POST" onsubmit="unirCampos()">
                    <!-- Campo de selección de categoría -->
                    <div class="form-group">
                        <label for="problema">Selecciona una categoría:</label>
                        <select class="form-control" id="problema" name="problema" onchange="mostrarFormulario()">
                            <option value="">Selecciona...</option>
                            <option value="Accesorios">Accesorios</option>
                            <option value="Equipo">Equipo de cómputo</option>
                            <option value="Correo">Correo</option>
                        </select>
                    </div>

                    <!-- Formulario para accesorios -->
                    <div id="form-accesorios" class="form-group" style="display: none;">
                        <label for="problemaAccesorio">Selecciona el accesorio:</label>
                        <select class="form-control" id="problemaAccesorio">
                            <option value="Mouse">Mouse</option>
                            <option value="Teclado">Teclado</option>
                            <option value="Pad">Pad</option>
                            <option value="Case para celular">Case para celular</option>
                        </select>
                    </div>

                    <!-- Formulario para equipo de cómputo -->
                    <div id="form-equipo" class="form-group" style="display: none;">
                        <label for="descripcion-equipo">Descripción del problema con el equipo de cómputo:</label>
                        <textarea class="form-control" id="descripcion-equipo" placeholder="Describe el problema"></textarea>
                    </div>

                    <!-- Formulario para correo -->
                    <div id="form-correo" class="form-group" style="display: none;">
                        <label for="nombre">Nombre(s):</label>
                        <input type="text" class="form-control" id="nombre" placeholder="Ingresa el nombre(s)">
                        <label for="apellido">Apellidos:</label>
                        <input type="text" class="form-control" id="apellido" placeholder="Ingresa los apellidos">
                    </div>

                    <!-- Campo oculto con toda la descripción estructurada -->
                    <input type="hidden" name="descripcion" id="descripcion">

                    <!-- Campo oculto para el origen del modal -->
                    <input type="hidden" name="modalOrigin" value="Solicitud">

                    <button type="submit" class="btn btn-primary">Enviar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function mostrarFormulario() {
    var problema = document.getElementById("problema").value;

    // Ocultar todos los formularios
    document.getElementById("form-accesorios").style.display = "none";
    document.getElementById("form-equipo").style.display = "none";
    document.getElementById("form-correo").style.display = "none";

    // Mostrar solo el formulario seleccionado
    if (problema === "Accesorios") {
        document.getElementById("form-accesorios").style.display = "block";
    } else if (problema === "Equipo") {
        document.getElementById("form-equipo").style.display = "block";
    } else if (problema === "Correo") {
        document.getElementById("form-correo").style.display = "block";
    }
}

function unirCampos() {
    var problema = document.getElementById("problema").value;
    var descripcion = "";

    if (problema === "Accesorios") {
        var accesorio = document.getElementById("problemaAccesorio").value;
        descripcion += "Accesorio: " + accesorio + "\n";
    } else if (problema === "Equipo") {
        var equipoDesc = document.getElementById("descripcion-equipo").value;
        descripcion += "Descripción del equipo: " + equipoDesc + "\n";
    } else if (problema === "Correo") {
        var nombre = document.getElementById("nombre").value;
        var apellido = document.getElementById("apellido").value;
        descripcion += "Nombre: " + nombre + "\nApellido: " + apellido + "\n";
    }

    document.getElementById("descripcion").value = descripcion;
}
</script>
