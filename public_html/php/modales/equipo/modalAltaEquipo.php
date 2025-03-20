<div class="modal fade" id="equipoModal" tabindex="-1" role="dialog" aria-labelledby="equipoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="equipoModalLabel">Agregar Nuevo Equipo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="../../logico/equipo/agregarEquipo.php" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Descripción</label>
                        <input type="text" name="descripcion" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Marca</label>
                        <input type="text" name="marca" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Modelo</label>
                        <input type="text" name="modelo" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Serie</label>
                        <input type="text" name="sn" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Estado</label>
                        <select name="estado" class="form-control">
                            <option value="activo">Activo</option>
                            <option value="inactivo">Inactivo</option>
                            <option value="en reparación">En Reparación</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tipo de equipo</label>
                        <select name="tipoequipo" class="form-control" required>
                            <?php
                            include '../logico/conexion.php';
                            $tipo_sql = "SELECT * FROM tipo_equipo";
                            $tipo_result = $conn->query($tipo_sql);
                            while ($tipo = $tipo_result->fetch_assoc()) {
                                echo "<option value='" . $tipo['id'] . "'>" . htmlspecialchars($tipo['tipo']) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
