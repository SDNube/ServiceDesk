<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<body>

<div class="container mt-4">
    <!-- Banner con pestañas -->
    <ul class="nav nav-tabs" id="formTabs" role="tablist">
        <li class="nav-item">
            <button class="nav-link active" id="computo-tab" data-bs-toggle="tab" data-bs-target="#computo" type="button" role="tab">Equipo de Cómputo</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="telefonia-tab" data-bs-toggle="tab" data-bs-target="#telefonia" type="button" role="tab">Telefonía</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="accesorios-tab" data-bs-toggle="tab" data-bs-target="#accesorios" type="button" role="tab">Accesorios</button>
        </li>
    </ul>

    <!-- Contenido de las pestañas -->
    <div class="tab-content mt-3" id="formTabsContent">
        
        <!-- Formulario de Equipo de Cómputo -->
        <div class="tab-pane fade show active" id="computo" role="tabpanel">
            <h4 class="text-center">Responsiva de Equipo de Cómputo</h4>
            <form action="generar_pdf.php" method="POST">
                <input type="hidden" name="tipo" value="Computo">
                <div class="mb-3">
                    <label class="form-label">Nombre del Responsable:</label>
                    <input type="text" class="form-control" name="nombre_responsable" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Modelo del Equipo:</label>
                    <input type="text" class="form-control" name="modelo" required>
                </div>
                <button type="submit" class="btn btn-success w-100">Generar PDF</button>
            </form>
        </div>

        <!-- Formulario de Telefonía -->
        <div class="tab-pane fade" id="telefonia" role="tabpanel">
            <h4 class="text-center">Responsiva de Telefonía</h4>
            <form action="generar_pdf.php" method="POST">
                <input type="hidden" name="tipo" value="Telefonia">
                <div class="mb-3">
                    <label class="form-label">Nombre del Responsable:</label>
                    <input type="text" class="form-control" name="nombre_responsable" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Número de Teléfono:</label>
                    <input type="text" class="form-control" name="numero" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Generar PDF</button>
            </form>
        </div>

        <!-- Formulario de Accesorios -->
        <div class="tab-pane fade" id="accesorios" role="tabpanel">
            <h4 class="text-center">Responsiva de Accesorios</h4>
            <form action="generar_pdf.php" method="POST">
                <input type="hidden" name="tipo" value="Accesorios">
                <div class="mb-3">
                    <label class="form-label">Nombre del Responsable:</label>
                    <input type="text" class="form-control" name="nombre_responsable" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Descripción del Accesorio:</label>
                    <input type="text" class="form-control" name="descripcion" required>
                </div>
                <button type="submit" class="btn btn-warning w-100">Generar PDF</button>
            </form>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
