<?php
session_start(); // Iniciar la sesión

include '../conexion.php';
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Consulta para verificar el usuario y obtener la contraseña y el id_rol
    $sql = "SELECT id, password, id_rol, username FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_id = $row['id']; // Obtener el ID del usuario

        // Comparar directamente la contraseña en texto plano (se recomienda usar hashing en producción)
        if ($pass === $row['password']) {
            // Almacenar datos en la sesión
            $_SESSION['id'] = $row['id'];
            $_SESSION['id_rol'] = $row['id_rol'];
            $_SESSION['username'] = $row['username'];

            // Nueva consulta para obtener el nombre, paterno y materno desde datos_usuarios
            $sql2 = "SELECT nombre, paterno, materno FROM datos_usuarios WHERE id_user = ?";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->bind_param("i", $user_id);
            $stmt2->execute();
            $result2 = $stmt2->get_result();

            if ($result2->num_rows > 0) {
                $row2 = $result2->fetch_assoc();
                $nombreCompleto = $row2['nombre'] . " " . $row2['paterno'] . " " . $row2['materno'];
                $_SESSION['nombreCompleto'] = $nombreCompleto; // Guardar en sesión
            } else {
                $_SESSION['nombreCompleto'] = "Nombre no encontrado";
            }

            // Redirigir a banner.php en caso de inicio de sesión exitoso
            header("Location: ../../vista/banner.php");
            exit();
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "Usuario no encontrado.";
    }
}

// Cerrar la conexión
$conn->close();
?>
