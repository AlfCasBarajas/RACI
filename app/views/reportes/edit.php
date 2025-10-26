<?php if (isset($data) && is_array($data)) extract($data); include __DIR__ . '/../header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php include __DIR__ . '/../sidebar.php'; ?>
        <main class="col-md-10 ms-sm-auto offset-md-2 px-4 main-content">
            <div style="border-radius: 1.2rem; box-shadow: 0 2px 12px rgba(30,40,90,0.10); background: #fff; border: none; padding: 2rem; margin-top: 2rem;">
                <div class="d-flex align-items-center mb-4">
                    <a href="?controller=reportes&action=index" class="btn btn-outline-secondary me-3" title="Volver">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    <h2 style="color: #1a237e; font-weight: 700; margin: 0;">
                        <i class="bi bi-file-text me-2"></i>Editar Reporte
                    </h2>
                </div>

                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <form method="post" action="?controller=reportes&action=update&id=<?= $reporte['id_reporte'] ?>">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nombre" class="form-label fw-semibold">Nombre del Reporte</label>
                                    <input type="text" name="nombre" id="nombre" class="form-control" 
                                           value="<?= htmlspecialchars($reporte['nombre']) ?>" 
                                           placeholder="Ej: Reporte mensual de incidentes" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="inspeccion_locativa_id_insp_loc" class="form-label fw-semibold">Inspección Locativa</label>
                                    <select name="inspeccion_locativa_id_insp_loc" id="inspeccion_locativa_id_insp_loc" class="form-select">
                                        <option value="">Selecciona inspección</option>
                                        <?php if (isset($inspeccioneslocativas)): foreach ($inspeccioneslocativas as $insp): ?>
                                            <option value="<?= $insp['id_insp_loc'] ?>" <?= (isset($reporte['inspeccion_locativa_id_insp_loc']) && $reporte['inspeccion_locativa_id_insp_loc'] == $insp['id_insp_loc']) ? 'selected' : '' ?>><?= htmlspecialchars($insp['tipo_inspeccion']) ?> - <?= date('d/m/Y H:i', strtotime($insp['fecha_hora'])) ?></option>
                                        <?php endforeach; endif; ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="descripcion" class="form-label fw-semibold">Descripción</label>
                                    <textarea name="descripcion" id="descripcion" class="form-control" rows="4" 
                                              placeholder="Descripción detallada del reporte..."><?= isset($reporte['descripcion']) ? htmlspecialchars($reporte['descripcion']) : '' ?></textarea>
                                </div>
                            </div>

                            <hr class="my-4">
                            
                            <div class="d-flex gap-2 justify-content-end">
                                <a href="?controller=reportes&action=index" class="btn btn-secondary">
                                    <i class="bi bi-x-circle me-1"></i>Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle me-1"></i>Actualizar Reporte
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include __DIR__ . '/../footer.php'; ?>
