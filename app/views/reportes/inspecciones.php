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
                        <h2 class="card-title text-primary">
                            <i class="bi bi-clipboard-check me-2"></i>Reporte de Inspecciones Locativas
                        </h2>
                        
                        <!-- Formulario de filtros -->
                        <form method="GET" action="" class="row g-3 align-items-center mb-3">
                            <input type="hidden" name="controller" value="reportes">
                            <input type="hidden" name="action" value="inspecciones">
                            
                            <div class="col-auto">
                                <label for="tipo_inspeccion" class="form-label">Tipo</label>
                            </div>
                            <div class="col-auto">
                                <select id="tipo_inspeccion" name="tipo_inspeccion" class="form-select">
                                    <option value="">Todos los tipos</option>
                                    <?php if (!empty($tipos_inspeccion)): ?>
                                        <?php foreach ($tipos_inspeccion as $tipo): ?>
                                            <option value="<?= htmlspecialchars($tipo) ?>" 
                                                    <?= ($tipo_inspeccion == $tipo) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($tipo) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
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
                                <a href="?controller=reportes&action=inspecciones" class="btn btn-secondary">Limpiar filtros</a>
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
                        
                        <!-- Tabla de inspecciones -->
                        <div id="tabla-inspecciones" class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Tipo Inspección</th>
                                        <th>Fecha y Hora</th>
                                        <th>Estado</th>
                                        <th>Elemento Trabajo</th>
                                        <th>Descripción</th>
                                        <th>Observaciones</th>
                                        <th>Categoría</th>
                                        <th>Incidente</th>
                                        <th>Accidente</th>
                                        <th>Riesgo</th>
                                        <th>Empleado</th>
                                        <th>Área</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($inspecciones)): ?>
                                        <?php foreach ($inspecciones as $inspeccion): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($inspeccion['id_insp_loc'] ?? 'Sin especificar') ?></td>
                                                <td><?= htmlspecialchars($inspeccion['tipo_inspeccion'] ?? 'Sin especificar') ?></td>
                                                <td><?= isset($inspeccion['fecha_hora']) ? htmlspecialchars(date('d/m/Y H:i', strtotime($inspeccion['fecha_hora']))) : 'Sin especificar' ?></td>
                                                <td><?= htmlspecialchars($inspeccion['estado_inspeccion'] ?? 'Sin especificar') ?></td>
                                                <td><?= htmlspecialchars($inspeccion['element_trab'] ?? 'Sin especificar') ?></td>
                                                <td><?= htmlspecialchars($inspeccion['descripcion'] ?? 'Sin especificar') ?></td>
                                                <td><?= htmlspecialchars($inspeccion['observaciones'] ?? 'Sin especificar') ?></td>
                                                <td><?= htmlspecialchars($inspeccion['categoria_nombre'] ?? 'Sin especificar') ?></td>
                                                <td><?= htmlspecialchars($inspeccion['incidente_tipo'] ?? 'Sin especificar') ?></td>
                                                <td><?= htmlspecialchars($inspeccion['accidente_tipo'] ?? 'Sin especificar') ?></td>
                                                <td><?= htmlspecialchars($inspeccion['riesgo_tipo'] ?? 'Sin especificar') ?></td>
                                                <td><?= !empty($inspeccion['empleado_nombre']) ? htmlspecialchars($inspeccion['empleado_nombre']) : 'Sin empleado' ?></td>
                                                <td><?= !empty($inspeccion['area_nombre']) ? htmlspecialchars($inspeccion['area_nombre']) : 'Sin área' ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="13" class="text-center">No hay inspecciones para mostrar</td>
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
    const fecha_inicio = document.getElementById('fecha_inicio').value;
    const fecha_fin = document.getElementById('fecha_fin').value;
    const tipo_inspeccion = document.getElementById('tipo_inspeccion').value;
    let url = '?controller=reportes&action=inspecciones&format=pdf';
    if (tipo_inspeccion) url += '&tipo_inspeccion=' + encodeURIComponent(tipo_inspeccion);
    if (fecha_inicio) url += '&fecha_inicio=' + encodeURIComponent(fecha_inicio);
    if (fecha_fin) url += '&fecha_fin=' + encodeURIComponent(fecha_fin);
    window.location.href = url;
};

document.getElementById('descargar-excel').onclick = function(e) {
    e.preventDefault();
    const fecha_inicio = document.getElementById('fecha_inicio').value;
    const fecha_fin = document.getElementById('fecha_fin').value;
    const tipo_inspeccion = document.getElementById('tipo_inspeccion').value;
    let url = '?controller=reportes&action=inspecciones&format=excel';
    if (tipo_inspeccion) url += '&tipo_inspeccion=' + encodeURIComponent(tipo_inspeccion);
    if (fecha_inicio) url += '&fecha_inicio=' + encodeURIComponent(fecha_inicio);
    if (fecha_fin) url += '&fecha_fin=' + encodeURIComponent(fecha_fin);
    window.location.href = url;
};
</script>

<?php include __DIR__ . '/../footer.php'; ?>