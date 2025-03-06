<?php
require '../conexion.php'; // Asegúrate de incluir la conexión a la BD

if (isset($_POST['sn'])) {
    $sn = $_POST['sn'];

    // Prevenir SQL Injection con consultas preparadas
    $stmt = $conn->prepare("SELECT pdf FROM equipo WHERE sn = ?");
    $stmt->bind_param("s", $sn);
    $stmt->execute();
    $stmt->bind_result($pdf);
    $stmt->fetch();
    $stmt->close();
    $conn->close();

    // Enviar el nombre del PDF al script JS
    echo $pdf;
}
?>
