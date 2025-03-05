<?php
// CrearPdf.php

// Verificar si los datos fueron enviados
if (isset($_POST['id_equipo']) && isset($_POST['id_nombre'])) {
    // Obtener los datos enviados
    $id_equipo = $_POST['id_equipo'];
    $id_nombre = $_POST['id_nombre'];

    // Aquí podrías realizar el procesamiento necesario (como generar un PDF)
    // Por ejemplo, si deseas mostrar los datos:
    echo "ID del equipo: " . $id_equipo . "<br>";
    echo "ID del nombre: " . $id_nombre . "<br>";
    
    // Si estás generando un PDF, por ejemplo con FPDF o TCPDF, lo harías aquí
    // Suponiendo que se genera el PDF, puedes devolver la URL del PDF generado o el contenido
    // echo 'PDF generado correctamente';
} else {
    echo "Faltan datos.";
}
?>
