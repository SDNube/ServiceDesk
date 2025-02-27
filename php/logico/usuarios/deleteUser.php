<?php
// Incluir archivo de conexión
include '../conexion.php';

// Verificar si se ha enviado el correo mediante POST
if (isset($_POST['correo'])) {
    $correo = $_POST['correo'];

    // Iniciar la transacción para asegurar la coherencia de las operaciones
    $conn->begin_transaction();

    try {
        // Obtener el id_user de la tabla datos_usuarios usando el correo
        $sql_datos_usuario = "SELECT id_user FROM datos_usuarios WHERE correo = ?";
        $stmt_datos_usuario = $conn->prepare($sql_datos_usuario);
        $stmt_datos_usuario->bind_param("s", $correo);
        $stmt_datos_usuario->execute();
        $stmt_datos_usuario->store_result();

        if ($stmt_datos_usuario->num_rows > 0) {
            $stmt_datos_usuario->bind_result($id_user);
            $stmt_datos_usuario->fetch();

            // Ahora que tenemos el id_user, eliminamos el usuario de ambas tablas
            // Primero eliminamos de la tabla users
            $sql_delete_user = "DELETE FROM users WHERE id = ?";
            $stmt_delete_user = $conn->prepare($sql_delete_user);
            $stmt_delete_user->bind_param("i", $id_user);
            $stmt_delete_user->execute();

            // Luego eliminamos de la tabla datos_usuarios
            $sql_delete_datos_usuario = "DELETE FROM datos_usuarios WHERE id_user = ?";
            $stmt_delete_datos_usuario = $conn->prepare($sql_delete_datos_usuario);
            $stmt_delete_datos_usuario->bind_param("i", $id_user);
            $stmt_delete_datos_usuario->execute();

            // Verificar si las eliminaciones fueron exitosas
            if ($stmt_delete_user->affected_rows > 0 && $stmt_delete_datos_usuario->affected_rows > 0) {
                echo "Usuario y sus datos eliminados correctamente.";
            } else {
                echo "No se pudo eliminar el usuario o sus datos.";
            }

            // Cerrar declaración de eliminación de datos
            $stmt_delete_user->close();
            $stmt_delete_datos_usuario->close();
        } else {
            echo "No se encontró el correo en la base de datos.";
        }

        // Confirmar la transacción
        $conn->commit();
    } catch (Exception $e) {
        // Si ocurre algún error, revertir los cambios
        $conn->rollback();
        echo "Error al eliminar el usuario: " . $e->getMessage();
    }

    // Cerrar conexiones
    $stmt_datos_usuario->close();
    $conn->close();
} else {
    echo "Correo no recibido.";
}
?>
