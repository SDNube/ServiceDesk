<?php
// Incluir el archivo de conexión a la base de datos
session_start();
include('../conexion.php'); // Asegúrate de poner la ruta correcta de tu archivo de conexión
date_default_timezone_set('America/Mexico_City');




$problema = $_POST['problema'];
$descripcion = $_POST['descripcion'];
$pruebas = $_POST['pruebas'];
$idCliente = $_POST['idCliente'] ?? '';
$cpOrigen = $_POST['cpOrigen'] ?? '';
$cpDestino = $_POST['cpDestino'] ?? '';
$largo = $_POST['largo'] ?? '';
$alto = $_POST['alto'] ?? '';
$ancho = $_POST['ancho'] ?? '';
$peso = $_POST['peso'] ?? '';
$mensaje = '';
$nombreCompleto = $_SESSION['id'];
$path = $_POST['modalOrigin']; // Origen de la modal
$fecha_creacion = date('Y-m-d H:i:s');
$fecha_actualizacion = date('Y-m-d H:i:s');
$asignado_id = 11;


// Obtener el departamento del usuario basado en la sesión
$usuario_query = "SELECT departamento FROM datos_usuarios WHERE id_user = '$nombreCompleto'";
$usuario_result = $conn->query($usuario_query);

if (!$usuario_result) {
    die("Error en la consulta: " . $conn->error);
}

$departamento = '';
if ($usuario_result->num_rows > 0) {
    $usuario_data = $usuario_result->fetch_assoc();
    $departamento = $usuario_data['departamento'];
} else {
    die("No se encontró el departamento para el ID: $nombreCompleto");
}

echo "Departamento obtenido: " . $departamento . "<br>";

// Asignado
$asignado_id = 11;

// Prioridad depende de la modal
switch ($path) {
    case 'Computadora':
        $prioridad = 3;
        break;
    case 'Solicitud':
        $prioridad = 4;
        break;
    case 'Plataforma':
        $prioridad = 2;
        break;
    default:
        $prioridad = null;
        break;
}

// Status siempre es "nuevo"
$status = 1;

// Dependiendo de la modal, establecemos el mensaje
if ($path == 'Solicitud') {
    $mensaje = "El usuario ha hecho una solicitud";
} elseif ($path == 'Plataforma') {
    $mensaje = "Problema: $problema\nDescripción: $descripcion\n" .
               "ID Cliente: $idCliente\nCP Origen: $cpOrigen\nCP Destino: $cpDestino\n" .
               "Largo: $largo cm\nAlto: $alto cm\nAncho: $ancho cm\nPeso: $peso kg";
} else {
    $mensaje = $pruebas;
}

// Insertar los datos en la base de datos
$sql = "INSERT INTO tickets (path, problema, usuario, creacion, actualizacion, prioridad, status, departamento, asignado, descripcion_corta, mensaje)
        VALUES ('$path', '$problema', '$nombreCompleto', '$fecha_creacion', '$fecha_actualizacion', '$prioridad', '$status', '$departamento', '$asignado_id', '$descripcion', '$mensaje')";

if ($conn->query($sql) === TRUE) {
    header("Location: ../../vista/tickets/ticketscliente.php"); 
} else {
    echo "Error al agregar ticket: " . $conn->error;
}

$conn->close();
?>
