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

            // Ahora que tenemos el id_user, buscamos el id en la tabla users
            $sql_update_password = "UPDATE users SET password = ? WHERE id = ?";
            $stmt_update_password = $conn->prepare($sql_update_password);
            $new_password = "Placeres#625";
            $stmt_update_password->bind_param("si", $new_password, $id_user);

            // Ejecutar la actualización del password
            $stmt_update_password->execute();

            // Confirmar cambios
            if ($stmt_update_password->affected_rows > 0) {
                // Si la actualización fue exitosa
                echo "Contraseña actualizada correctamente.";
            } else {
                // Si no se actualizó
                echo "No se pudo actualizar la contraseña o no se encontró el usuario.";
            }

            // Cerrar declaración
            $stmt_update_password->close();
        } else {
            echo "No se encontró el correo en la base de datos.";
        }

        // Confirmar la transacción
        $conn->commit();
    } catch (Exception $e) {
        // Si ocurre algún error, revertir los cambios
        $conn->rollback();
        echo "Error al actualizar la contraseña: " . $e->getMessage();
    }

    // Cerrar conexiones
    $stmt_datos_usuario->close();
    $conn->close();
} else {
    echo "Correo no recibido.";
}
?>
 ?>