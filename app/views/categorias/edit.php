<?php if (isset($data) && is_array($data)) extract($data); include __DIR__ . '/../header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php include __DIR__ . '/../sidebar.php'; ?>
        <main class="col-md-10 ms-sm-auto offset-md-2 px-4 main-content">
            <div style="border-radius: 1.2rem; box-shadow: 0 2px 12px rgba(30,40,90,0.10); background: #fff; border: none; padding: 2rem; margin-top: 2rem;">
                <div class="d-flex align-items-center mb-4">
                    <a href="?controller=categorias&action=index" class="btn btn-outline-secondary me-3" title="Volver">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    <h2 style="color: #1a237e; font-weight: 700; margin: 0;">
                        <i class="bi bi-tag me-2"></i>Editar Categoría
                    </h2>
                </div>

                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <form method="post" action="?controller=categorias&action=update&id=<?= $categoria['id_categoria'] ?>">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nombre" class="form-label fw-semibold">Nombre de la Categoría</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" 
                                           value="<?= htmlspecialchars($categoria['nombre']) ?>" 
                                           placeholder="Ej: Seguridad Industrial, Medio Ambiente" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="area_id_area" class="form-label fw-semibold">Área</label>
                                    <select class="form-select" id="area_id_area" name="area_id_area" required>
                                        <option value="">Seleccione un área</option>
                                        <?php foreach ($areas as $area): ?>
                                            <option value="<?= $area['id_area'] ?>" <?= $categoria['area_id_area'] == $area['id_area'] ? 'selected' : '' ?>><?= htmlspecialchars($area['nombre']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="descripcion" class="form-label fw-semibold">Descripción</label>
                                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3" 
                                              placeholder="Descripción detallada de la categoría..."><?= htmlspecialchars($categoria['descripcion']) ?></textarea>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="user_num_doc" class="form-label fw-semibold">Usuario</label>
                                    <select class="form-select" id="user_num_doc" name="user_num_doc" required>
                                        <option value="">Seleccione un usuario</option>
                                        <?php foreach ($usuarios as $usuario): ?>
                                            <option value="<?= $usuario['num_doc'] ?>" <?= $categoria['user_num_doc'] == $usuario['num_doc'] ? 'selected' : '' ?>><?= htmlspecialchars($usuario['usuario']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="empleado_id_empleado" class="form-label fw-semibold">Empleado</label>
                                    <select class="form-select" id="empleado_id_empleado" name="empleado_id_empleado" required>
                                        <option value="">Seleccione un empleado</option>
                                        <?php foreach ($empleados as $empleado): ?>
                                            <option value="<?= $empleado['id_empleado'] ?>" <?= $categoria['empleado_id_empleado'] == $empleado['id_empleado'] ? 'selected' : '' ?>><?= htmlspecialchars($empleado['nombres']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <hr class="my-4">
                            
                            <div class="d-flex gap-2 justify-content-end">
                                <a href="?controller=categorias&action=index" class="btn btn-secondary">
                                    <i class="bi bi-x-circle me-1"></i>Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle me-1"></i>Actualizar Categoría
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
