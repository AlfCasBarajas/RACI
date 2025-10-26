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
                                <div class="col-md-12 mb-3">
                                    <label for="lugar" class="form-label fw-semibold">Lugar</label>
                                    <input type="text" class="form-control" id="lugar" name="lugar" 
                                           placeholder="Ubicación específica donde ocurrió el incidente">
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

<?php include __DIR__ . '/../footer.php'; ?>
