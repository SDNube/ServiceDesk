<?php
require('../../../pdf/fpdf.php');
require('../conexion.php');
session_start(); // Iniciar sesión para obtener la variable de sesión 'id'

// Verificar que se reciban los parámetros
if (!isset($_GET['id_equipo']) || !isset($_GET['id_nombre'])) {
    echo "❌ ERROR: Faltan parámetros (id_equipo o id_nombre).";
    exit();
} else {
    echo "✅ Bien";
}

$id_equipo = $_GET['id_equipo'];
$id_nombre = $_GET['id_nombre'];

// Consulta para obtener los datos del equipo
$sql_equipo = "SELECT e.marca, e.modelo, e.sn, e.tipoequipo, t.tipo 
              FROM equipo e
              JOIN tipo_equipo t ON e.tipoequipo = t.id
              WHERE e.id = '$id_equipo'";
$result_equipo = mysqli_query($conn, $sql_equipo);
$equipo = mysqli_fetch_assoc($result_equipo);

if (!$equipo) {
    die("❌ ERROR: No se encontró el equipo con ID $id_equipo.");
}

// Consulta para obtener los datos del responsable
$sql_usuario = "SELECT nombre, paterno, materno FROM datos_usuarios WHERE id_user = '$id_nombre'";
$result_usuario = mysqli_query($conn, $sql_usuario);
$usuario = mysqli_fetch_assoc($result_usuario);

if (!$usuario) {
    die("❌ ERROR: No se encontró el usuario con ID $id_nombre.");
}

// Generar nombre del archivo PDF
$nombre_pdf = $id_equipo . '_' . $id_nombre . '_' . $usuario['nombre'] . '_' . $usuario['paterno'] . '.pdf';
$nombre_pdf = utf8_decode($nombre_pdf); // Para evitar problemas con acentos
$ruta_pdf = "../../../pdf/responsivas/" . $nombre_pdf;

// Verificar si la carpeta destino existe
if (!is_dir("../../../pdf/responsivas/")) {
    die("❌ ERROR: La carpeta destino no existe.");
}

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
    $usuario['nombre'] . ' ' . $usuario['paterno'] . ' ' . $usuario['materno'] . "..."), 0, 1);

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

$pdf->Ln(10);

// Guardar el PDF en el servidor
$pdf->Output('F', $ruta_pdf); // Guardar el PDF en el directorio especificado

// Actualizar la tabla "equipo"
$sql_update_equipo = "UPDATE equipo SET asignado = '$id_nombre', pdf = '$nombre_pdf' WHERE id = '$id_equipo'";

// Registrar en el historial
$id_sesion = $_SESSION['id'];
$mensaje = "Se asignó a " . $usuario['nombre'] . " " . $usuario['paterno'];
$sql_insert_historial = "INSERT INTO historial_equipo (id_user, id_movimiento, id_equipo, mensaje, fecha) 
                         VALUES ('$id_sesion', '1', '$id_equipo', '$mensaje', NOW())";

// Ejecución de las consultas
mysqli_query($conn, $sql_update_equipo);
mysqli_query($conn, $sql_insert_historial);

// Responder al cliente
echo "✅ PDF generado y registros actualizados correctamente.";
exit();
?>
