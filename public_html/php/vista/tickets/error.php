
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SD PuntoActivo</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

    <!-- Barra de Navegación -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Soporte PA</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                
                                    <li class="nav-item">
                        <a class="nav-link" href="/ServiceDesk/php/vista/tickets/ticketscliente.php">Tickets de soporte</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/ServiceDesk/php/vista/usuarios/test.php" hidden>miUSuario</a>
                    </li>
                                <li class="nav-item">
                        <a class="nav-link" href="/ServiceDesk/php/vista/usuarios/miUSuario.php"> Cliente de pruebas<span class="sr-only">(actual)</span></a>
                </li>
            </ul>
            <form class="form-inline ml-auto" action="/ServiceDesk/php/logico/usuarios/logout.php" method="POST">
                <button class="btn btn-danger my-2 my-sm-0" type="submit">Cerrar sesión</button>
            </form>
        </div>
    </nav>
</body>
</html>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Tickets</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <!-- Cargar jQuery completo -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Incluir el archivo JavaScript externo para la cancelación -->
    <script src="../../../js/cancelacionTicket.js"></script> <!-- Ruta correcta -->
    <script src="../../../js/abrirModalVerTicket.js"></script>
    <script src="../../../js/abrirModalComentarios.js"></script>


    <style>
        /* Animación para prioridad urgente */
        @keyframes parpadeo {
            0% { color: red; }
            50% { color: black; }
            100% { color: red; }
        }
        .urgente {
            animation: parpadeo 1s infinite;
            font-weight: bold;
        }
    </style>

    <script>
        $(document).ready(function() {
            $('#buscador').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                
                $('table tbody tr').filter(function() {
                    var text = $(this).find('td').eq(0).text().toLowerCase(); // Buscar solo en la columna de ID
                    $(this).toggle(text.indexOf(value) > -1);
                });
            })
        });
    </script>

</head>
<body>

<div class="container-fluid mt-4">
    <h1>Mis Tickets</h1>
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#ticketTiComputadora">
        TI - Computadora
    </button>
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#ticketSistemaPlataforma">
        Sistema - Plataforma
    </button>
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#ticketSolicitudEquipo">
        Solicitud - Equipo
    </button>
    <!-- Buscador con Bootstrap alineado a la derecha -->
    <div class="row mb-3">
        <div class="col-md-12 d-flex justify-content-end">
            <div class="input-group" style="max-width: 300px;">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                </div>
                <input id="buscador" class="form-control" type="text" placeholder="Buscar por ID...">
            </div>
        </div>
    </div>
    <p></p>

    <div class="table-responsive">
        <table class="table table-striped text-center w-100">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>PATH</th>
                    <th>Problema</th>
                    <th>Fecha creación</th>
                    <th>Fecha actualización</th>
                    <th>Prioridad</th>
                    <th>Status</th>
                    <th>Asignado a</th>
                    <th>Descripción corta</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr><td>58</td><td>Computadora</td><td>qwer</td><td>2025-03-11 13:08:34</td><td>2025-03-11 13:22:11</td><td class=''>Media</td><td>Nuevo</td><td>Roberto Macias</td><td>qwer</td><td class='text-center align-middle' style='display: flex; justify-content: center; align-items: center; gap: 5px;'>
                                <button class='btn btn-danger d-flex justify-content-center align-items-center' 
                                        style='width: 30px; height: 30px; font-size: 18px; color: white;' 
                                        onclick='abrirModalCancelacion(58)'>
                                    X
                                </button>
                                <button class='btn btn-info d-middle' justify-content-center align-items-center' 
                                        style='width: 31px; height: 31px; padding: 0;' 
                                        onclick='abrirModalVerTicket(58, "Computadora")'>
                                    <img src='../../../imagenes/ver.png' alt='Ver' style='width: 22px; height: 25px;'>
                                </button>
                                 
                                <button class='btn btn-warning d-middle' 
                                        style='width: 31px; height: 31px; padding: 0;' 
                                        onclick='abrirModalComentarios(58)'>
                                    <img src='../../../imagenes/comentario.png' alt='Ver' style='width: 22px; height: 25px;'>
                                </button>

                                </tr>            </tbody>
        </table>
    </div>
</div>

<!-- Modales -->
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
                        <textarea class="form-control" id="descripcion-equipo" name="descripcion-equipo" placeholder="Descripción del problema con el equipo de cómputo" ></textarea>
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
function mostrarFormulario() {
    var categoria = document.getElementById("categoria").value;

    // Obtener los formularios
    var formAccesorios = document.getElementById("form-accesorios");
    var formEquipo = document.getElementById("form-equipo");
    var formCorreo = document.getElementById("form-correo");

    // Ocultar todos los formularios
    formAccesorios.style.display = "none";
    formEquipo.style.display = "none";
    formCorreo.style.display = "none";

    // Deshabilitar required en todos los campos
    deshabilitarRequeridos(formAccesorios);
    deshabilitarRequeridos(formEquipo);
    deshabilitarRequeridos(formCorreo);

    // Mostrar y habilitar required solo en el formulario seleccionado
    if (categoria === "accesorios") {
        formAccesorios.style.display = "block";
        habilitarRequeridos(formAccesorios);
    } else if (categoria === "equipo") {
        formEquipo.style.display = "block";
        habilitarRequeridos(formEquipo);
    } else if (categoria === "correo") {
        formCorreo.style.display = "block";
        habilitarRequeridos(formCorreo);
    }
}

// Función para deshabilitar el atributo required
function deshabilitarRequeridos(form) {
    var inputs = form.querySelectorAll("input, textarea, select");
    inputs.forEach(function(input) {
        input.removeAttribute("required");
    });
}

// Función para habilitar el atributo required
function habilitarRequeridos(form) {
    var inputs = form.querySelectorAll("input, textarea, select");
    inputs.forEach(function(input) {
        input.setAttribute("required", "required");
    });
}
document.querySelector("form-accesorios").addEventListener("submit", function(event) {
    console.log("Formulario enviado a:", this.action);
});

</script>

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
    document.querySelectorAll('.modal form').forEach((form) => {
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
                <form id="formPlataforma" action="../../logico/tickets/editarTicket.php" method="POST" enctype="multipart/form-data">
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

<!-- SweetAlert2 -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.4/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.4/dist/sweetalert2.all.min.js"></script>
<script>
    // Asegúrate de que se ejecute después de que el DOM esté completamente cargado
    document.addEventListener('DOMContentLoaded', function () {
        const formPlataforma = document.getElementById('formPlataforma');

        formPlataforma.addEventListener('submit', function (e) {
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
                        $('#modalSistemaPlataformaEdicion').modal('hide');
                        
                        // Aquí puedes actualizar la vista del ticket en la modal si es necesario
                        const ticketInfo = data.ticket;
                        document.querySelector('#problemaEdicionPlataforma').value = ticketInfo.problema;
                        document.querySelector('#descripcionEdicionPlataforma').value = ticketInfo.descripcion;
                        // Actualiza otros campos según sea necesario
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


</body>
</html>
