<?php
session_start();
include('../conexion.php'); // Conexión a la base de datos


// Verificar si el usuario está logueado
if (!isset($_SESSION['id'])) {
    echo "Debes iniciar sesión para cambiar tu foto de perfil.";
    exit;
}

// Obtener el ID del usuario desde la sesión
$idUser = $_SESSION['id'];

$targetDir = "C:/xampp/htdocs/ServiceDesk/uploads/"; 

// Nombre temporal del archivo
$targetFile = $targetDir . basename($_FILES["profilePic"]["name"]);
$imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

// Comprobar si el archivo es una imagen real
if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["profilePic"]["tmp_name"]);
    if ($check === false) {
        echo "El archivo no es una imagen.";
        exit;
    }
}

// Consultar la base de datos para obtener la imagen actual del usuario
$query = "SELECT foto FROM datos_usuarios WHERE id_user = '$idUser'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $currentImage = $row['foto'];

    // Si ya tiene una imagen de perfil, eliminarla de la carpeta
    if ($currentImage && file_exists($targetDir . $currentImage)) {
        unlink($targetDir . $currentImage); // Eliminar la imagen anterior
    }
} else {
    echo "No se encontró el usuario en la base de datos.";
    exit;
}

// Comprobar si el archivo ya existe en el servidor
if (file_exists($targetFile)) {
    echo "Lo siento, el archivo ya existe.";
    exit;
}

// Limitar el tamaño del archivo (en bytes)
if ($_FILES["profilePic"]["size"] > 2000000) { // 500 KB por ejemplo
    echo "Lo siento, el archivo es demasiado grande.";
    exit;
}

// Permitir ciertos formatos de imagen
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
    echo "Lo siento, solo se permiten archivos JPG, JPEG, PNG y GIF.";
    exit;
}

// Subir el archivo al servidor
if (move_uploaded_file($_FILES["profilePic"]["tmp_name"], $targetFile)) {
    echo "El archivo " . htmlspecialchars(basename($_FILES["profilePic"]["name"])) . " ha sido subido.";

    // Insertar el nombre de la nueva imagen en la base de datos
    $imageName = basename($_FILES["profilePic"]["name"]);

    $updateQuery = "UPDATE datos_usuarios SET foto = '$imageName' WHERE id_user = '$idUser'";

    if (mysqli_query($conn, $updateQuery)) {
        echo "Nombre de la imagen actualizado en la base de datos.";
        header("Location: ../../vista/usuarios/usuarioCliente.php");
    } else {
        echo "Error al actualizar la base de datos: " . mysqli_error($conn);
    }

} else {
    echo "Lo siento, hubo un error al subir tu archivo.";
}

mysqli_close($conn);
?>
