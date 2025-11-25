<?php if (isset($data) && is_array($data)) extract($data); include __DIR__ . '/../header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php include __DIR__ . '/../sidebar.php'; ?>
        <main class="col-md-10 ms-sm-auto offset-md-2 px-4 main-content">
            <div style="border-radius: 1.2rem; box-shadow: 0 2px 12px rgba(30,40,90,0.10); background: #fff; border: none; padding: 2rem; margin-top: 2rem;">
                <div class="d-flex align-items-center mb-4">
                    <a href="?controller=empleados&action=index" class="btn btn-outline-secondary me-3" title="Volver">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    <h2 style="color: #1a237e; font-weight: 700; margin: 0;">
                        <i class="bi bi-person-plus me-2"></i>Nuevo Empleado
                    </h2>
                </div>

                <?php include __DIR__ . '/../messages.php'; ?>

                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <form method="post" action="?controller=empleados&action=store">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="id_empleado" class="form-label fw-semibold">ID Empleado</label>
                                    <input type="number" class="form-control" id="id_empleado" name="id_empleado" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="tipo_doc" class="form-label fw-semibold">Tipo de Documento</label>
                                    <select class="form-select" id="tipo_doc" name="tipo_doc" required>
                                        <option value="">Seleccione</option>
                                        <option value="CC">Cédula de Ciudadanía</option>
                                        <option value="TI">Tarjeta de Identidad</option>
                                        <option value="CE">Cédula de Extranjería</option>
                                        <option value="PAS">Pasaporte</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="telefono" class="form-label fw-semibold">Teléfono</label>
                                    <input type="tel" class="form-control" id="telefono" name="telefono" placeholder="Ej: 3001234567">
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nombres" class="form-label fw-semibold">Nombres</label>
                                    <input type="text" class="form-control" id="nombres" name="nombres" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="apellidos" class="form-label fw-semibold">Apellidos</label>
                                    <input type="text" class="form-control" id="apellidos" name="apellidos" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="eps" class="form-label fw-semibold">EPS</label>
                                    <input type="text" class="form-control" id="eps" name="eps" placeholder="Ej: Compensar, Nueva EPS">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="arl" class="form-label fw-semibold">ARL</label>
                                    <input type="text" class="form-control" id="arl" name="arl" placeholder="Ej: Positiva, SURA">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="cargo_funcion" class="form-label fw-semibold">Cargo/Función</label>
                                    <input type="text" class="form-control" id="cargo_funcion" name="cargo_funcion" placeholder="Ej: Operario, Supervisor">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="antig_cargo" class="form-label fw-semibold">Antigüedad en el Cargo</label>
                                    <input type="text" class="form-control" id="antig_cargo" name="antig_cargo" placeholder="Ej: 2 años, 6 meses">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="rol" class="form-label fw-semibold">Rol</label>
                                    <select class="form-select" id="rol" name="rol" required>
                                        <option value="">Seleccione un rol</option>
                                        <?php foreach ($roles as $rol): ?>
                                            <option value="<?= $rol['id_Rol'] ?>"><?= htmlspecialchars($rol['nombre']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="d-flex gap-3 justify-content-end mt-4">
                                <a href="?controller=empleados&action=index" class="btn btn-secondary">
                                    <i class="bi bi-x-circle me-1"></i>Cancelar
                                </a>
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-check-circle me-1"></i>Guardar Empleado
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
