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
$stmt->bind_param("i", $id_user);
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
<div class="modal fade" id="modal1" tabindex="-1" aria-labelledby="modalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-custom">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel1">Perfil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body text-center">
                <a href="#imageModal" data-bs-toggle="modal" data-bs-target="#imageModal">
                    <img src="../../../uploads/<?php echo $foto ?>" alt="Imagen de perfil" class="rounded-circle mb-3" width="170" height="170">
                </a>
                <h2><?php echo "$nombre $paterno $materno"; ?></h2>
                <p class="text-muted">Departamento: <?php echo $departamento; ?></p>
                <p class="text-muted">Cumpleaños: <?php echo $cumpleanos; ?></p>
                <p class="text-muted">Teléfono: <?php echo $telefono; ?></p>
                <p class="text-muted">Correo: <?php echo $correo; ?></p>

                <!-- Formulario para cambiar foto de perfil -->
                <form id="formChangePic" action="../../logico/usuarios/cambiarFoto.php" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="profilePic" class="form-label">Cambiar Foto de Perfil</label>
                        <input type="file" class="form-control" id="profilePic" name="profilePic" accept="image/*" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Cambiar Foto</button>
                </form>

                <!-- Formulario para cambiar la contraseña -->
                <form action="../../logico/usuarios/cambiarPass.php" method="post" class="mt-4" id="formChangePass">
                    <div class="mb-3">
                        <label for="actual_password" class="form-label">Contraseña Actual</label>
                        <input type="password" class="form-control" id="actual_password" name="actual_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="nueva_password" class="form-label">Nueva Contraseña</label>
                        <input type="password" class="form-control" id="nueva_password" name="nueva_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirmar Nueva Contraseña</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Cambiar Contraseña</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('formChangePic').addEventListener('submit', function (e) {
        e.preventDefault(); // Prevenir el envío normal del formulario
        
        var formData = new FormData(this); // Crear un objeto FormData con los datos del formulario
        
        // Enviar la solicitud AJAX
        fetch('../../logico/usuarios/cambiarFoto.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json()) // Convertir la respuesta a JSON
        .then(data => {
            // Verificar el estado de la respuesta
            if (data.status === 'success') {
                // Mostrar SweetAlert con mensaje de éxito
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: data.message
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Cerrar el modal después de confirmar el mensaje
                        $('#modal1').modal('hide'); // Cerrar la modal

                        // Opcionalmente, actualizar la imagen en el modal (si es necesario)
                        var newImageSrc = '../../../uploads/' + data.newPhotoName; // Asumiendo que el servidor te devuelve el nombre de la nueva foto
                        document.querySelector('#modal1 img').src = newImageSrc; // Actualizamos el src de la imagen en el modal
                        window.location.href = 'miUsuario.php';
                    }
                });
            } else {
                // Mostrar SweetAlert con mensaje de error
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
    document.getElementById('formChangePass').addEventListener('submit', function (e) {
        e.preventDefault(); // Prevenir el envío normal del formulario

        var formData = new FormData(this); // Crear un objeto FormData con los datos del formulario

        // Enviar la solicitud AJAX
        fetch('../../logico/usuarios/cambiarPass.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json()) // Convertir la respuesta a JSON
        .then(data => {
            // Verificar el estado de la respuesta
            if (data.status === 'success') {
                // Mostrar SweetAlert con mensaje de éxito
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: data.message
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Cerrar el modal después de confirmar el mensaje
                        $('#modal1').modal('hide'); // Cerrar la modal

                        window.location.href = 'miUsuario.php'; // Redirigir a la página deseada
                    }
                });
            } else {
                // Mostrar SweetAlert con mensaje de error
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
</script>



</body>
</html>
