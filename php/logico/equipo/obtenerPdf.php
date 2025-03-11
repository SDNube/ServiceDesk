<?php
require '../conexion.php'; // Asegúrate de incluir la conexión a la BD

if (isset($_POST['sn'])) {
    $sn = $_POST['sn'];

    // Prevenir SQL Injection con consultas preparadas
    $stmt = $conn->prepare("SELECT pdf, firmado FROM equipo WHERE sn = ?");
    $stmt->bind_param("s", $sn);
    $stmt->execute();
    $stmt->bind_result($pdf, $firmado); // Obtener los dos campos
    $stmt->fetch();
    $stmt->close();
    
    // Decidir qué campo devolver según si firmado es NULL
    if ($firmado === NULL) {
        // Si "firmado" es NULL, devolver el valor de "pdf"
        echo $pdf;
    } else {
        // Si "firmado" no es NULL, devolver el valor de "firmado"
        echo $firmado;
    }

    $conn->close();
}
?>
