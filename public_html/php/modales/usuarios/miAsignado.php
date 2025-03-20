<script>
    $(document).ready(function() {
        $('.pdf-btn').click(function() {
            var sn = $(this).data('sn');  // Obtener número de serie de la fila
            
            $.ajax({
                url: '../../logico/equipo/obtenerPdf.php', // Archivo PHP que obtiene el PDF de la DB
                type: 'POST',
                data: { sn: sn },
                success: function(response) {
                    if (response.trim() !== "") {
                        window.open("../../../pdf/responsivas/" + response.trim(), '_blank'); // Redirigir al PDF
                    } else {
                        alert("No se encontró un PDF para este equipo.");
                    }
                },
                error: function() {
                    alert("Error al obtener el PDF.");
                }
            });
        });
    });
</script>

<?php
// Incluir la conexión a la base de datos
include '../../logico/conexion.php';

// Obtener el ID del usuario desde la sesión
$idUsuario = $_SESSION['id'];

// Consultar los equipos asignados al usuario
$sql = "SELECT marca, modelo, descripcion, sn, fechaAlta, firmado
        FROM equipo
        WHERE asignado = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idUsuario);  // Bind the ID to the query
$stmt->execute();
$result = $stmt->get_result();

$equipos = [];
while ($row = $result->fetch_assoc()) {
    $equipos[] = $row;
}

$conn->close();
?>
<!-- Modal -->
<div class="modal fade" id="modal3" tabindex="-1" role="dialog" aria-labelledby="modalLabel3" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel3">Equipos Asignados</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Aquí se cargará la tabla de equipos -->
                <table class="table">
                    <thead>
                        <tr>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Descripción</th>
                            <th>SN</th>
                            <th>Fecha Alta</th>
                            <th>Firmado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($equipos)): ?>
                            <?php foreach ($equipos as $equipo): ?>
                                <tr>
                                    <td><?= htmlspecialchars($equipo['marca']) ?></td>
                                    <td><?= htmlspecialchars($equipo['modelo']) ?></td>
                                    <td><?= htmlspecialchars($equipo['descripcion']) ?></td>
                                    <td><?= htmlspecialchars($equipo['sn']) ?></td>
                                    <td><?= htmlspecialchars($equipo['fechaAlta']) ?></td>
                                    <td>
                                        <a class="btn btn-danger delete-btn" href="../../../pdf/responsivas/<?= htmlspecialchars($equipo['firmado']) ?>"
                                        target="_blank">
                                            <img src='../../../imagenes/iconoPdf.png' width='30' height='25'>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">No hay equipos asignados.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
