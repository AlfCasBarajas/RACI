<?php
if (isset($data) && is_array($data)) extract($data);
include __DIR__ . '/../header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php include __DIR__ . '/../sidebar.php'; ?>
        <main class="col-md-10 ms-sm-auto offset-md-2 px-4 main-content">
            <div style="border-radius: 1.2rem; box-shadow: 0 2px 12px rgba(30,40,90,0.10); background: #fff; border: none; padding: 2rem; margin-top: 2rem;">
                <div class="d-flex align-items-center mb-4">
                    <a href="?controller=users&action=index" class="btn btn-outline-secondary me-3" title="Volver">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    <h2 style="color: #1a237e; font-weight: 700; margin: 0;">
                        <i class="bi bi-person-lines-fill me-2"></i>Editar Usuario
                    </h2>
                </div>

                <?php include __DIR__ . '/../messages.php'; ?>

                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <form method="post" action="?controller=users&action=update&id=<?= $usuario['num_doc'] ?>">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="num_doc" class="form-label fw-semibold">N° Documento</label>
                                    <input type="number" class="form-control" id="num_doc" name="num_doc" 
                                           value="<?= htmlspecialchars($usuario['num_doc']) ?>" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="tipo_doc" class="form-label fw-semibold">Tipo de Documento</label>
                                    <select class="form-select" id="tipo_doc" name="tipo_doc" required>
                                        <option value="">Seleccione tipo</option>
                                        <option value="CC" <?= $usuario['tipo_doc'] == 'CC' ? 'selected' : '' ?>>Cédula de Ciudadanía</option>
                                        <option value="TI" <?= $usuario['tipo_doc'] == 'TI' ? 'selected' : '' ?>>Tarjeta de Identidad</option>
                                        <option value="CE" <?= $usuario['tipo_doc'] == 'CE' ? 'selected' : '' ?>>Cédula de Extranjería</option>
                                        <option value="PAS" <?= $usuario['tipo_doc'] == 'PAS' ? 'selected' : '' ?>>Pasaporte</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="usuario" class="form-label fw-semibold">Usuario</label>
                                    <input type="text" class="form-control" id="usuario" name="usuario" 
                                           value="<?= htmlspecialchars($usuario['usuario']) ?>" 
                                           placeholder="Nombre de usuario" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="telefono" class="form-label fw-semibold">Teléfono</label>
                                    <input type="number" class="form-control" id="telefono" name="telefono" 
                                           value="<?= htmlspecialchars($usuario['telefono']) ?>" 
                                           placeholder="Ej: 3001234567">
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="rol" class="form-label fw-semibold">Rol</label>
                                    <select class="form-select" id="rol" name="rol" required>
                                        <?php foreach ($roles as $rol): ?>
                                            <option value="<?= $rol['id_Rol'] ?>" <?= $rol['id_Rol'] == $usuario['rol'] ? 'selected' : '' ?>><?= htmlspecialchars($rol['nombre']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="contrasena" class="form-label fw-semibold">Contraseña <small class="text-muted">(dejar en blanco para no cambiar)</small></label>
                                    <input type="password" class="form-control" id="contrasena" name="contrasena" 
                                           placeholder="Nueva contraseña (opcional)">
                                </div>
                            </div>

                            <hr class="my-4">
                            
                            <div class="d-flex gap-2 justify-content-end">
                                <a href="?controller=users&action=index" class="btn btn-secondary">
                                    <i class="bi bi-x-circle me-1"></i>Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle me-1"></i>Actualizar Usuario
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
