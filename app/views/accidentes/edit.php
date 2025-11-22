<?php if (isset($data) && is_array($data)) extract($data); include __DIR__ . '/../header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php include __DIR__ . '/../sidebar.php'; ?>
        <main class="col-md-10 ms-sm-auto offset-md-2 px-4 main-content">
            <div style="border-radius: 1.2rem; box-shadow: 0 2px 12px rgba(30,40,90,0.10); background: #fff; border: none; padding: 2rem; margin-top: 2rem;">
                <div class="d-flex align-items-center mb-4">
                    <a href="?controller=accidentes&action=index" class="btn btn-outline-secondary me-3" title="Volver">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    <h2 style="color: #1a237e; font-weight: 700; margin: 0;">
                        <i class="bi bi-exclamation-octagon me-2"></i>Editar Accidente
                    </h2>
                </div>

                <!-- Mensajes de error -->
                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php
                        switch($_GET['error']) {
                            case 'area_required':
                                echo '<i class="bi bi-exclamation-triangle me-2"></i>Por favor seleccione un área para el accidente.';
                                break;
                            case 'database_error':
                                echo '<i class="bi bi-exclamation-triangle me-2"></i>Error al actualizar el accidente. Por favor inténtelo nuevamente.';
                                break;
                            default:
                                echo '<i class="bi bi-exclamation-triangle me-2"></i>Ha ocurrido un error. Por favor inténtelo nuevamente.';
                        }
                        ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <div class="row justify-content-center">
                    <div class="col-md-11">
                        <form method="post" action="?controller=accidentes&action=update&id=<?= $accidente['id_accidente'] ?>">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="tipo" class="form-label fw-semibold">Tipo</label>
                                    <input type="text" name="tipo" id="tipo" class="form-control" 
                                           value="<?= htmlspecialchars($accidente['tipo']) ?>" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="clasificacion" class="form-label fw-semibold">Clasificación</label>
                                    <input type="text" name="clasificacion" id="clasificacion" class="form-control" 
                                           value="<?= htmlspecialchars($accidente['clasificacion']) ?>">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="estado" class="form-label fw-semibold">Estado</label>
                                    <input type="text" name="estado" id="estado" class="form-control" 
                                           value="<?= htmlspecialchars($accidente['estado']) ?>">
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label for="fecha_hora" class="form-label fw-semibold">Fecha y Hora</label>
                                    <input type="datetime-local" name="fecha_hora" id="fecha_hora" class="form-control" 
                                           value="<?= date('Y-m-d\TH:i', strtotime($accidente['fecha_hora'])) ?>">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="lugar" class="form-label fw-semibold">Lugar</label>
                                    <input type="text" name="lugar" id="lugar" class="form-control" 
                                           value="<?= htmlspecialchars($accidente['lugar']) ?>">
                                </div>
                                <div class="col-md-3 mb-3">
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
                                    <div class="form-text">Seleccione el área donde ocurrió el accidente</div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="tipo_vinc_lab_" class="form-label fw-semibold">Tipo Vinculación Laboral</label>
                                    <input type="text" name="tipo_vinc_lab_" id="tipo_vinc_lab_" class="form-control" 
                                           value="<?= htmlspecialchars($accidente['tipo_vinc_lab_']) ?>">
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="descripcion" class="form-label fw-semibold">Descripción</label>
                                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3" 
                                              placeholder="Descripción detallada del accidente..."><?= htmlspecialchars($accidente['descripcion']) ?></textarea>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="jornada_laboral" class="form-label fw-semibold">Jornada Laboral</label>
                                    <input type="text" name="jornada_laboral" id="jornada_laboral" class="form-control" 
                                           value="<?= htmlspecialchars($accidente['jornada_laboral']) ?>">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="turno_mom_acc" class="form-label fw-semibold">Turno Momento Accidente</label>
                                    <input type="text" name="turno_mom_acc" id="turno_mom_acc" class="form-control" 
                                           value="<?= htmlspecialchars($accidente['turno_mom_acc']) ?>">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="uso_epp" class="form-label fw-semibold">Uso EPP</label>
                                    <input type="text" name="uso_epp" id="uso_epp" class="form-control" 
                                           value="<?= htmlspecialchars($accidente['uso_epp']) ?>">
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="consecuencias" class="form-label fw-semibold">Consecuencias</label>
                                    <input type="text" name="consecuencias" id="consecuencias" class="form-control" 
                                           value="<?= htmlspecialchars($accidente['consecuencias']) ?>">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="gravedad" class="form-label fw-semibold">Gravedad</label>
                                    <input type="text" name="gravedad" id="gravedad" class="form-control" 
                                           value="<?= htmlspecialchars($accidente['gravedad']) ?>">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="tipo_lesion" class="form-label fw-semibold">Tipo Lesión</label>
                                    <input type="text" name="tipo_lesion" id="tipo_lesion" class="form-control" 
                                           value="<?= htmlspecialchars($accidente['tipo_lesion']) ?>">
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="parte_cuerpo_afect" class="form-label fw-semibold">Parte Cuerpo Afectada</label>
                                    <input type="text" name="parte_cuerpo_afect" id="parte_cuerpo_afect" class="form-control" 
                                           value="<?= htmlspecialchars($accidente['parte_cuerpo_afect']) ?>">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="incapacidad_lab" class="form-label fw-semibold">Incapacidad Laboral</label>
                                    <input type="text" name="incapacidad_lab" id="incapacidad_lab" class="form-control" 
                                           value="<?= htmlspecialchars($accidente['incapacidad_lab']) ?>">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="aten_med_recibida" class="form-label fw-semibold">Atención Médica Recibida</label>
                                    <input type="text" name="aten_med_recibida" id="aten_med_recibida" class="form-control" 
                                           value="<?= htmlspecialchars($accidente['aten_med_recibida']) ?>">
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="persona_informo" class="form-label fw-semibold">Persona que Informó</label>
                                    <input type="text" name="persona_informo" id="persona_informo" class="form-control" 
                                           value="<?= htmlspecialchars($accidente['persona_informo']) ?>">
                                </div>
                            </div>

                            <hr class="my-4">
                            
                            <div class="d-flex gap-2 justify-content-end">
                                <a href="?controller=accidentes&action=index" class="btn btn-secondary">
                                    <i class="bi bi-x-circle me-1"></i>Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle me-1"></i>Actualizar Accidente
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
