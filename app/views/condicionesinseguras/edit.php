<?php if (isset($data) && is_array($data)) extract($data); include __DIR__ . '/../header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php include __DIR__ . '/../sidebar.php'; ?>
        <main class="col-md-10 ms-sm-auto offset-md-2 px-4 main-content">
            <div style="border-radius: 1.2rem; box-shadow: 0 2px 12px rgba(30,40,90,0.10); background: #fff; border: none; padding: 2rem; margin-top: 2rem;">
                <div class="d-flex align-items-center mb-4">
                    <a href="?controller=condicionesinseguras&action=index" class="btn btn-outline-secondary me-3" title="Volver">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    <h2 style="color: #1a237e; font-weight: 700; margin: 0;">
                        <i class="bi bi-shield-exclamation me-2"></i>Editar Condición Insegura
                    </h2>
                </div>

                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <form method="post" action="?controller=condicionesinseguras&action=update&id=<?= $condicion['id_cond_inseg'] ?>">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nombre" class="form-label fw-semibold">Nombre de la Condición</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" 
                                           value="<?= htmlspecialchars($condicion['nombre']) ?>" 
                                           placeholder="Ej: Superficie resbalosa, Equipo defectuoso" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="lugar" class="form-label fw-semibold">Lugar</label>
                                    <input type="text" class="form-control" id="lugar" name="lugar" 
                                           value="<?= htmlspecialchars($condicion['lugar']) ?>" 
                                           placeholder="Ej: Planta de producción, Oficinas">
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="descripcion" class="form-label fw-semibold">Descripción</label>
                                    <textarea class="form-control" id="descripcion" name="descripcion" rows="4" 
                                              placeholder="Descripción detallada de la condición insegura..."><?= htmlspecialchars($condicion['descripcion']) ?></textarea>
                                </div>
                            </div>

                            <hr class="my-4">
                            
                            <div class="d-flex gap-2 justify-content-end">
                                <a href="?controller=condicionesinseguras&action=index" class="btn btn-secondary">
                                    <i class="bi bi-x-circle me-1"></i>Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle me-1"></i>Actualizar Condición
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
