<?php if (isset($data) && is_array($data)) extract($data); include __DIR__ . '/../header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php include __DIR__ . '/../sidebar.php'; ?>
        <main class="col-md-10 ms-sm-auto offset-md-2 px-4 main-content">
            <div style="border-radius: 1.2rem; box-shadow: 0 2px 12px rgba(30,40,90,0.10); background: #fff; border: none; padding: 2rem; margin-top: 2rem;">
                <div class="d-flex align-items-center mb-4">
                    <a href="?controller=incidentes&action=index" class="btn btn-outline-secondary me-3" title="Volver">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    <h2 style="color: #1a237e; font-weight: 700; margin: 0;">
                        <i class="bi bi-exclamation-triangle me-2"></i>Editar Incidente
                    </h2>
                </div>

                <!-- Mensajes de error -->
                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php
                        switch($_GET['error']) {
                            case 'area_required':
                                echo '<i class="bi bi-exclamation-triangle me-2"></i>Por favor seleccione un área para el incidente.';
                                break;
                            case 'database_error':
                                echo '<i class="bi bi-exclamation-triangle me-2"></i>Error al actualizar el incidente. Por favor inténtelo nuevamente.';
                                break;
                            default:
                                echo '<i class="bi bi-exclamation-triangle me-2"></i>Ha ocurrido un error. Por favor inténtelo nuevamente.';
                        }
                        ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <form method="post" action="?controller=incidentes&action=update&id=<?= $incidente['id_incidente'] ?>">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="tipo" class="form-label fw-semibold">Tipo de Incidente</label>
                                    <input type="text" class="form-control" id="tipo" name="tipo" 
                                           value="<?= htmlspecialchars($incidente['tipo']) ?>" 
                                           placeholder="Ej: Derrame, Caída, etc." required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="fecha" class="form-label fw-semibold">Fecha</label>
                                    <input type="date" class="form-control" id="fecha" name="fecha" 
                                           value="<?= isset($incidente['fecha_hora']) ? htmlspecialchars(substr($incidente['fecha_hora'],0,10)) : '' ?>" required>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="lugar" class="form-label fw-semibold">Lugar</label>
                                    <input type="text" class="form-control" id="lugar" name="lugar" 
                                           value="<?= htmlspecialchars($incidente['lugar']) ?>" 
                                           placeholder="Ubicación del incidente">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="area_id" class="form-label fw-semibold">Área *</label>
                                    <select class="form-select" id="area_id" name="area_id" required>
                                        <option value="">Seleccionar área...</option>
                                        <?php if (isset($areas)): ?>
                                            <?php foreach ($areas as $area): ?>
                                                <option value="<?= $area['id_area'] ?>" 
                                                        <?= (isset($area_actual) && $area_actual == $area['id_area']) ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($area['nombre']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                    <div class="form-text">Seleccione el área donde ocurrió el incidente</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="empleado_id" class="form-label fw-semibold">Empleado *</label>
                                    <select class="form-select" id="empleado_id" name="empleado_id" required>
                                        <option value="">Seleccionar empleado...</option>
                                        <?php if (isset($empleados)): ?>
                                            <?php foreach ($empleados as $empleado): ?>
                                                <option value="<?= $empleado['id_empleado'] ?>" 
                                                        <?= (isset($incidente['empleado_id_empleado']) && $incidente['empleado_id_empleado'] == $empleado['id_empleado']) ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($empleado['nombres'] . ' ' . $empleado['apellidos']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                    <div class="form-text">Seleccione el empleado involucrado en el incidente</div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="tipo_vinc_lab" class="form-label fw-semibold">Tipo de Vinculación Laboral</label>
                                    <select class="form-select" id="tipo_vinc_lab" name="tipo_vinc_lab">
                                        <option value="">Seleccionar tipo de vinculación...</option>
                                        <option value="Directo" <?= (isset($incidente['tipo_vinc_lab']) && $incidente['tipo_vinc_lab'] == 'Directo') ? 'selected' : '' ?>>Directo</option>
                                        <option value="Contratista" <?= (isset($incidente['tipo_vinc_lab']) && $incidente['tipo_vinc_lab'] == 'Contratista') ? 'selected' : '' ?>>Contratista</option>
                                        <option value="Temporal" <?= (isset($incidente['tipo_vinc_lab']) && $incidente['tipo_vinc_lab'] == 'Temporal') ? 'selected' : '' ?>>Temporal</option>
                                        <option value="Independiente" <?= (isset($incidente['tipo_vinc_lab']) && $incidente['tipo_vinc_lab'] == 'Independiente') ? 'selected' : '' ?>>Independiente</option>
                                        <option value="Visitante" <?= (isset($incidente['tipo_vinc_lab']) && $incidente['tipo_vinc_lab'] == 'Visitante') ? 'selected' : '' ?>>Visitante</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="jornada_laboral" class="form-label fw-semibold">Jornada Laboral</label>
                                    <select class="form-select" id="jornada_laboral" name="jornada_laboral">
                                        <option value="">Seleccionar jornada...</option>
                                        <option value="Diurna" <?= (isset($incidente['jornada_laboral']) && $incidente['jornada_laboral'] == 'Diurna') ? 'selected' : '' ?>>Diurna</option>
                                        <option value="Nocturna" <?= (isset($incidente['jornada_laboral']) && $incidente['jornada_laboral'] == 'Nocturna') ? 'selected' : '' ?>>Nocturna</option>
                                        <option value="Mixta" <?= (isset($incidente['jornada_laboral']) && $incidente['jornada_laboral'] == 'Mixta') ? 'selected' : '' ?>>Mixta</option>
                                        <option value="Por turnos" <?= (isset($incidente['jornada_laboral']) && $incidente['jornada_laboral'] == 'Por turnos') ? 'selected' : '' ?>>Por turnos</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="turno_mom_inc" class="form-label fw-semibold">Turno/Momento del Incidente</label>
                                    <select class="form-select" id="turno_mom_inc" name="turno_mom_inc">
                                        <option value="">Seleccionar turno/momento...</option>
                                        <option value="Mañana" <?= (isset($incidente['turno_mom_inc']) && $incidente['turno_mom_inc'] == 'Mañana') ? 'selected' : '' ?>>Mañana</option>
                                        <option value="Tarde" <?= (isset($incidente['turno_mom_inc']) && $incidente['turno_mom_inc'] == 'Tarde') ? 'selected' : '' ?>>Tarde</option>
                                        <option value="Noche" <?= (isset($incidente['turno_mom_inc']) && $incidente['turno_mom_inc'] == 'Noche') ? 'selected' : '' ?>>Noche</option>
                                        <option value="Madrugada" <?= (isset($incidente['turno_mom_inc']) && $incidente['turno_mom_inc'] == 'Madrugada') ? 'selected' : '' ?>>Madrugada</option>
                                        <option value="Inicio de turno" <?= (isset($incidente['turno_mom_inc']) && $incidente['turno_mom_inc'] == 'Inicio de turno') ? 'selected' : '' ?>>Inicio de turno</option>
                                        <option value="Mitad de turno" <?= (isset($incidente['turno_mom_inc']) && $incidente['turno_mom_inc'] == 'Mitad de turno') ? 'selected' : '' ?>>Mitad de turno</option>
                                        <option value="Final de turno" <?= (isset($incidente['turno_mom_inc']) && $incidente['turno_mom_inc'] == 'Final de turno') ? 'selected' : '' ?>>Final de turno</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="uso_epp" class="form-label fw-semibold">Uso de EPP</label>
                                    <textarea class="form-control" id="uso_epp" name="uso_epp" rows="3" 
                                              placeholder="Describir el uso de equipos de protección personal..."><?= htmlspecialchars($incidente['uso_epp'] ?? '') ?></textarea>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="descripcion" class="form-label fw-semibold">Descripción</label>
                                    <textarea class="form-control" id="descripcion" name="descripcion" rows="4" 
                                              placeholder="Descripción detallada del incidente..."><?= htmlspecialchars($incidente['descripcion']) ?></textarea>
                                </div>
                            </div>

                            <hr class="my-4">
                            
                            <div class="d-flex gap-2 justify-content-end">
                                <a href="?controller=incidentes&action=index" class="btn btn-secondary">
                                    <i class="bi bi-x-circle me-1"></i>Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle me-1"></i>Actualizar Incidente
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
    const areaSelect = document.getElementById('area_id');
    const empleadoSelect = document.getElementById('empleado_id');
    const currentEmpleadoId = empleadoSelect.value; // Guardar el empleado actual
    
    if (areaSelect && empleadoSelect) {
        function loadEmpleadosByArea(areaId, selectedEmpleadoId = null) {
            // Limpiar opciones del empleado
            empleadoSelect.innerHTML = '<option value="">Seleccionar empleado...</option>';
            empleadoSelect.disabled = !areaId;
            
            if (areaId) {
                fetch(`?controller=empleados&action=getByArea&area_id=${areaId}`)
                    .then(response => response.json())
                    .then(empleados => {
                        empleados.forEach(empleado => {
                            const option = document.createElement('option');
                            option.value = empleado.id_empleado;
                            option.textContent = `${empleado.nombres} ${empleado.apellidos}`;
                            
                            // Mantener la selección actual si existe
                            if (selectedEmpleadoId && empleado.id_empleado == selectedEmpleadoId) {
                                option.selected = true;
                            }
                            
                            empleadoSelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Error al cargar empleados:', error);
                    });
            }
        }
        
        areaSelect.addEventListener('change', function() {
            loadEmpleadosByArea(this.value);
        });
        
        // Cargar empleados al inicializar si hay un área seleccionada
        if (areaSelect.value) {
            loadEmpleadosByArea(areaSelect.value, currentEmpleadoId);
        } else {
            empleadoSelect.disabled = true;
        }
    }
});
</script>

<?php include __DIR__ . '/../footer.php'; ?>
