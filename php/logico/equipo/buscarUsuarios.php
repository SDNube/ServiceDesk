<?php
include '../../logico/conexion.php';

if (isset($_POST['query']) && isset($_POST['idEquipo'])) {
    $id_equipo = $_POST['idEquipo'];  // Obtener el valor de 'id_equipo'
    $query = $_POST['query'];  // Obtener el valor de 'query'
    
    $sql = "SELECT id_user, nombre, paterno FROM datos_usuarios WHERE nombre LIKE '%$query%' LIMIT 10";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Mostrar los resultados en una tabla
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row['nombre'] . " " . $row['paterno'] . "</td>
                    <td>
                        <button class='btn btn-success seleccionar-btn' 
                                data-id_nombre='" . $row['id_user'] . "' 
                                data-id_equipo='" . $id_equipo . "'>
                            Seleccionar
                        </button>
                    </td>

                  </tr>";
        }
    } else {
        echo "<tr><td colspan='3'>No se encontraron resultados.</td></tr>";
    }

    $conn->close();
} else {
    echo "Faltan datos requeridos.";  // En caso de que no se reciba el id_equipo o query
}
?>

<script src="../../../js/crearPDF.js"></script>
