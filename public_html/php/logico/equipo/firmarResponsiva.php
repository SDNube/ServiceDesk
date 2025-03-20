<?php
session_start();
include '../conexion.php'; // Incluye tu archivo de conexión

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['responsiva_pdf']) && isset($_POST['id_equipo'])) {
    // Variables
    $idEquipo = $_POST['id_equipo'];
    $userId = $_SESSION['id'];  // Asume que el ID del usuario está en la sesión

    // Consultar el nombre del archivo actual de la tabla 'equipo'
    $query = "SELECT pdf FROM equipo WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $idEquipo);
    $stmt->execute();
    $stmt->bind_result($pdfActual);
    $stmt->fetch();
    $stmt->close();

    // Verificar si se obtuvo un archivo PDF
    if ($pdfActual) {
        // Subir el archivo PDF
        $pdfName = $_FILES['responsiva_pdf']['name'];
        $pdfTmpName = $_FILES['responsiva_pdf']['tmp_name'];
        $pdfExt = pathinfo($pdfName, PATHINFO_EXTENSION);

        // Validar que el archivo sea un PDF
        if ($pdfExt === 'pdf') {
            $newPdfName = $pdfActual . 'firmado.pdf';
            $uploadDir = '../../../pdf/responsivas/';
            $uploadFile = $uploadDir . $newPdfName;

            // Mover el archivo a la carpeta
            if (move_uploaded_file($pdfTmpName, $uploadFile)) {
                // Actualizar la base de datos con el nuevo nombre de archivo
                $updateQuery = "UPDATE equipo SET firmado = ? WHERE id = ?";
                $stmt = $conn->prepare($updateQuery);
                $stmt->bind_param("si", $newPdfName, $idEquipo);
                $stmt->execute();
                $stmt->close();

                // Insertar en la tabla historial_equipo
                $insertHistorialQuery = "INSERT INTO historial_equipo (id_user, id_movimiento, id_equipo, mensaje, fecha) 
                                         VALUES (?, 4, ?, 'Se entrega equipo y se firma responsiva', NOW())";
                $stmt = $conn->prepare($insertHistorialQuery);
                $stmt->bind_param("ii", $userId, $idEquipo);
                $stmt->execute();
                $stmt->close();

                echo "El archivo se subió y firmó correctamente.";
            } else {
                echo "Error al subir el archivo.";
            }
        } else {
            echo "Por favor suba un archivo PDF.";
        }
    } else {
        echo "No se encontró el archivo en la base de datos.";
    }
} else {
    echo "Datos incompletos.";
}
?>
