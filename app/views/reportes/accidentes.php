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
                        <h2 class="card-title text-danger">
                            <i class="bi bi-activity me-2"></i>Reporte de Accidentes
                        </h2>
                        
                        <!-- Formulario de filtros -->
                        <form method="GET" action="" class="row g-3 align-items-center mb-3">
                            <input type="hidden" name="controller" value="reportes">
                            <input type="hidden" name="action" value="accidentes">
                            
                            <div class="col-auto">
                                <label for="tipo" class="form-label">Tipo</label>
                            </div>
                            <div class="col-auto">
                                <input type="text" id="tipo" name="tipo" class="form-control" 
                                       placeholder="Tipo de accidente" value="<?= htmlspecialchars($tipo ?? '') ?>">
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
                                <a href="?controller=reportes&action=accidentes" class="btn btn-secondary">Limpiar filtros</a>
                            </div>
                        </form>
                        
                        <!-- Botones de descarga -->
                        <?php if (!$isTrabajador): ?>
                        <div class="mb-3">
                            <button class="btn btn-outline-danger me-2" id="descargar-pdf">
                                <i class="bi bi-file-earmark-pdf me-1"></i>Descargar PDF
                            </button>
                            <button class="btn btn-outline-success" id="descargar-excel">
                                <i class="bi bi-file-earmark-excel me-1"></i>Descargar Excel
                            </button>
                        </div>
                        <?php endif; ?>
                        
                        <!-- Vista de accidentes en cards -->
                        <div id="tabla-accidentes">
                            <?php if (!empty($accidentes)): ?>
                                <div class="row">
                                    <?php foreach ($accidentes as $accidente): ?>
                                        <div class="col-md-6 col-lg-4 mb-4">
                                            <div class="card h-100">
                                                <div class="card-header bg-primary text-white">
                                                    <h6 class="card-title mb-0">
                                                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                                        Accidente #<?= htmlspecialchars($accidente['id_accidente']) ?>
                                                    </h6>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row g-2">
                                                        <div class="col-12">
                                                            <strong>Tipo:</strong><br>
                                                            <span class="badge bg-secondary"><?= htmlspecialchars($accidente['tipo']) ?></span>
                                                        </div>
                                                        <div class="col-12">
                                                            <strong>Fecha y Hora:</strong><br>
                                                            <?= isset($accidente['fecha_hora']) ? htmlspecialchars(date('d/m/Y H:i', strtotime($accidente['fecha_hora']))) : 'Sin especificar' ?>
                                                        </div>
                                                        <div class="col-12">
                                                            <strong>Descripción:</strong><br>
                                                            <small><?= htmlspecialchars($accidente['descripcion'] ?? 'Sin descripción') ?></small>
                                                        </div>
                                                        <div class="col-6">
                                                            <strong>Lugar:</strong><br>
                                                            <small><?= htmlspecialchars($accidente['lugar'] ?? 'Sin especificar') ?></small>
                                                        </div>
                                                        <div class="col-6">
                                                            <strong>Clasificación:</strong><br>
                                                            <small><?= htmlspecialchars($accidente['clasificacion'] ?? 'Sin clasificar') ?></small>
                                                        </div>
                                                        <div class="col-6">
                                                            <strong>Estado:</strong><br>
                                                            <span class="badge bg-info"><?= htmlspecialchars($accidente['estado'] ?? 'Sin estado') ?></span>
                                                        </div>
                                                        <div class="col-6">
                                                            <strong>Gravedad:</strong><br>
                                                            <span class="badge bg-warning"><?= htmlspecialchars($accidente['gravedad'] ?? 'Sin evaluar') ?></span>
                                                        </div>
                                                        <div class="col-6">
                                                            <strong>Tipo Lesión:</strong><br>
                                                            <small><?= htmlspecialchars($accidente['tipo_lesion'] ?? 'Sin especificar') ?></small>
                                                        </div>
                                                        <div class="col-6">
                                                            <strong>Parte Afectada:</strong><br>
                                                            <small><?= htmlspecialchars($accidente['parte_cuerpo_afect'] ?? 'Sin especificar') ?></small>
                                                        </div>
                                                        <div class="col-12">
                                                            <strong>Consecuencias:</strong><br>
                                                            <small><?= htmlspecialchars($accidente['consecuencias'] ?? 'Sin especificar') ?></small>
                                                        </div>
                                                        <div class="col-6">
                                                            <strong>Vinculación Laboral:</strong><br>
                                                            <small><?= htmlspecialchars($accidente['tipo_vinc_lab_'] ?? 'Sin especificar') ?></small>
                                                        </div>
                                                        <div class="col-6">
                                                            <strong>Jornada Laboral:</strong><br>
                                                            <small><?= htmlspecialchars($accidente['jornada_laboral'] ?? 'Sin especificar') ?></small>
                                                        </div>
                                                        <div class="col-6">
                                                            <strong>Turno/Momento:</strong><br>
                                                            <small><?= htmlspecialchars($accidente['turno_mom_acc'] ?? 'Sin especificar') ?></small>
                                                        </div>
                                                        <div class="col-6">
                                                            <strong>Uso EPP:</strong><br>
                                                            <small><?= htmlspecialchars($accidente['uso_epp'] ?? 'Sin especificar') ?></small>
                                                        </div>
                                                        <div class="col-6">
                                                            <strong>Incapacidad Laboral:</strong><br>
                                                            <small><?= htmlspecialchars($accidente['incapacidad_lab'] ?? 'Sin especificar') ?></small>
                                                        </div>
                                                        <div class="col-6">
                                                            <strong>Persona que Informó:</strong><br>
                                                            <small><?= htmlspecialchars($accidente['persona_informo'] ?? 'Sin especificar') ?></small>
                                                        </div>
                                                        <div class="col-12">
                                                            <strong>Atención Médica:</strong><br>
                                                            <small><?= htmlspecialchars($accidente['aten_med_recibida'] ?? 'Sin especificar') ?></small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <div class="text-center py-5">
                                    <i class="bi bi-inbox display-1 text-muted"></i>
                                    <h5 class="text-muted mt-3">No hay accidentes para mostrar</h5>
                                    <p class="text-muted">Los accidentes aparecerán aquí cuando se registren en el sistema.</p>
                                </div>
                            <?php endif; ?>
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
    let url = '?controller=reportes&action=accidentes&format=pdf';
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
    let url = '?controller=reportes&action=accidentes&format=excel';
    if (tipo) url += '&tipo=' + encodeURIComponent(tipo);
    if (fecha_inicio) url += '&fecha_inicio=' + encodeURIComponent(fecha_inicio);
    if (fecha_fin) url += '&fecha_fin=' + encodeURIComponent(fecha_fin);
    window.location.href = url;
};
</script>

<?php include __DIR__ . '/../footer.php'; ?>