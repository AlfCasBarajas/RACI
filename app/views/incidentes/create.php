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
                        <i class="bi bi-exclamation-triangle me-2"></i>Nuevo Incidente
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
                                echo '<i class="bi bi-exclamation-triangle me-2"></i>Error al guardar el incidente. Por favor inténtelo nuevamente.';
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
                        <form method="post" action="?controller=incidentes&action=store">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="tipo" class="form-label fw-semibold">Tipo de Incidente</label>
                                    <input type="text" class="form-control" id="tipo" name="tipo" 
                                           placeholder="Ej: Casi accidente, Condición insegura" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="fecha" class="form-label fw-semibold">Fecha</label>
                                    <input type="date" class="form-control" id="fecha" name="fecha" required>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="lugar" class="form-label fw-semibold">Lugar</label>
                                    <input type="text" class="form-control" id="lugar" name="lugar" 
                                           placeholder="Ubicación específica donde ocurrió el incidente">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="area_id" class="form-label fw-semibold">Área *</label>
                                    <select class="form-select" id="area_id" name="area_id" required>
                                        <option value="">Seleccionar área...</option>
                                        <?php if (isset($areas)): ?>
                                            <?php foreach ($areas as $area): ?>
                                                <option value="<?= $area['id_area'] ?>"><?= htmlspecialchars($area['nombre']) ?></option>
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
                                                <option value="<?= $empleado['id_empleado'] ?>"><?= htmlspecialchars($empleado['nombres'] . ' ' . $empleado['apellidos']) ?></option>
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
                                        <option value="Directo">Directo</option>
                                        <option value="Contratista">Contratista</option>
                                        <option value="Temporal">Temporal</option>
                                        <option value="Independiente">Independiente</option>
                                        <option value="Visitante">Visitante</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="jornada_laboral" class="form-label fw-semibold">Jornada Laboral</label>
                                    <select class="form-select" id="jornada_laboral" name="jornada_laboral">
                                        <option value="">Seleccionar jornada...</option>
                                        <option value="Diurna">Diurna</option>
                                        <option value="Nocturna">Nocturna</option>
                                        <option value="Mixta">Mixta</option>
                                        <option value="Por turnos">Por turnos</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="turno_mom_inc" class="form-label fw-semibold">Turno/Momento del Incidente</label>
                                    <select class="form-select" id="turno_mom_inc" name="turno_mom_inc">
                                        <option value="">Seleccionar turno/momento...</option>
                                        <option value="Mañana">Mañana</option>
                                        <option value="Tarde">Tarde</option>
                                        <option value="Noche">Noche</option>
                                        <option value="Madrugada">Madrugada</option>
                                        <option value="Inicio de turno">Inicio de turno</option>
                                        <option value="Mitad de turno">Mitad de turno</option>
                                        <option value="Final de turno">Final de turno</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="uso_epp" class="form-label fw-semibold">Uso de EPP</label>
                                    <textarea class="form-control" id="uso_epp" name="uso_epp" rows="3" 
                                              placeholder="Describir el uso de equipos de protección personal..."></textarea>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="descripcion" class="form-label fw-semibold">Descripción</label>
                                    <textarea class="form-control" id="descripcion" name="descripcion" rows="4" 
                                              placeholder="Descripción detallada del incidente..."></textarea>
                                </div>
                            </div>

                            <div class="d-flex gap-3 justify-content-end mt-4">
                                <a href="?controller=incidentes&action=index" class="btn btn-secondary">
                                    <i class="bi bi-x-circle me-1"></i>Cancelar
                                </a>
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-check-circle me-1"></i>Guardar Incidente
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
    
    if (areaSelect && empleadoSelect) {
        areaSelect.addEventListener('change', function() {
            const areaId = this.value;
            
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
                            empleadoSelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Error al cargar empleados:', error);
                    });
            }
        });
        
        // Deshabilitar empleado al cargar si no hay área seleccionada
        if (!areaSelect.value) {
            empleadoSelect.disabled = true;
        }
    }
});
</script>

<?php include __DIR__ . '/../footer.php'; ?>
