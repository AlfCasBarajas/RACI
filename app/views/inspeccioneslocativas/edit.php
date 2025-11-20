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
                        <i class="bi bi-clipboard-check me-2"></i>Editar Inspección Locativa
                    </h2>
                </div>

                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <form method="post" action="?controller=inspeccionlocativa&action=update&id=<?= $inspeccion['id_insp_loc'] ?>">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="tipo_inspeccion" class="form-label fw-semibold">Tipo Inspección <span class="text-danger">*</span></label>
                                    <input type="text" name="tipo_inspeccion" id="tipo_inspeccion" class="form-control" 
                                           value="<?= htmlspecialchars($inspeccion['tipo_inspeccion']) ?>" 
                                           placeholder="Ej: Preventiva, Correctiva" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="fecha_hora" class="form-label fw-semibold">Fecha y Hora <span class="text-danger">*</span></label>
                                    <input type="datetime-local" name="fecha_hora" id="fecha_hora" class="form-control" 
                                           value="<?= date('Y-m-d\TH:i', strtotime($inspeccion['fecha_hora'])) ?>" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="estado_inspeccion" class="form-label fw-semibold">Estado Inspección <span class="text-danger">*</span></label>
                                    <input type="text" name="estado_inspeccion" id="estado_inspeccion" class="form-control" 
                                           value="<?= htmlspecialchars($inspeccion['estado_inspeccion']) ?>" 
                                           placeholder="Ej: Programada, En proceso" required>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="descripcion" class="form-label fw-semibold">Descripción <span class="text-danger">*</span></label>
                                    <input type="text" name="descripcion" id="descripcion" class="form-control" 
                                           value="<?= htmlspecialchars($inspeccion['descripcion']) ?>" 
                                           placeholder="Descripción de la inspección" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="element_trab" class="form-label fw-semibold">Elementos de Trabajo <span class="text-danger">*</span></label>
                                    <input type="text" name="element_trab" id="element_trab" class="form-control" 
                                           value="<?= htmlspecialchars($inspeccion['element_trab']) ?>" 
                                           placeholder="Herramientas y equipos utilizados" required>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="observaciones" class="form-label fw-semibold">Observaciones <span class="text-danger">*</span></label>
                                    <textarea name="observaciones" id="observaciones" class="form-control" rows="3" 
                                              placeholder="Observaciones detalladas de la inspección..." required><?= htmlspecialchars($inspeccion['observaciones']) ?></textarea>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="categoria_id_categoria" class="form-label fw-semibold">Categoría <span class="text-danger">*</span></label>
                                    <select name="categoria_id_categoria" id="categoria_id_categoria" class="form-select" required>
                                        <option value="">Selecciona categoría</option>
                                        <?php if (isset($categorias)): foreach ($categorias as $cat): ?>
                                            <?php
                                            // Manejar campos NULL
                                            $empleadoNombre = !empty($cat['nombres']) && !empty($cat['apellidos']) 
                                                ? $cat['nombres'] . ' ' . $cat['apellidos'] 
                                                : 'Sin empleado asignado';
                                            $areaNombre = !empty($cat['area_nombre']) ? $cat['area_nombre'] : 'Sin área asignada';
                                            ?>
                                            <option value="<?= $cat['id_categoria'] ?>" 
                                                    data-empleado-id="<?= $cat['empleado_id_empleado'] ?? '' ?>" 
                                                    data-empleado-nombre="<?= htmlspecialchars($empleadoNombre) ?>" 
                                                    data-area-id="<?= $cat['area_id_area'] ?? '' ?>" 
                                                    data-area-nombre="<?= htmlspecialchars($areaNombre) ?>"
                                                    <?= ($inspeccion['categoria_id_categoria'] == $cat['id_categoria']) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($cat['nombre']) ?>
                                            </option>
                                        <?php endforeach; endif; ?>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="incidente_id_incidente" class="form-label fw-semibold">Incidente (Opcional)</label>
                                    <select name="incidente_id_incidente" id="incidente_id_incidente" class="form-select">
                                        <option value="">Selecciona incidente</option>
                                        <?php if (isset($incidentes)): foreach ($incidentes as $inc): ?>
                                            <option value="<?= $inc['id_incidente'] ?>" <?= ($inspeccion['incidente_id_incidente'] == $inc['id_incidente']) ? 'selected' : '' ?>><?= htmlspecialchars($inc['tipo']) ?></option>
                                        <?php endforeach; endif; ?>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="accidente_id_accidente" class="form-label fw-semibold">Accidente (Opcional)</label>
                                    <select name="accidente_id_accidente" id="accidente_id_accidente" class="form-select">
                                        <option value="">Selecciona accidente</option>
                                        <?php if (isset($accidentes)): foreach ($accidentes as $acc): ?>
                                            <option value="<?= $acc['id_accidente'] ?>" <?= ($inspeccion['accidente_id_accidente'] == $acc['id_accidente']) ? 'selected' : '' ?>><?= htmlspecialchars($acc['tipo']) ?></option>
                                        <?php endforeach; endif; ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="condicion_insegura" class="form-label fw-semibold">Condición Insegura (Opcional)</label>
                                    <select name="condicion_insegura" id="condicion_insegura" class="form-select">
                                        <option value="">Selecciona condición insegura</option>
                                        <?php if (isset($condiciones_inseguras)): foreach ($condiciones_inseguras as $cond): ?>
                                            <?php
                                            // Obtener la condición insegura asociada al riesgo actual si existe
                                            $selected = '';
                                            if (!empty($inspeccion['riesgo_id_riesgo'])) {
                                                // Buscar la condición insegura del riesgo seleccionado
                                                foreach ($riesgos as $riesgo) {
                                                    if ($riesgo['id_riesgo'] == $inspeccion['riesgo_id_riesgo'] && 
                                                        $riesgo['condicion_insegura_id_cond_inseg'] == $cond['id_cond_inseg']) {
                                                        $selected = 'selected';
                                                        break;
                                                    }
                                                }
                                            }
                                            ?>
                                            <option value="<?= $cond['id_cond_inseg'] ?>" <?= $selected ?>><?= htmlspecialchars($cond['nombre']) ?></option>
                                        <?php endforeach; endif; ?>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="riesgo_id_riesgo" class="form-label fw-semibold">Riesgo <span id="riesgo_required" class="text-danger" style="display: none;">*</span></label>
                                    <select name="riesgo_id_riesgo" id="riesgo_id_riesgo" class="form-select">
                                        <option value="">Selecciona riesgo</option>
                                        <?php if (isset($riesgos)): foreach ($riesgos as $ries): ?>
                                            <option value="<?= $ries['id_riesgo'] ?>" data-condicion="<?= $ries['condicion_insegura_id_cond_inseg'] ?>" <?= ($inspeccion['riesgo_id_riesgo'] == $ries['id_riesgo']) ? 'selected' : '' ?>><?= htmlspecialchars($ries['tipo']) ?></option>
                                        <?php endforeach; endif; ?>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="empleado_id_empleado" class="form-label fw-semibold">Empleado <span class="text-danger">*</span></label>
                                    <select name="empleado_id_empleado" id="empleado_id_empleado" class="form-select" required>
                                        <option value="">Selecciona empleado</option>
                                        <?php if (isset($empleados)): foreach ($empleados as $emp): ?>
                                            <option value="<?= $emp['id_empleado'] ?>" <?= (isset($inspeccion['empleado_id_empleado']) && $inspeccion['empleado_id_empleado'] == $emp['id_empleado']) ? 'selected' : '' ?>><?= htmlspecialchars($emp['nombres'] . ' ' . $emp['apellidos']) ?></option>
                                        <?php endforeach; endif; ?>
                                    </select>
                                    <input type="hidden" name="empleado_id_empleado_hidden" id="empleado_id_empleado_hidden" value="<?= isset($inspeccion['empleado_id_empleado']) ? $inspeccion['empleado_id_empleado'] : '' ?>">
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="area_id_area" class="form-label fw-semibold">Área <span class="text-danger">*</span></label>
                                    <select name="area_id_area" id="area_id_area" class="form-select" required>
                                        <option value="">Selecciona área</option>
                                        <?php if (isset($areas)): foreach ($areas as $area): ?>
                                            <option value="<?= $area['id_area'] ?>" <?= (isset($inspeccion['area_id_area']) && $inspeccion['area_id_area'] == $area['id_area']) ? 'selected' : '' ?>><?= htmlspecialchars($area['nombre']) ?></option>
                                        <?php endforeach; endif; ?>
                                    </select>
                                    <input type="hidden" name="area_id_area_hidden" id="area_id_area_hidden" value="<?= isset($inspeccion['area_id_area']) ? $inspeccion['area_id_area'] : '' ?>">
                                </div>
                            </div>

                            <hr class="my-4">
                            
                            <div class="d-flex gap-2 justify-content-end">
                                <a href="?controller=inspeccionlocativa&action=index" class="btn btn-secondary">
                                    <i class="bi bi-x-circle me-1"></i>Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle me-1"></i>Actualizar Inspección
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const categoriaSelect = document.getElementById('categoria_id_categoria');
    const empleadoSelect = document.getElementById('empleado_id_empleado');
    const empleadoHidden = document.getElementById('empleado_id_empleado_hidden');
    const areaSelect = document.getElementById('area_id_area');
    const areaHidden = document.getElementById('area_id_area_hidden');
    const condicionInseguraSelect = document.getElementById('condicion_insegura');
    const riesgoSelect = document.getElementById('riesgo_id_riesgo');
    const riesgoRequired = document.getElementById('riesgo_required');
    
    // Función para actualizar empleado y área basado en categoría
    function updateEmpleadoAndArea() {
        if (categoriaSelect.value) {
            const selectedOption = categoriaSelect.options[categoriaSelect.selectedIndex];
            const empleadoId = selectedOption.getAttribute('data-empleado-id');
            const empleadoNombre = selectedOption.getAttribute('data-empleado-nombre');
            const areaId = selectedOption.getAttribute('data-area-id');
            const areaNombre = selectedOption.getAttribute('data-area-nombre');
            
            if (empleadoId && areaId) {
                // Actualizar empleado
                empleadoSelect.value = empleadoId;
                empleadoHidden.value = empleadoId;
                
                // Actualizar área
                areaSelect.value = areaId;
                areaHidden.value = areaId;
            }
        }
    }
    
    // Función para actualizar requisitos de riesgo basado en condición insegura
    function updateRiesgoRequirement() {
        if (condicionInseguraSelect.value) {
            // Si hay condición insegura seleccionada, hacer riesgo obligatorio
            riesgoSelect.setAttribute('required', 'required');
            riesgoRequired.style.display = 'inline';
            
            // Filtrar riesgos por condición insegura
            const selectedCondicion = condicionInseguraSelect.value;
            Array.from(riesgoSelect.options).forEach(option => {
                if (option.value === '') {
                    option.style.display = 'block';
                    return;
                }
                
                const condicionRiesgo = option.getAttribute('data-condicion');
                if (condicionRiesgo === selectedCondicion) {
                    option.style.display = 'block';
                } else {
                    option.style.display = 'none';
                    if (option.selected) {
                        riesgoSelect.value = '';
                    }
                }
            });
        } else {
            // Si no hay condición insegura, riesgo es opcional
            riesgoSelect.removeAttribute('required');
            riesgoRequired.style.display = 'none';
            
            // Mostrar todos los riesgos
            Array.from(riesgoSelect.options).forEach(option => {
                option.style.display = 'block';
            });
        }
    }
    
    // Event listeners
    categoriaSelect.addEventListener('change', updateEmpleadoAndArea);
    condicionInseguraSelect.addEventListener('change', updateRiesgoRequirement);
    
    // También actualizar condición insegura cuando se selecciona un riesgo
    riesgoSelect.addEventListener('change', function() {
        if (this.value) {
            const selectedOption = this.options[this.selectedIndex];
            const condicionId = selectedOption.getAttribute('data-condicion');
            if (condicionId) {
                condicionInseguraSelect.value = condicionId;
                updateRiesgoRequirement();
            }
        }
    });
    
    // Ejecutar validación inicial
    updateRiesgoRequirement();
    
    // Interceptar envío del formulario para usar valores hidden si es necesario
    document.querySelector('form').addEventListener('submit', function(e) {
        if (empleadoHidden.value && empleadoSelect.value !== empleadoHidden.value) {
            empleadoSelect.value = empleadoHidden.value;
        }
        if (areaHidden.value && areaSelect.value !== areaHidden.value) {
            areaSelect.value = areaHidden.value;
        }
    });
});
</script>

<?php include __DIR__ . '/../footer.php'; ?>
