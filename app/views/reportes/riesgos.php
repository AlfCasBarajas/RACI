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
                        <h2 class="card-title text-secondary">
                            <i class="bi bi-shield-check me-2"></i>Reporte de Riesgos
                        </h2>
                        
                        <!-- Formulario de filtros -->
                        <form method="GET" action="" class="row g-3 align-items-center mb-3">
                            <input type="hidden" name="controller" value="reportes">
                            <input type="hidden" name="action" value="riesgos">
                            
                            <div class="col-auto">
                                <label for="tipo" class="form-label">Filtrar por tipo</label>
                            </div>
                            <div class="col-auto">
                                <input type="text" id="tipo" name="tipo" class="form-control" 
                                       placeholder="Tipo de riesgo" value="<?= htmlspecialchars($tipo ?? '') ?>">
                            </div>
                            <div class="col-auto">
                                <label for="area" class="form-label">Área</label>
                            </div>
                            <div class="col-auto">
                                <select id="area" name="area" class="form-select">
                                    <option value="">Todas las áreas</option>
                                    <?php if (isset($areas) && !empty($areas)): ?>
                                        <?php foreach ($areas as $areaOption): ?>
                                            <option value="<?= htmlspecialchars($areaOption['id_area']) ?>" 
                                                    <?= (isset($area) && $area == $areaOption['id_area']) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($areaOption['nombre']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary">Filtrar</button>
                            </div>
                            <div class="col-auto">
                                <a href="?controller=reportes&action=riesgos" class="btn btn-secondary">Limpiar filtros</a>
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
                        
                        <!-- Tabla de riesgos -->
                        <div id="tabla-riesgos" class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Tipo</th>
                                        <th>Descripción</th>
                                        <th>Condición Insegura</th>
                                        <th>Área</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($riesgos)): ?>
                                        <?php foreach ($riesgos as $riesgo): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($riesgo['id_riesgo']) ?></td>
                                                <td><?= htmlspecialchars($riesgo['tipo']) ?></td>
                                                <td><?= htmlspecialchars($riesgo['descripcion']) ?></td>
                                                <td><?= htmlspecialchars($riesgo['condicion_nombre'] ?? 'Sin condición asociada') ?></td>
                                                <td><?= htmlspecialchars($riesgo['nombre_area'] ?? 'Sin área asignada') ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center">No hay riesgos para mostrar</td>
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
    const area = document.getElementById('area').value;
    let url = '?controller=reportes&action=riesgos&format=pdf';
    if (tipo) url += '&tipo=' + encodeURIComponent(tipo);
    if (area) url += '&area=' + encodeURIComponent(area);
    window.location.href = url;
};

document.getElementById('descargar-excel').onclick = function(e) {
    e.preventDefault();
    const tipo = document.getElementById('tipo').value;
    const area = document.getElementById('area').value;
    let url = '?controller=reportes&action=riesgos&format=excel';
    if (tipo) url += '&tipo=' + encodeURIComponent(tipo);
    if (area) url += '&area=' + encodeURIComponent(area);
    window.location.href = url;
};
</script>

<?php include __DIR__ . '/../footer.php'; ?>