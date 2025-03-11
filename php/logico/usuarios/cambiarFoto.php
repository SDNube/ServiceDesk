<?php
// Incluir la conexión a la base de datos
include '../../logico/conexion.php'; 

session_start();
if (!isset($_SESSION['id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Debes iniciar sesión']);
    exit;
}

$id_user = $_SESSION['id'];

if (isset($_FILES['profilePic']) && $_FILES['profilePic']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['profilePic']['tmp_name'];
    $fileName = $_FILES['profilePic']['name'];
    $fileSize = $_FILES['profilePic']['size'];
    $fileType = $_FILES['profilePic']['type'];

    // Verificar si el archivo es una imagen válida
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    if (!in_array($fileType, $allowedTypes)) {
        echo json_encode(['status' => 'error', 'message' => 'El archivo debe ser una imagen (jpg, png, gif, webp)']);
        exit;
    }

    // Validar el tamaño del archivo
    $maxFileSize = 2 * 1024 * 1024; // 2 MB
    if ($fileSize > $maxFileSize) {
        echo json_encode(['status' => 'error', 'message' => 'El archivo excede el tamaño máximo permitido (2MB)']);
        exit;
    }

    // Subir la imagen al servidor
    $uploadDir = '../../../uploads/';
    $newFileName = uniqid() . '-' . $fileName;
    $uploadPath = $uploadDir . $newFileName;

    if (move_uploaded_file($fileTmpPath, $uploadPath)) {
        // Actualizar la ruta de la foto en la base de datos
        $query = "UPDATE datos_usuarios SET foto = ? WHERE id_user = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $newFileName, $id_user);
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Foto de perfil actualizada correctamente']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error al actualizar la base de datos']);
        }
        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error al subir la imagen']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No se ha seleccionado una imagen']);
}

mysqli_close($conn);
?>
