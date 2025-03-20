<?php
// Conexión a la base de datos (ajusta tus datos de conexión)
include '../../logico/conexion.php';


// Verificar si hay un grupo en la sesión
if (!isset($_SESSION['id'])) {
    die("No se ha establecido el grupo.");
}

$grupoId = $_SESSION['id']; // Obtener el ID del grupo desde la sesión

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// 1. Obtener los usuarios activos del grupo
$sqlGrupoActivos = "SELECT du.id_user, du.nombre, du.paterno, du.materno, du.foto
                    FROM grupo g
                    JOIN datos_usuarios du ON du.id_user = g.id_user
                    WHERE g.id_grupo = ? 
                    AND du.id_user NOT IN (SELECT id_user FROM users WHERE id_rol = 2)
                    AND du.id_user != 16"; // Excluir id_user = 16
$stmt = $conn->prepare($sqlGrupoActivos);
$stmt->bind_param("i", $grupoId);
$stmt->execute();
$resultGrupoActivos = $stmt->get_result();

$grupo16Users = [];
while($row = $resultGrupoActivos->fetch_assoc()) {
    $grupo16Users[] = $row;
}

// 2. Obtener los usuarios inactivos (no en el grupo)
$sqlRestoUsuarios = "SELECT du.id_user, du.nombre, du.paterno, du.materno, du.foto
                     FROM datos_usuarios du
                     WHERE du.id_user NOT IN (SELECT id_user FROM grupo WHERE id_grupo = ?)
                     AND du.id_user NOT IN (SELECT id FROM users WHERE id_rol != 2)
                     AND du.id_user != 16"; // Excluir id_user = 16
$stmt = $conn->prepare($sqlRestoUsuarios);
$stmt->bind_param("i", $grupoId);
$stmt->execute();
$resultRestoUsuarios = $stmt->get_result();

$restoUsuarios = [];
while($row = $resultRestoUsuarios->fetch_assoc()) {
    $restoUsuarios[] = $row;
}

// Cerrar la conexión
$conn->close();
?>
<!-- Mostrar el modal con los usuarios activos e inactivos -->
<!-- Botón oculto para abrir el modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal2" hidden>
  Ver usuarios
</button>

<div class="modal fade" id="modal2" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Usuarios Activos e Inactivos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
        <ul class="list-group">
          <?php foreach ($grupo16Users as $user): ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <div class="d-flex align-items-center">
                <img src="../../../uploads/<?= !empty($user['foto']) ? $user['foto'] : 'icono_perfil.png' ?>" 
                    alt="Perfil" class="rounded-circle" width="40" height="40">
                <span class="ml-3"><?= $user['nombre'] ?> <?= $user['paterno'] ?> <?= $user['materno'] ?></span>
              </div>
              <input type="checkbox" class="user-checkbox" data-id="<?= $user['id_user'] ?>" checked>
            </li>
          <?php endforeach; ?>
        </ul>

        
        <ul class="list-group">
          <?php foreach ($restoUsuarios as $user): ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <div class="d-flex align-items-center">
                <img src="../../../uploads/<?= !empty($user['foto']) ? $user['foto'] : 'icono_perfil.png' ?>" 
                
                    alt="Perfil" class="rounded-circle" width="40" height="40">
                    <span class="ml-3"><?= $user['nombre'] ?> <?= $user['paterno'] ?> <?= $user['materno'] ?></span>
              </div>
              <input type="checkbox" class="user-checkbox" data-id="<?= $user['id_user'] ?>">
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="guardarSeleccion()">Guardar</button>
      </div>
    </div>
  </div>
</div>

<script>
function guardarSeleccion() {
    let seleccionados = [];

    document.querySelectorAll('.user-checkbox:checked').forEach(checkbox => {
        seleccionados.push({
            id_user: checkbox.dataset.id
        });
    });


    // Enviar datos a PHP
    fetch('../../logico/usuarios/actualizarGrupo.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(seleccionados)
    })
    .then(response => response.json()) 
    .then(data => {
        console.log("Respuesta del servidor:", data);
        
        if (data.status === "success") {
            alert("✅ Éxito: " + data.message);
            
            // Cerrar el modal y liberar recursos
                $('#modal2').modal('hide');  // Oculta el modal
                $('#modal2').modal('dispose'); // Libera recursos
                $('body').removeClass('modal-open'); // Elimina clase modal-open
                $('.modal-backdrop').remove(); // Elimina el backdrop
 // Espera 0.5 segundos antes de cerrar
        } else {
            alert("⚠️ Error: " + data.message);
        }
    })
    .catch(error => {
        console.error("Error:", error);
        alert("❌ Ocurrió un error inesperado. Inténtalo de nuevo.");
    });
}


</script>
