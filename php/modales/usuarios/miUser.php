<?php
// Incluir la conexión a la base de datos
include '../../logico/conexion.php'; 


// Verificar si hay una sesión activa
if (!isset($_SESSION['id'])) {
    echo "Error: No hay una sesión activa.";
    exit;
}

$id_user = $_SESSION['id']; // Obtener el ID del usuario de la sesión

// Preparar la consulta SQL
$sql = "SELECT nombre, paterno, materno, departamento, cumpleanos, telefono, correo, foto 
        FROM datos_usuarios 
        WHERE id_user = ?";

// Preparar la consulta
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_user); // "i" indica que es un valor entero
$stmt->execute();
$result = $stmt->get_result();

// Verificar si se encontró el usuario
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nombre = $row['nombre'];
    $paterno = $row['paterno'];
    $materno = $row['materno'];
    $departamento = $row['departamento'];
    $cumpleanos = $row['cumpleanos'];
    $telefono = $row['telefono'];
    $correo = $row['correo'];
    $foto = $row['foto'];
} else {
    echo "Error: Usuario no encontrado.";
    exit;
}

// Cerrar la consulta y conexión
$stmt->close();
$conn->close();
?>

<div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="modalLabel1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel1">Modal 1</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Imagen dentro de un enlace para abrir la modal ampliada -->
                <a href="#imageModal" data-bs-toggle="modal" data-bs-target="#imageModal">
                    <img src="../../../uploads/<?php echo $foto ?>" alt="Imagen de perfil" class="profile-image mb-3 rounded-circle" width="170" height="170">
                </a>

                <h2 class="card-title"><?php echo $nombre, " ", $paterno, " ", $materno; ?></h2>
                <p class="card-text text-muted"></p>
                <p class="text-muted"><?php echo "", $departamento; ?></p>
                <p class="text-muted"><?php echo "", $cumpleanos; ?></p>
                <p class="text-muted"><?php echo "", $telefono; ?></p>
                <p class="text-muted"><?php echo "", $correo; ?></p>

                <!-- Botones de acción que abren las modales -->
                <div class="mt-4">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#changeProfilePicModal">Cambiar foto de Perfil</button>
                    <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#changePasswordModal">Cambiar Contraseña</button>
                
                </div>
                <p></p>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 