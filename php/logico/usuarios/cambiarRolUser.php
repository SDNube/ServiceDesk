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

            // Ahora que tenemos el id_user, obtenemos el valor actual de id_rol en la tabla users
            $sql_get_role = "SELECT id_rol FROM users WHERE id = ?";
            $stmt_get_role = $conn->prepare($sql_get_role);
            $stmt_get_role->bind_param("i", $id_user);
            $stmt_get_role->execute();
            $stmt_get_role->store_result();

            if ($stmt_get_role->num_rows > 0) {
                $stmt_get_role->bind_result($current_role);
                $stmt_get_role->fetch();

                // Validamos si el rol es 1 o 2 y lo cambiamos
                if ($current_role == 1) {
                    // Si es 1, lo cambiamos a 2
                    $new_role = 2;
                } else if ($current_role == 2) {
                    // Si es 2, lo cambiamos a 1
                    $new_role = 1;
                } else {
                    // Si el rol no es ni 1 ni 2, no hacemos nada
                    echo "Rol no válido para cambiar.";
                    return;
                }

                // Actualizamos el id_rol en la tabla users
                $sql_update_role = "UPDATE users SET id_rol = ? WHERE id = ?";
                $stmt_update_role = $conn->prepare($sql_update_role);
                $stmt_update_role->bind_param("ii", $new_role, $id_user);
                $stmt_update_role->execute();

                // Confirmar cambios
                if ($stmt_update_role->affected_rows > 0) {
                    // Si la actualización fue exitosa
                    echo "Rol actualizado correctamente.";
                } else {
                    // Si no se actualizó
                    echo "No se pudo actualizar el rol o no se encontró el usuario.";
                }

                // Cerrar declaración de actualización de rol
                $stmt_update_role->close();
            } else {
                echo "No se encontró el rol del usuario.";
            }

            // Cerrar declaración de obtención de rol
            $stmt_get_role->close();
        } else {
            echo "No se encontró el correo en la base de datos.";
        }

        // Confirmar la transacción
        $conn->commit();
    } catch (Exception $e) {
        // Si ocurre algún error, revertir los cambios
        $conn->rollback();
        echo "Error al actualizar el rol: " . $e->getMessage();
    }

    // Cerrar conexiones
    $stmt_datos_usuario->close();
    $conn->close();
} else {
    echo "Correo no recibido.";
}
?>
