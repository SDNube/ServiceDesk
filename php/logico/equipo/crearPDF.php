<?php
require('../../../pdf/fpdf.php');
require('../conexion.php');
session_start(); // Iniciar sesión para obtener la variable de sesión 'id'

// Recibiendo las variables
$id_equipo = $_GET['id_equipo'];
$id_nombre = $_GET['id_nombre'];

// Consulta para obtener los datos del equipo
$sql_equipo = "SELECT e.marca, e.modelo, e.sn, e.tipoequipo, t.tipo 
              FROM equipo e
              JOIN tipo_equipo t ON e.tipoequipo = t.id
              WHERE e.id = '$id_equipo'";
$result_equipo = mysqli_query($conn, $sql_equipo);
$equipo = mysqli_fetch_assoc($result_equipo);

// Consulta para obtener los datos del responsable
$sql_usuario = "SELECT nombre, paterno, materno FROM datos_usuarios WHERE id_user = '$id_nombre'";
$result_usuario = mysqli_query($conn, $sql_usuario);
$usuario = mysqli_fetch_assoc($result_usuario);

// Generar nombre del archivo PDF
$nombre_pdf = $equipo['tipo'] . '_' . $id_nombre . '_' . $usuario['nombre'] . '_' . $usuario['paterno'] . '.pdf';
$nombre_pdf = utf8_decode($nombre_pdf); // Para evitar problemas con acentos
$ruta_pdf = "../../../pdf/responsivas/" . $nombre_pdf;

// Crear objeto FPDF
$pdf = new FPDF();
$pdf->SetAutoPageBreak(true, 10);
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, utf8_decode('Responsiva de Equipo de Cómputo'), 0, 1, 'C');
$pdf->Ln(10);

// Tabla de detalles del equipo
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(95, 10, utf8_decode('Descripción'), 1, 0, 'C');
$pdf->Cell(95, 10, utf8_decode('Especificaciones'), 1, 1, 'C');
$pdf->SetFont('Arial', '', 12);

$pdf->Cell(95, 10, utf8_decode('Tipo de Equipo'), 1, 0);
$pdf->Cell(95, 10, utf8_decode($equipo['tipo']), 1, 1);
$pdf->Cell(95, 10, utf8_decode('Marca'), 1, 0);
$pdf->Cell(95, 10, utf8_decode($equipo['marca']), 1, 1);
$pdf->Cell(95, 10, utf8_decode('Modelo'), 1, 0);
$pdf->Cell(95, 10, utf8_decode($equipo['modelo']), 1, 1);
$pdf->Cell(95, 10, utf8_decode('Número de Serie'), 1, 0);
$pdf->Cell(95, 10, utf8_decode($equipo['sn']), 1, 1);
$pdf->Ln(10);

// Condiciones de uso
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, utf8_decode('Condiciones de Uso'), 0, 1, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(0, 10, utf8_decode("1. El equipo asignado es propiedad de Puntoacti y se encuentra bajo el resguardo de " . 
    $usuario['nombre'] . ' ' . $usuario['paterno'] . ' ' . $usuario['materno'] . ".
2. El responsable deberá usar el equipo de forma adecuada, cuidando la integridad física y funcional del mismo.
3. El equipo debe ser utilizado exclusivamente para las actividades laborales o académicas relacionadas con la empresa/institución.
4. En caso de daño, pérdida o mal funcionamiento, el responsable deberá notificar a [Área de soporte o TI] de inmediato.
5. El equipo será devuelto al final de la asignación o cuando así se requiera por parte de la empresa/institución.
6. Cualquier modificación o instalación de software no autorizado está prohibida."), 0, 1);

// Salto de línea
$pdf->Ln(10);

// Firma de responsabilidad
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, utf8_decode('Firma de Responsabilidad'), 0, 1, 'L');
$pdf->SetFont('Arial', '', 12);

// Responsable del equipo
$pdf->Cell(95, 10, utf8_decode('Responsable del equipo:'), 0, 0, 'L');
$pdf->Cell(95, 10, utf8_decode('Aprobación de área de TI:'), 0, 1, 'L');

// Nombre y firma
$pdf->Cell(95, 10, utf8_decode('Nombre: ') . utf8_decode($usuario['nombre'] . ' ' . $usuario['paterno'] . ' ' . $usuario['materno']), 0, 0, 'L');
$pdf->Cell(95, 10, utf8_decode('Nombre: '), 0, 1, 'L');

// Firma
$pdf->Cell(95, 10, utf8_decode('Firma: __________________________'), 0, 0, 'L');
$pdf->Cell(95, 10, utf8_decode('Firma: __________________________'), 0, 1, 'L');

// Fecha
$pdf->Cell(95, 10, utf8_decode('Fecha: __________________________'), 0, 0, 'L');
$pdf->Cell(95, 10, utf8_decode('Fecha: __________________________'), 0, 1, 'L');

// Salto de línea
$pdf->Ln(10);

// Generar el PDF y guardarlo en la carpeta "pdf"
$pdf->Output($ruta_pdf, 'F');

// INSERT en la tabla "equipo"
$sql_insert_equipo = "UPDATE equipo SET asignado = '$id_nombre', pdf = '$nombre_pdf' WHERE id = '$id_equipo'";
mysqli_query($conn, $sql_insert_equipo);

// Obtener el ID de sesión del usuario
$id_sesion = $_SESSION['id'];

// INSERT en la tabla "historial_equipo"
$mensaje = "Se asignó a " . $usuario['nombre'] . " " . $usuario['paterno'];
$sql_insert_historial = "INSERT INTO historial_equipo (id_user, id_movimiento, id_equipo, mensaje, fecha) 
                         VALUES ('$id_sesion', '1', '$id_equipo', '$mensaje', NOW())";
mysqli_query($conn, $sql_insert_historial);

echo "PDF generado y registros actualizados correctamente.";
header("Location: ../../vista/equipo/altaEquipo.php");

?>
