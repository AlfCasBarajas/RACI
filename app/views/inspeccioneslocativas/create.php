<?php if (isset($data) && is_array($data)) extract($data); include __DIR__ . '/../header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php include __DIR__ . '/../sidebar.php'; ?>
        <main class="col-md-10 ms-sm-auto offset-md-2 px-4 main-content">
            <div style="border-radius: 1.2rem; box-shadow: 0 2px 12px rgba(30,40,90,0.10); background: #fff; border: none; padding: 2rem; margin-top: 2rem;">
                <div class="d-flex align-items-center mb-4">
                    <a href="?controller=inspeccionlocativa&action=index" class="btn btn-outline-secondary me-3" title="Volver">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    <h2 style="color: #1a237e; font-weight: 700; margin: 0;">
                        <i class="bi bi-clipboard-check me-2"></i>Nueva Inspección Locativa
                    </h2>
                </div>

                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <form method="post" action="?controller=inspeccionlocativa&action=store">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="tipo_inspeccion" class="form-label fw-semibold">Tipo Inspección <span class="text-danger">*</span></label>
                                    <input type="text" name="tipo_inspeccion" id="tipo_inspeccion" class="form-control" 
                                           placeholder="Ej: Preventiva, Correctiva" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="fecha_hora" class="form-label fw-semibold">Fecha y Hora <span class="text-danger">*</span></label>
                                    <input type="datetime-local" name="fecha_hora" id="fecha_hora" class="form-control" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="estado_inspeccion" class="form-label fw-semibold">Estado Inspección <span class="text-danger">*</span></label>
                                    <input type="text" name="estado_inspeccion" id="estado_inspeccion" class="form-control" 
                                           placeholder="Ej: Programada, En proceso" required>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="descripcion" class="form-label fw-semibold">Descripción <span class="text-danger">*</span></label>
                                    <input type="text" name="descripcion" id="descripcion" class="form-control" 
                                           placeholder="Descripción de la inspección" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="element_trab" class="form-label fw-semibold">Elementos de Trabajo <span class="text-danger">*</span></label>
                                    <input type="text" name="element_trab" id="element_trab" class="form-control" 
                                           placeholder="Herramientas y equipos utilizados" required>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="observaciones" class="form-label fw-semibold">Observaciones <span class="text-danger">*</span></label>
                                    <textarea name="observaciones" id="observaciones" class="form-control" rows="3" 
                                              placeholder="Observaciones detalladas de la inspección..." required></textarea>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="categoria_id_categoria" class="form-label fw-semibold">Categoría <span class="text-danger">*</span></label>
                                    <select name="categoria_id_categoria" id="categoria_id_categoria" class="form-select" required>
                                        <option value="">Selecciona categoría</option>
                                        <?php if (isset($categorias)): foreach ($categorias as $cat): ?>
                                            <option value="<?= $cat['id_categoria'] ?>"><?= htmlspecialchars($cat['nombre']) ?></option>
                                        <?php endforeach; endif; ?>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="incidente_id_incidente" class="form-label fw-semibold">Incidente (Opcional)</label>
                                    <select name="incidente_id_incidente" id="incidente_id_incidente" class="form-select">
                                        <option value="">Selecciona incidente</option>
                                        <?php if (isset($incidentes)): foreach ($incidentes as $inc): ?>
                                            <option value="<?= $inc['id_incidente'] ?>"><?= htmlspecialchars($inc['tipo']) ?></option>
                                        <?php endforeach; endif; ?>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="accidente_id_accidente" class="form-label fw-semibold">Accidente (Opcional)</label>
                                    <select name="accidente_id_accidente" id="accidente_id_accidente" class="form-select">
                                        <option value="">Selecciona accidente</option>
                                        <?php if (isset($accidentes)): foreach ($accidentes as $acc): ?>
                                            <option value="<?= $acc['id_accidente'] ?>"><?= htmlspecialchars($acc['tipo']) ?></option>
                                        <?php endforeach; endif; ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="riesgo_id_riesgo" class="form-label fw-semibold">Riesgo (Opcional)</label>
                                    <select name="riesgo_id_riesgo" id="riesgo_id_riesgo" class="form-select">
                                        <option value="">Selecciona riesgo</option>
                                        <?php if (isset($riesgos)): foreach ($riesgos as $ries): ?>
                                            <option value="<?= $ries['id_riesgo'] ?>"><?= htmlspecialchars($ries['tipo']) ?></option>
                                        <?php endforeach; endif; ?>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="empleado_id_empleado" class="form-label fw-semibold">Empleado (Opcional)</label>
                                    <select name="empleado_id_empleado" id="empleado_id_empleado" class="form-select">
                                        <option value="">Selecciona empleado</option>
                                        <?php if (isset($empleados)): foreach ($empleados as $emp): ?>
                                            <option value="<?= $emp['id_empleado'] ?>"><?= htmlspecialchars($emp['nombres'] . ' ' . $emp['apellidos']) ?></option>
                                        <?php endforeach; endif; ?>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="area_id_area" class="form-label fw-semibold">Área <span class="text-danger">*</span></label>
                                    <select name="area_id_area" id="area_id_area" class="form-select" required>
                                        <option value="">Selecciona área</option>
                                        <?php if (isset($areas)): foreach ($areas as $area): ?>
                                            <option value="<?= $area['id_area'] ?>"><?= htmlspecialchars($area['nombre']) ?></option>
                                        <?php endforeach; endif; ?>
                                    </select>
                                </div>
                            </div>

                            <hr class="my-4">
                            
                            <div class="d-flex gap-2 justify-content-end">
                                <a href="?controller=inspeccionlocativa&action=index" class="btn btn-secondary">
                                    <i class="bi bi-x-circle me-1"></i>Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle me-1"></i>Guardar Inspección
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
