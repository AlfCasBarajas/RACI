<a href="app/views/dashboard.php" class="btn btn-inicio-claro position-absolute" style="top:24px;left:24px;z-index:10;"><i class="bi bi-arrow-left"></i> Ir a Inicio</a>
<?php include __DIR__ . '/../header.php';
require_once __DIR__ . '../../../models/Rol.php';
?>
<style>
  .btn-inicio-claro {
    background: #e3f2fd;
    color: #3949ab;
    border-radius: 2rem;
    font-weight: 600;
    border: 2px solid #bbdefb;
    box-shadow: 0 2px 8px #bbdefb88;
    transition: background 0.2s, color 0.2s, border 0.2s;
  }
  .btn-inicio-claro:hover {
    background: #ffd600;
    color: #3949ab;
    border: 2px solid #3949ab;
    box-shadow: 0 2px 12px #ffd60055;
  }
  body {
    background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
    min-height: 100vh;
  }
  .users-bg {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .users-card {
    border-radius: 1.2rem;
    box-shadow: 0 2px 12px rgba(30,40,90,0.10);
    background: #fff;
    border: none;
    max-width: 400px;
    margin: auto;
    display: flex;
    flex-direction: column;
    align-items: center;
  }
  .users-title {
    color: #1a237e;
    font-weight: 700;
    letter-spacing: 1px;
    text-align: center;
    width: 100%;
    border-bottom: 3px solid #ffd600;
    margin-bottom: 2rem;
    padding-bottom: 0.5rem;
  }
  .btn-users {
    background: #3949ab;
    color: #fff;
    border-radius: 2rem;
    font-weight: 600;
    border: 2px solid #ffd600;
    box-shadow: 0 2px 8px rgba(255,214,0,0.10);
    transition: background 0.2s, border 0.2s;
  }
  .btn-users:hover {
    background: #ffd600;
    color: #3949ab;
    border: 2px solid #3949ab;
  }
  .btn-users-outline {
    border: 2px solid #3949ab;
    color: #3949ab;
    background: #fff;
    border-radius: 2rem;
    font-weight: 600;
    transition: background 0.2s, color 0.2s, border 0.2s;
  }
  .btn-users-outline:hover {
    background: #3949ab;
    color: #fff;
    border: 2px solid #ffd600;
  }
</style>

<div class="users-bg">
  <div class="d-flex flex-column align-items-center justify-content-center min-vh-100">
    <div class="card users-card p-4 w-100">
      <h2 class="users-title mb-4"><i class="bi bi-person-plus me-2"></i>Nuevo Usuario</h2>
      <form method="post" action="?controller=users&action=store" class="w-100">
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
              <label for="usuario" class="form-label">Usuario</label>
              <input type="text" class="form-control" id="usuario" name="usuario" required>
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