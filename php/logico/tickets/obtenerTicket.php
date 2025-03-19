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
                            <option value="accesorios">Accesorios</option>
                            <option value="equipo">Equipo de cómputo</option>
                            <option value="correo">Correo</option>
                        </select>
                    </div>

                    <!-- Formulario para accesorios -->
                    <div id="form-accesorios" class="form-group" style="display: none;">
                        <label for="problemaAccesorio">Selecciona el accesorio:</label>
                        <select class="form-control" id="problemaAccesorio">
                            <option value="mouse">Mouse</option>
                            <option value="teclado">Teclado</option>
                            <option value="pad">Pad</option>
                            <option value="case">Case para celular</option>
                        </select>
                    </div>

                    <!-- Formulario para equipo de cómputo -->
                    <div id="form-equipo" class="form-group" style="display: none;">
                        <label for="descripcion-equipo">Descripción del problema con el equipo de cómputo:</label>
                        <textarea class="form-control" id="descripcion-equipo" placeholder="Descripción del problema"></textarea>
                    </div>

                    <!-- Formulario para correo -->
                    <div id="form-correo" class="form-group" style="display: none;">
                        <label for="nombre">Nombre(s):</label>
                        <input type="text" class="form-control" id="nombre" placeholder="Ingresa el nombre(s)">
                        <label for="apellido">Apellidos:</label>
                        <input type="text" class="form-control" id="apellido" placeholder="Ingresa los apellidos">
                    </div>

                    <!-- Campo oculto donde se unirá toda la descripción -->
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

    // Obtener los formularios
    var formAccesorios = document.getElementById("form-accesorios");
    var formEquipo = document.getElementById("form-equipo");
    var formCorreo = document.getElementById("form-correo");

    // Ocultar todos los formularios
    formAccesorios.style.display = "none";
    formEquipo.style.display = "none";
    formCorreo.style.display = "none";

    // Mostrar solo el formulario relacionado
    if (problema === "accesorios") {
        formAccesorios.style.display = "block";
    } else if (problema === "equipo") {
        formEquipo.style.display = "block";
    } else if (problema === "correo") {
        formCorreo.style.display = "block";
    }
}

function unirCampos() {
    var problema = document.getElementById("problema").value;
    var accesorio = document.getElementById("problemaAccesorio") ? document.getElementById("problemaAccesorio").value : "";
    var equipoDesc = document.getElementById("descripcion-equipo") ? document.getElementById("descripcion-equipo").value : "";
    var nombre = document.getElementById("nombre") ? document.getElementById("nombre").value : "";
    var apellido = document.getElementById("apellido") ? document.getElementById("apellido").value : "";

    var descripcion = "Categoría: " + problema + "\n";
    
    if (problema === "accesorios") {
        descripcion += "Accesorio: " + accesorio + "\n";
    } else if (problema === "equipo") {
        descripcion += "Descripción del equipo: " + equipoDesc + "\n";
    } else if (problema === "correo") {
        descripcion += "Nombre: " + nombre + "\nApellido: " + apellido + "\n";
    }

    document.getElementById("descripcion").value = descripcion;
}
</script>
