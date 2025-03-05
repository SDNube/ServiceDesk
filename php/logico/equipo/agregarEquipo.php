<?php
include '../conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $descripcion = $_POST['descripcion'];
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $sn = $_POST['sn'];
    $estado = $_POST['estado'];
    $asignado = NULL;  // Se establece como NULL si no se pasa el valor
    $tipoequipo = $_POST['tipoequipo'];

    $sql = "INSERT INTO equipo (descripcion, marca, modelo, sn, estado, asignado, tipoequipo) 
            VALUES ('$descripcion', '$marca', '$modelo', '$sn', '$estado', NULL, '$tipoequipo')";

    if ($conn->query($sql) === TRUE) {
        header("Location: ../../vista/equipo/altaEquipo.php");
    } else {
        echo "Error: " . $conn->error;
    }
    $conn->close();
}
?>
