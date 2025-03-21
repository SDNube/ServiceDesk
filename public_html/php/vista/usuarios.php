<?php 
    include '../logico/conexion.php'; 

    $sql = "SELECT 
        u.id, 
        u.id_rol, 
        d.nombre, 
        d.paterno, 
        d.materno, 
        d.cumpleanos, 
        d.departamento, 
        d.telefono, 
        d.correo, 
        d.usuario, 
        r.vista
    FROM datos_usuarios d
    JOIN users u ON d.id_user = u.id
    JOIN roles r ON u.id_rol = r.id;";

    $result = $conn->query($sql); // Ejecutar la consulta

    $abrirModal = !empty($_POST);
?>
<!DOCTYPE html>
        <html lang="es">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Tickets</title>
                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
                
                <!-- Cargar jQuery completo (no la versión slim) -->
                <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
                <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
                
            </head>
        <body>
            <?php 
                include '../vista/banner.php'; 
                include '../modales/agregaUser.php';
            ?>

            <div class="container-fluid mt-4">
                <h1>USUARIOS</h1>
                <p>&nbsp;</p>
                
                <div class="d-flex justify-content-between align-items-center">
    <!-- Botón de Agregar Usuario a la izquierda -->
    <div class="d-flex justify-content-start">
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#userModal">
            Agregar Usuario
        </button>
    </div>

    <!-- Buscador y Select a la derecha -->
    <div class="d-flex justify-content-end">
        <select id="filterSelect" class="form-control w-auto mr-2">
            <option value="nombre">Nombre</option>
            <option value="paterno">Apellido Paterno</option>
            <option value="materno">Apellido Materno</option>
            <option value="cumpleanos">Cumpleaños</option>
            <option value="departamento">Departamento</option>
            <option value="telefono">Teléfono</option>
            <option value="correo">Correo</option>
            <option value="vista">Rol de usuario</option>
            <option value="usuario">Usuario</option>
        </select>
        <input type="text" id="searchInput" class="form-control w-auto" placeholder="Buscar...">
    </div>
</div>

                <p>&nbsp;</p>

                <div class="table-responsive">
                    <table id="userTable" class="table table-striped text-center w-100">
                        <thead>
                            <tr>
                                <th data-column="nombre">Nombre</th>
                                <th data-column="paterno">Apellido Paterno</th>
                                <th data-column="materno">Apellido Materno</th>
                                <th data-column="cumpleanos">Cumpleaños</th>
                                <th data-column="departamento">Departamento</th>
                                <th data-column="telefono">Teléfono</th>
                                <th data-column="correo">Correo</th>
                                <th data-column="vista">Rol de usuario</th>
                                <th data-column="usuario">Usuario</th>
                                <th>Reset Password</th>
                                <th>Cambiar Rol</th>
                                <th>Editar</th>
                                <th>Eliminar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                // Verificar si hay resultados
                                if ($result->num_rows > 0) {
                                    // Salida de cada fila
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>
                                                <td data-column='nombre'>" . htmlspecialchars($row['nombre']) . "</td>
                                                <td data-column='paterno'>" . htmlspecialchars($row['paterno']) . "</td>
                                                <td data-column='materno'>" . htmlspecialchars($row['materno']) . "</td>
                                                <td data-column='cumpleanos'>" . htmlspecialchars($row['cumpleanos']) . "</td>
                                                <td data-column='departamento'>" . htmlspecialchars($row['departamento']) . "</td>
                                                <td data-column='telefono'>" . htmlspecialchars($row['telefono']) . "</td>
                                                <td data-column='correo'>" . htmlspecialchars($row['correo']) . "</td>
                                                <td data-column='vista'>" . htmlspecialchars($row['vista']) . "</td>
                                                <td data-column='usuario'>" . htmlspecialchars($row['usuario']) . "</td>
                                                <td>
                                                    <button class='btn btn-warning reset-btn' data-correo='" . htmlspecialchars($row['correo']) . "'>
                                                        Reset
                                                    </button>
                                                </td>
                                                <td>
                                                    <button class='btn btn-info rol-btn' data-correo='" . htmlspecialchars($row['correo']) . "'>
                                                        Cambiar
                                                    </button>
                                                </td> 
                                                <td><button class='btn btn-primary'>Editar</button></td>
                                                <td>
                                                    <button class='btn btn-danger delete-btn' data-correo='" . htmlspecialchars($row['correo']) . "'>
                                                        Eliminar
                                                    </button>
                                                </td>   
                                            </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='12'>No hay usuarios registrados </td></tr>";
                                }
                                // Cerrar la conexión
                                $conn->close();
                            ?>
                        </tbody>
                    </table>
                </div>
                <script src="https://intranet.puntoactivo.mx/js/usuariosAdmin.js"></script>
        </body>
    </html>

    

