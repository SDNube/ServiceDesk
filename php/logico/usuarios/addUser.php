<?php
include '../conexion.php';
session_start();

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $paterno = $_POST['paterno'];
    $materno = $_POST['materno'];
    $nombre = $_POST['nombre'];
    $fechaNacimiento = $_POST['fechaNacimiento'];
    $departamento = $_POST['departamento'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $password = $_POST['password'];
    $idRol = $_POST['id_rol'];

    // Extraer el nombre de usuario del correo
    $usuario = explode('@', $correo)[0];

    // Insertar en la tabla users
    $sql_insert_user = "INSERT INTO users (username, password, id_rol) VALUES (?, ?, ?)";
    $stmt_insert_user = $conn->prepare($sql_insert_user);
    $stmt_insert_user->bind_param("ssi", $usuario, $password, $idRol);
    $stmt_insert_user->execute();

    // Obtener el id del usuario recién insertado
    $id_user = $conn->insert_id;  // Aquí obtenemos el id de la tabla users

    // Insertar en la tabla datos_usuarios con el id_user
    $sql_insert_datos = "INSERT INTO datos_usuarios (nombre, paterno, materno, cumpleanos, departamento, telefono, correo, usuario, id_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt_insert_datos = $conn->prepare($sql_insert_datos);
    $stmt_insert_datos->bind_param("sssssssss", $nombre, $paterno, $materno, $fechaNacimiento, $departamento, $telefono, $correo, $usuario, $id_user);
    $stmt_insert_datos->execute();

    // Redirigir al usuario a la página de usuarios
    header("Location: ../../vista/usuarios.php");
    exit();
}

// Cerrar la conexión
$conn->close();
?>

