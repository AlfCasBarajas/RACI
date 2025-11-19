<?php
if (isset($data) && is_array($data)) extract($data);
include __DIR__ . '/../header.php';
?>

<div class="container-fluid">
    <div class="row">
        <?php include __DIR__ . '/../sidebar.php'; ?>
        <main class="col-md-10 ms-sm-auto offset-md-2 px-4 main-content">
            <div class="container mt-4">
                <?php if (isset($_GET['pdf_saved'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle-fill"></i>
                        <strong>¡PDF guardado exitosamente!</strong> El archivo <code><?= htmlspecialchars($_GET['pdf_saved']) ?></code> se ha guardado.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                
                <?php if (isset($_GET['excel_saved'])): ?>
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <i class="bi bi-file-earmark-excel-fill"></i>
                        <strong>¡Excel guardado exitosamente!</strong> El archivo <code><?= htmlspecialchars($_GET['excel_saved']) ?></code> se ha guardado.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h2 class="card-title text-warning">
                            <i class="bi bi-exclamation-triangle me-2"></i>Reporte de Incidentes
                        </h2>
                        
                        <!-- Formulario de filtros -->
                        <form method="GET" action="" class="row g-3 align-items-center mb-3">
                            <input type="hidden" name="controller" value="reportes">
                            <input type="hidden" name="action" value="incidentes">
                            
                            <div class="col-auto">
                                <label for="tipo" class="form-label">Tipo</label>
                            </div>
                            <div class="col-auto">
                                <input type="text" id="tipo" name="tipo" class="form-control" 
                                       placeholder="Tipo de incidente" value="<?= htmlspecialchars($tipo ?? '') ?>">
                            </div>
                            <div class="col-auto">
                                <label for="fecha_inicio" class="form-label">Fecha inicio</label>
                            </div>
                            <div class="col-auto">
                                <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control" 
                                       value="<?= htmlspecialchars($fecha_inicio ?? '') ?>">
                            </div>
                            <div class="col-auto">
                                <label for="fecha_fin" class="form-label">Fecha fin</label>
                            </div>
                            <div class="col-auto">
                                <input type="date" id="fecha_fin" name="fecha_fin" class="form-control" 
                                       value="<?= htmlspecialchars($fecha_fin ?? '') ?>">
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary">Filtrar</button>
                            </div>
                            <div class="col-auto">
                                <a href="?controller=reportes&action=incidentes" class="btn btn-secondary">Limpiar filtros</a>
                            </div>
                        </form>
                        
                        <!-- Botones de descarga -->
                        <div class="mb-3">
                            <button class="btn btn-outline-danger me-2" id="descargar-pdf">
                                <i class="bi bi-file-earmark-pdf me-1"></i>Descargar PDF
                            </button>
                            <button class="btn btn-outline-success" id="descargar-excel">
                                <i class="bi bi-file-earmark-excel me-1"></i>Descargar Excel
                            </button>
                        </div>
                        
                        <!-- Tabla de incidentes -->
                        <div id="tabla-incidentes" class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Tipo</th>
                                        <th>Fecha y Hora</th>
                                        <th>Descripción</th>
                                        <th>Lugar</th>
                                        <th>Tipo Vinc. Laboral</th>
                                        <th>Jornada Laboral</th>
                                        <th>Turno/Momento</th>
                                        <th>Uso EPP</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($incidentes)): ?>
                                        <?php foreach ($incidentes as $incidente): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($incidente['id_incidente']) ?></td>
                                                <td><?= htmlspecialchars($incidente['tipo']) ?></td>
                                                <td><?= htmlspecialchars($incidente['fecha_hora']) ?></td>
                                                <td><?= htmlspecialchars($incidente['descripcion']) ?></td>
                                                <td><?= htmlspecialchars($incidente['lugar']) ?></td>
                                                <td><?= htmlspecialchars($incidente['tipo_vinc_lab'] ?? 'Sin especificar') ?></td>
                                                <td><?= htmlspecialchars($incidente['jornada_laboral'] ?? 'Sin especificar') ?></td>
                                                <td><?= htmlspecialchars($incidente['turno_mom_inc'] ?? 'Sin especificar') ?></td>
                                                <td><?= htmlspecialchars($incidente['uso_epp'] ?? 'Sin especificar') ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="9" class="text-center">No hay incidentes para mostrar</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="text-end mt-3">
                            <a href="?controller=reportes&action=index" class="btn btn-dark">
                                <i class="bi bi-arrow-left me-1"></i>Volver a Reportes
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
document.getElementById('descargar-pdf').onclick = function(e) {
    e.preventDefault();
    const tipo = document.getElementById('tipo').value;
    const fecha_inicio = document.getElementById('fecha_inicio').value;
    const fecha_fin = document.getElementById('fecha_fin').value;
    let url = '?controller=reportes&action=incidentes&format=pdf';
    if (tipo) url += '&tipo=' + encodeURIComponent(tipo);
    if (fecha_inicio) url += '&fecha_inicio=' + encodeURIComponent(fecha_inicio);
    if (fecha_fin) url += '&fecha_fin=' + encodeURIComponent(fecha_fin);
    window.location.href = url;
};

document.getElementById('descargar-excel').onclick = function(e) {
    e.preventDefault();
    const tipo = document.getElementById('tipo').value;
    const fecha_inicio = document.getElementById('fecha_inicio').value;
    const fecha_fin = document.getElementById('fecha_fin').value;
    let url = '?controller=reportes&action=incidentes&format=excel';
    if (tipo) url += '&tipo=' + encodeURIComponent(tipo);
    if (fecha_inicio) url += '&fecha_inicio=' + encodeURIComponent(fecha_inicio);
    if (fecha_fin) url += '&fecha_fin=' + encodeURIComponent(fecha_fin);
    window.location.href = url;
};
</script>

<?php include __DIR__ . '/../footer.php'; ?>