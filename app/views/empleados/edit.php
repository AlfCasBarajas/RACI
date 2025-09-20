<?php if (isset($data) && is_array($data)) extract($data); include __DIR__ . '/../header.php'; ?>
<style>
  .empleados-bg {
    background: linear-gradient(135deg, #f5f7fa 0%, #e3eafc 100%);
    min-height: 100vh;
    padding-top: 40px;
    padding-bottom: 40px;
  }
  .empleados-card {
    border-radius: 1.2rem;
    box-shadow: 0 2px 12px rgba(30,40,90,0.10);
    background: #fff;
    border: none;
  }
  .empleados-title {
    color: #1a237e;
    font-weight: 700;
    letter-spacing: 1px;
  }
  .btn-empleados {
    background: #1a237e;
    color: #fff;
    border-radius: 2rem;
    font-weight: 500;
    transition: background 0.2s;
  }
  .btn-empleados:hover {
    background: #3949ab;
    color: #fff;
  }
  .btn-empleados-outline {
    border: 2px solid #1a237e;
    color: #1a237e;
    background: #fff;
    border-radius: 2rem;
    font-weight: 500;
    transition: background 0.2s, color 0.2s;
  }
  .btn-empleados-outline:hover {
    background: #1a237e;
    color: #fff;
  }
</style>
<div class="empleados-bg">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <div class="card empleados-card p-4">
          <h2 class="empleados-title mb-4"><i class="bi bi-person-lines-fill me-2"></i>Editar Empleado</h2>
          <form method="post" action="?controller=empleados&action=update&id=<?= $empleado['id_empleado'] ?>">
            <div class="mb-3">
              <label for="tipo_doc" class="form-label">Tipo de Documento</label>
              <select class="form-select" id="tipo_doc" name="tipo_doc" required>
                <option value="">Seleccione</option>
                <option value="CC" <?= $empleado['tipo_doc'] == 'CC' ? 'selected' : '' ?>>Cédula de Ciudadanía</option>
                <option value="TI" <?= $empleado['tipo_doc'] == 'TI' ? 'selected' : '' ?>>Tarjeta de Identidad</option>
                <option value="CE" <?= $empleado['tipo_doc'] == 'CE' ? 'selected' : '' ?>>Cédula de Extranjería</option>
                <option value="PAS" <?= $empleado['tipo_doc'] == 'PAS' ? 'selected' : '' ?>>Pasaporte</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="nombres" class="form-label">Nombres</label>
              <input type="text" class="form-control" id="nombres" name="nombres" value="<?= htmlspecialchars($empleado['nombres']) ?>" required>
            </div>
            <div class="mb-3">
              <label for="apellidos" class="form-label">Apellidos</label>
              <input type="text" class="form-control" id="apellidos" name="apellidos" value="<?= htmlspecialchars($empleado['apellidos']) ?>" required>
            </div>
            <div class="mb-3">
              <label for="telefono" class="form-label">Teléfono</label>
              <input type="number" class="form-control" id="telefono" name="telefono" value="<?= htmlspecialchars($empleado['telefono']) ?>">
            </div>
            <div class="mb-3">
              <label for="eps" class="form-label">EPS</label>
              <input type="text" class="form-control" id="eps" name="eps" value="<?= htmlspecialchars($empleado['eps']) ?>">
            </div>
            <div class="mb-3">
              <label for="arl" class="form-label">ARL</label>
              <input type="text" class="form-control" id="arl" name="arl" value="<?= htmlspecialchars($empleado['arl']) ?>">
            </div>
            <div class="mb-3">
              <label for="cargo_funcion" class="form-label">Cargo/Función</label>
              <input type="text" class="form-control" id="cargo_funcion" name="cargo_funcion" value="<?= htmlspecialchars($empleado['cargo_funcion']) ?>">
            </div>
            <div class="mb-3">
              <label for="antig_cargo" class="form-label">Antigüedad en el Cargo</label>
              <input type="text" class="form-control" id="antig_cargo" name="antig_cargo" value="<?= htmlspecialchars($empleado['antig_cargo']) ?>">
            </div>
            <div class="mb-3">
              <label for="rol" class="form-label">Rol</label>
              <select class="form-select" id="rol" name="rol" required>
                <?php foreach ($roles as $rol): ?>
                  <option value="<?= $rol['id_Rol'] ?>" <?= $rol['id_Rol'] == $empleado['rol'] ? 'selected' : '' ?>><?= htmlspecialchars($rol['nombre']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="d-flex justify-content-end">
              <button type="submit" class="btn btn-empleados me-2"><i class="bi bi-check-circle me-1"></i>Actualizar</button>
              <a href="?controller=empleados&action=index" class="btn btn-empleados-outline">Cancelar</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . '/../footer.php'; ?>
