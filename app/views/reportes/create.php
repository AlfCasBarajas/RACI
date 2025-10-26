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
                        <i class="bi bi-file-text me-2"></i>Nuevo Reporte
                    </h2>
                </div>

                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <form method="post" action="?controller=reportes&action=generarEmpleado">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nombre" class="form-label fw-semibold">Nombre del Reporte</label>
                                    <input type="text" name="nombre" id="nombre" class="form-control" 
                                           placeholder="Ej: Reporte mensual de incidentes" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="fecha_actual" class="form-label fw-semibold">Fecha Actual</label>
                                    <input type="text" name="fecha_actual" id="fecha_actual" class="form-control" 
                                           value="<?= date('Y-m-d') ?>" readonly>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="descripcion" class="form-label fw-semibold">Descripción</label>
                                    <textarea name="descripcion" id="descripcion" class="form-control" rows="3" 
                                              placeholder="Descripción detallada del reporte..." required></textarea>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="inspeccion_locativa_id_insp_loc" class="form-label fw-semibold">Inspección Locativa</label>
                                    <select name="inspeccion_locativa_id_insp_loc" id="inspeccion_locativa_id_insp_loc" class="form-select" required>
                                        <option value="">Selecciona inspección</option>
                                        <?php if (isset($inspecciones) && is_array($inspecciones) && count($inspecciones) > 0): ?>
                                            <?php foreach ($inspecciones as $insp): ?>
                                                <option value="<?= $insp['id_insp_loc'] ?>"><?= $insp['id_insp_loc'] ?> - <?= htmlspecialchars($insp['tipo_inspeccion']) ?></option>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <option disabled>No hay inspecciones locativas registradas</option>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="tipo_reporte" class="form-label fw-semibold">Tipo de Reporte</label>
                                    <select name="tipo_reporte" id="tipo_reporte" class="form-select" required onchange="mostrarCampoEmpleado()">
                                        <option value="">Selecciona tipo de reporte</option>
                                        <option value="usuarios">Usuarios</option>
                                        <option value="empleados">Empleados</option>
                                        <option value="roles">Roles</option>
                                        <option value="inspecciones">Inspecciones</option>
                                        <option value="categoria">Categoría</option>
                                        <option value="area">Área</option>
                                        <option value="riesgo">Riesgo</option>
                                        <option value="condiciones_inseguras">Condiciones Inseguras</option>
                                        <option value="incidentes">Incidentes</option>
                                        <option value="accidentes">Accidentes</option>
                                        <option value="inspecciones_locativas">Inspecciones Locativas</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row" id="campoEmpleado" style="display:none;">
                                <div class="col-md-6 mb-3">
                                    <label for="empleado_id" class="form-label fw-semibold">ID o Número de Documento del Empleado</label>
                                    <input type="text" name="empleado_id" id="empleado_id" class="form-control" 
                                           placeholder="Ingrese el ID o número de documento">
                                </div>
                            </div>

                            <hr class="my-4">
                            
                            <div class="d-flex gap-2 justify-content-end">
                                <a href="?controller=reportes&action=index" class="btn btn-secondary">
                                    <i class="bi bi-x-circle me-1"></i>Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle me-1"></i>Generar Reporte
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <script>
                    function mostrarCampoEmpleado() {
                        var tipo = document.getElementById('tipo_reporte').value;
                        var campo = document.getElementById('campoEmpleado');
                        campo.style.display = (tipo === 'empleados') ? 'block' : 'none';
                    }
                    document.addEventListener('DOMContentLoaded', mostrarCampoEmpleado);
                </script>
                <?php if (!empty($reporteEmpleado)): ?>
                    <hr class="my-4">
                    
                    <?php if (!empty($inspeccionSeleccionada)): ?>
                        <div class="card mb-4">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0"><i class="bi bi-clipboard-check me-2"></i>Inspección Locativa Seleccionada</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6"><strong>ID Inspección:</strong> <?= htmlspecialchars($inspeccionSeleccionada['id_insp_loc']) ?></div>
                                    <div class="col-md-6"><strong>Tipo Inspección:</strong> <?= htmlspecialchars($inspeccionSeleccionada['tipo_inspeccion']) ?></div>
                                    <div class="col-md-6"><strong>Fecha y Hora:</strong> <?= htmlspecialchars($inspeccionSeleccionada['fecha_hora']) ?></div>
                                    <div class="col-md-6"><strong>Estado:</strong> <?= htmlspecialchars($inspeccionSeleccionada['estado_inspeccion']) ?></div>
                                    <div class="col-12 mt-2"><strong>Descripción:</strong> <?= htmlspecialchars($inspeccionSeleccionada['descripcion']) ?></div>
                                    <div class="col-12 mt-2"><strong>Observaciones:</strong> <?= htmlspecialchars($inspeccionSeleccionada['observaciones']) ?></div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($empleado) && !empty($nombre)): ?>
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle me-2"></i>El reporte ha sido guardado correctamente.
                        </div>
                    <?php endif; ?>
                    
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="bi bi-person-badge me-2"></i>Reporte de Incidentes y Accidentes del Empleado</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-4"><strong>ID Empleado:</strong> <?= htmlspecialchars($reporteEmpleado['id_empleado']) ?></div>
                                <div class="col-md-4"><strong>Nombres:</strong> <?= htmlspecialchars($reporteEmpleado['nombres']) ?></div>
                                <div class="col-md-4"><strong>Apellidos:</strong> <?= htmlspecialchars($reporteEmpleado['apellidos']) ?></div>
                            </div>
                            
                            <?php if (!empty($reporteEmpleado['incidentes'])): ?>
                                <h6 class="text-warning"><i class="bi bi-exclamation-triangle me-2"></i>Incidentes</h6>
                                <div class="row">
                                    <?php foreach ($reporteEmpleado['incidentes'] as $inc): ?>
                                        <div class="col-md-6 mb-2">
                                            <div class="card border-warning">
                                                <div class="card-body">
                                                    <div><strong>ID:</strong> <?= htmlspecialchars($inc['id_incidente']) ?></div>
                                                    <div><strong>Tipo:</strong> <?= htmlspecialchars($inc['tipo']) ?></div>
                                                    <div><strong>Fecha:</strong> <?= htmlspecialchars($inc['fecha_hora']) ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            
                            <?php if (!empty($reporteEmpleado['accidentes'])): ?>
                                <h6 class="text-danger mt-3"><i class="bi bi-exclamation-octagon me-2"></i>Accidentes</h6>
                                <div class="row">
                                    <?php foreach ($reporteEmpleado['accidentes'] as $acc): ?>
                                        <div class="col-md-6 mb-2">
                                            <div class="card border-danger">
                                                <div class="card-body">
                                                    <div><strong>ID:</strong> <?= htmlspecialchars($acc['id_accidente']) ?></div>
                                                    <div><strong>Tipo:</strong> <?= htmlspecialchars($acc['tipo']) ?></div>
                                                    <div><strong>Fecha:</strong> <?= htmlspecialchars($acc['fecha_hora']) ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            
                            <?php if (empty($reporteEmpleado['incidentes']) && empty($reporteEmpleado['accidentes'])): ?>
                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle me-2"></i>No hay incidentes ni accidentes registrados para este empleado.
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>
</div>

<?php include __DIR__ . '/../footer.php'; ?>
