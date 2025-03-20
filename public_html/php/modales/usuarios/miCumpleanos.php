<!-- CDN para Canvas Confetti -->
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.4.0/dist/confetti.browser.min.js"></script>

<!-- CDN para Balloon.js (Globos animados) -->
<script src="https://cdn.jsdelivr.net/npm/balloon.js@1.1.1/balloon.min.js"></script>
<?php
// Incluir la conexión a la base de datos
include '../../logico/conexion.php';

// Obtener el mes actual
$mesActual = date('m');

// Consultar usuarios cuyo cumpleaños sea este mes
$sql = "SELECT nombre, paterno, materno, DAY(cumpleanos) AS dia_cumpleanos, departamento 
        FROM datos_usuarios 
        WHERE MONTH(cumpleanos) = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $mesActual);
$stmt->execute();
$result = $stmt->get_result();

$usuariosCumpleanos = [];
while ($row = $result->fetch_assoc()) {
    $usuariosCumpleanos[] = $row;
}

$conn->close();
?>
<?php
// Incluir la conexión a la base de datos
include '../../logico/conexion.php';

// Obtener el mes actual
$mesActual = date('m');

// Consultar usuarios cuyo cumpleaños sea este mes
$sql = "SELECT nombre, paterno, materno, DAY(cumpleanos) AS dia_cumpleanos, departamento 
        FROM datos_usuarios 
        WHERE MONTH(cumpleanos) = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $mesActual);
$stmt->execute();
$result = $stmt->get_result();

$usuariosCumpleanos = [];
while ($row = $result->fetch_assoc()) {
    $usuariosCumpleanos[] = $row;
}

$conn->close();
?>

<!-- Modal -->
<div class="modal fade" id="modal4" tabindex="-1" role="dialog" aria-labelledby="modalLabel3" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel3">Cumpleaños del Mes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Aquí se cargará la tabla de cumpleaños -->
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Día de Cumpleaños</th>
                            <th>Departamento</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($usuariosCumpleanos)): ?>
                            <?php foreach ($usuariosCumpleanos as $user): ?>
                                <tr>
                                    <td><?= htmlspecialchars($user['nombre']) ?>
                                    <?= htmlspecialchars($user['paterno']) ?>
                                    <?= htmlspecialchars($user['materno']) ?></td>
                                    <td><?= htmlspecialchars($user['dia_cumpleanos']) ?></td>
                                    <td><?= htmlspecialchars($user['departamento']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">No hay cumpleaños este mes.</td>
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

<!-- Agregar el código JavaScript para las animaciones de globos y confeti -->
<script>
    // Solo si hay datos en la tabla (es decir, si hay cumpleaños)
    <?php if (!empty($usuariosCumpleanos)): ?>
        // Mostrar confeti
        function createConfetti() {
            var count = 150;
            var defaults = {
                origin: { y: 0.7 }
            };
            confetti(Object.assign({}, defaults, { particleCount: count }));
        }

        // Mostrar globos
        function createBalloons() {
            balloon({
                x: Math.random() * window.innerWidth, // Posición aleatoria en el eje X
                y: Math.random() * window.innerHeight, // Posición aleatoria en el eje Y
                size: Math.random() * 30 + 10, // Tamaño aleatorio del globo
                color: 'hsl(' + Math.random() * 360 + ', 70%, 50%)', // Color aleatorio
                rise: Math.random() * 2 + 1 // Velocidad aleatoria
            });
        }

        // Activar las animaciones cuando se abra el modal
        $('#modal4').on('shown.bs.modal', function () {
            createConfetti(); // Llama al confeti
            createBalloons(); // Llama a los globos
        });
    <?php endif; ?>
</script>
