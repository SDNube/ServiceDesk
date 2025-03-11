<!-- Modal para subir el archivo PDF -->
<div class="modal fade" id="firmarResponsiva" tabindex="-1" role="dialog" aria-labelledby="firmarResponsivaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="firmarResponsivaLabel">Subir Responsiva Firmada</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formFirmar" action="../../logico/equipo/firmarResponsiva.php" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="responsiva_pdf">Selecciona el archivo PDF</label>
                        <input type="file" class="form-control-file" name="responsiva_pdf" id="responsiva_pdf" accept=".pdf" required>
                    </div>
                    <input type="hidden" name="id_equipo" id="id_equipo">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Subir y Firmar</button>
                </div>
            </form>
        </div>
    </div>
</div>
