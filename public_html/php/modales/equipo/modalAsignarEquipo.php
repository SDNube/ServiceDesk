<div class="modal fade" id="asignarModal" tabindex="-1" aria-labelledby="asignarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Asignar Equipo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="equipoId">
                <input type="text" id="busquedaUsuario" class="form-control" placeholder="Buscar usuario...">
                <div class="mt-3">
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Seleccionar</th>
                            </tr>
                        </thead>
                        <tbody id="resultadoBusqueda"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
