<?php
include '../../logico/conexion.php'; 

session_start();
if (!isset($_SESSION['id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Debes iniciar sesión']);
    exit;
}

$id_user = $_SESSION['id'];
$currentPassword = $_POST['actual_password'];
$newPassword = $_POST['nueva_password'];
$confirmPassword = $_POST['confirm_password'];

// Verificar que las contraseñas coinciden
if ($newPassword !== $confirmPassword) {
    echo json_encode(['status' => 'error', 'message' => 'Las contraseñas no coinciden']);
    exit;
}

// Obtener la contraseña actual del usuario
$query = "SELECT password FROM users WHERE id = '$id_user'";

$result = mysqli_query($conn, $query);

if (!$result) {
    echo json_encode(['status' => 'error', 'message' => 'Error al ejecutar la consulta de la base de datos']);
    exit;
}

$row = mysqli_fetch_assoc($result);

// Comparación directa de contraseñas (sin cifrado)
if ($row && $currentPassword === $row['password']) {
    // Contraseña válida, proceder con el cambio
    $updateQuery = "UPDATE users SET password = '$newPassword' WHERE id_user = '$id_user'";

    if (mysqli_query($conn, $updateQuery)) {
        echo json_encode(['status' => 'success', 'message' => 'Contraseña cambiada exitosamente']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error al actualizar la contraseña']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Contraseña actual incorrecta']);
}

mysqli_close($conn);
?>
