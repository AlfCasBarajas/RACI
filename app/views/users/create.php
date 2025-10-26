<?php 
include __DIR__ . '/../header.php';
require_once __DIR__ . '../../../models/Rol.php';
?>

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
                        <i class="bi bi-person-plus me-2"></i>Nuevo Usuario
                    </h2>
                </div>

                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <form method="post" action="?controller=users&action=store">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="num_doc" class="form-label fw-semibold">N° Documento</label>
                                    <input type="number" class="form-control" id="num_doc" name="num_doc" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="tipo_doc" class="form-label fw-semibold">Tipo de Documento</label>
                                    <select class="form-select" id="tipo_doc" name="tipo_doc" required>
                                        <option value="">Seleccione</option>
                                        <option value="CC">Cédula de Ciudadanía</option>
                                        <option value="TI">Tarjeta de Identidad</option>
                                        <option value="CE">Cédula de Extranjería</option>
                                        <option value="PAS">Pasaporte</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="usuario" class="form-label fw-semibold">Usuario</label>
                                    <input type="text" class="form-control" id="usuario" name="usuario" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="rol" class="form-label fw-semibold">Rol</label>
                                    <?php $roles = Rol::all(); ?>
                                    <select class="form-select" id="rol" name="rol" required>
                                        <option value="">Seleccione un rol</option>
                                        <?php foreach ($roles as $rol): ?>
                                            <option value="<?= $rol['id_Rol'] ?>"><?= htmlspecialchars($rol['nombre']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="telefono" class="form-label fw-semibold">Teléfono</label>
                                    <input type="tel" class="form-control" id="telefono" name="telefono" placeholder="Ej: 3001234567">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="contrasena" class="form-label fw-semibold">Contraseña</label>
                                    <input type="password" class="form-control" id="contrasena" name="contrasena" required>
                                    <div class="form-text">Mínimo 6 caracteres</div>
                                </div>
                            </div>

                            <div class="d-flex gap-3 justify-content-end mt-4">
                                <a href="?controller=users&action=index" class="btn btn-secondary">
                                    <i class="bi bi-x-circle me-1"></i>Cancelar
                                </a>
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-check-circle me-1"></i>Guardar Usuario
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