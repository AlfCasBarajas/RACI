<?php include __DIR__ . '/../header.php';
require_once __DIR__ . '../../../models/Rol.php';
?>
<style>
  .users-bg {
    background: linear-gradient(135deg, #f5f7fa 0%, #e3eafc 100%);
    min-height: 100vh;
    padding-top: 40px;
    padding-bottom: 40px;
  }

  .users-card {
    border-radius: 1.2rem;
    box-shadow: 0 2px 12px rgba(30, 40, 90, 0.10);
    background: #fff;
    border: none;
  }

  .users-title {
    color: #1a237e;
    font-weight: 700;
    letter-spacing: 1px;
  }

  .btn-users {
    background: #1a237e;
    color: #fff;
    border-radius: 2rem;
    font-weight: 500;
    transition: background 0.2s;
  }

  .btn-users:hover {
    background: #3949ab;
    color: #fff;
  }

  .btn-users-outline {
    border: 2px solid #1a237e;
    color: #1a237e;
    background: #fff;
    border-radius: 2rem;
    font-weight: 500;
    transition: background 0.2s, color 0.2s;
  }

  .btn-users-outline:hover {
    background: #1a237e;
    color: #fff;
  }
</style>

<div class="users-bg">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <div class="card users-card p-4">
          <h2 class="users-title mb-4"><i class="bi bi-person-plus me-2"></i>Nuevo Usuario</h2>
          <form method="post" action="?controller=users&action=store">
            <div class="mb-3">
              <label for="num_doc" class="form-label">N° Documento</label>
              <input type="number" class="form-control" id="num_doc" name="num_doc" required>
            </div>
            <div class="mb-3">
              <label for="tipo_doc" class="form-label">Tipo de Documento</label>
              <select class="form-select" id="tipo_doc" name="tipo_doc" required>
                <option value="">Seleccione</option>
                <option value="CC">Cédula de Ciudadanía</option>
                <option value="TI">Tarjeta de Identidad</option>
                <option value="CE">Cédula de Extranjería</option>
                <option value="PAS">Pasaporte</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="nombres" class="form-label">Nombres</label>
              <input type="text" class="form-control" id="nombres" name="nombres" required>
            </div>
            <div class="mb-3">
              <label for="apellidos" class="form-label">Apellidos</label>
              <input type="text" class="form-control" id="apellidos" name="apellidos" required>
            </div>
            <div class="mb-3">
              <label for="rol" class="form-label">Rol</label>
              <?php $roles = Rol::all();
              ?>
              <select class="form-select" id="rol" name="rol" required>
                <option value="">Seleccione un rol</option>
                <?php foreach ($roles as $rol): ?>
              <option value="<?= $rol['id_Rol'] ?>"><?= htmlspecialchars($rol['nombre']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="mb-3">
              <label for="telefono" class="form-label">Teléfono</label>
              <input type="number" class="form-control" id="telefono" name="telefono">
            </div>
            <div class="mb-3">
              <label for="contrasena" class="form-label">Contraseña</label>
              <input type="password" class="form-control" id="contrasena" name="contrasena" required>
            </div>
            <div class="d-flex justify-content-end">
              <button type="submit" class="btn btn-users me-2"><i class="bi bi-check-circle me-1"></i>Guardar</button>
              <a href="?controller=users&action=index" class="btn btn-users-outline">Cancelar</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . '/../footer.php'; ?>