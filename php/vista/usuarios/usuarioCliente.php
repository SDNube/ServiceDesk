<?php
include('../banner.php');
include '../../logico/conexion.php'; 


// Verificar si el usuario está logueado
if (!isset($_SESSION['id'])) {
    echo "Debes iniciar sesión para ver tu perfil.";
    exit;
}

// Obtener el ID del usuario desde la sesión
$idUser = $_SESSION['id'];

// Consultar la base de datos para obtener la imagen de perfil
$query = "SELECT foto, materno, nombre, paterno, cumpleanos, departamento, telefono, correo,
usuario FROM datos_usuarios WHERE id_user = '$idUser'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $foto = $row['foto'];
    $materno = $row['materno'];
    $nombre = $row['nombre'];
    $paterno = $row['paterno'];
    $cumpleanos = $row['cumpleanos'];
    $departamento = $row['departamento'];
    $telefono = $row['telefono'];
    $correo = $row['correo'];
    $usuario = $row['usuario']; // Foto del usuario

    // Si la foto es NULL o vacía, asignar la imagen por defecto
    if (empty($foto)) {
        $foto = "icono_perfil.png";
    }
} else {
    // Si no se encuentra el usuario en la base de datos, asignar imagen por defecto
    $foto = "icono_perfil.png";
}

mysqli_close($conn); // Cerrar la conexión a la base de datos
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <!-- Incluir Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Contenedor principal -->
<div class="container mt-5">
    <div class="row justify-content-center">
        <!-- Tarjeta de perfil -->
        <div class="col-md-6">
            <div class="card profile-card">
                <div class="card-body text-center">
                    <!-- Imagen de perfil --> 
                    <img src="../../../uploads/<?php echo $foto ?>" alt="Imagen de perfil" class="profile-image mb-3 rounded-circle" width="170" height="170">

                    <!-- Información básica del perfil -->
                    <h2 class="card-title"><?php echo $nombre, " ", $paterno," ", $materno;?></h2>
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
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Cambiar foto de perfil -->
    <div class="modal fade" id="changeProfilePicModal" tabindex="-1" aria-labelledby="changeProfilePicModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changeProfilePicModalLabel">Cambiar foto de perfil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <form action="../../logico/usuarios/cambiarFoto.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="profilePic" class="form-label">Seleccionar imagen</label>
                            <input class="form-control" type="file" name="profilePic" id="profilePic" required onchange="displayFileSize()">
                        </div>
                        <p id="fileSize" class="text-muted">Tamaño del archivo: </p> <!-- Aquí se mostrará el tamaño del archivo -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Subir Foto</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Cambiar Contraseña -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePasswordModalLabel">Cambiar Contraseña</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="currentPassword" class="form-label">Contraseña actual</label>
                            <input type="password" class="form-control" id="currentPassword" placeholder="Introduce tu contraseña actual">
                        </div>
                        <div class="mb-3">
                            <label for="newPassword" class="form-label">Nueva contraseña</label>
                            <input type="password" class="form-control" id="newPassword" placeholder="Introduce tu nueva contraseña">
                        </div>
                        <div class="mb-3">
                            <label for="confirmPassword" class="form-label">Confirmar nueva contraseña</label>
                            <input type="password" class="form-control" id="confirmPassword" placeholder="Confirma tu nueva contraseña">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary">Cambiar Contraseña</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-6">
            <h3>Historial de Actividades</h3>
            <ul class="list-group">
                <li class="list-group-item">Actividad 1: Actualización de perfil</li>
                <li class="list-group-item">Actividad 2: Comentarios en ticket #123</li>
                <li class="list-group-item">Actividad 3: Subida de archivo</li>
            </ul>
        </div>
        <div class="col-md-6">
            <h3>Detalles de la Cuenta</h3>
            <ul class="list-group">
                <li class="list-group-item">Fecha de creación: 12/01/2023</li>
                <li class="list-group-item">Última conexión: 02/03/2025</li>
                <li class="list-group-item">Estado: Activo</li>
            </ul>
        </div>
    </div>
</div>

<!-- Incluir Bootstrap JS y dependencias -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.0/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
