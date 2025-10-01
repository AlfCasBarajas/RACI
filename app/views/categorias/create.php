<?php if (isset($data) && is_array($data)) extract($data); include __DIR__ . '/../header.php'; ?>
<div class="container mt-4">
  <div class="row justify-content-center">
      <div class="d-flex flex-column align-items-center justify-content-center min-vh-100">
        <div class="card categorias-card p-4 w-100" style="max-width:700px;">
        <h3 class="mb-3 text-center"><i class="bi bi-folder-plus me-2"></i>Crear Categoría</h3>
        <form method="post" action="?controller=categorias&action=store">
          <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
          </div>
          <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
          </div>
          <div class="mb-3">
            <label for="area_id_area" class="form-label">Área</label>
            <select class="form-select" id="area_id_area" name="area_id_area" required>
              <option value="">Seleccione un área</option>
              <?php foreach ($areas as $area): ?>
                <option value="<?= $area['id_area'] ?>"><?= htmlspecialchars($area['nombre']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <label for="user_num_doc" class="form-label">Usuario</label>
            <select class="form-select" id="user_num_doc" name="user_num_doc" required>
              <option value="">Seleccione un usuario</option>
              <?php foreach ($usuarios as $usuario): ?>
                <option value="<?= $usuario['num_doc'] ?>"><?= htmlspecialchars($usuario['usuario']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <label for="empleado_id_empleado" class="form-label">Empleado</label>
            <select class="form-select" id="empleado_id_empleado" name="empleado_id_empleado" required>
              <option value="">Seleccione un empleado</option>
              <?php foreach ($empleados as $empleado): ?>
                <option value="<?= $empleado['id_empleado'] ?>"><?= htmlspecialchars($empleado['nombres']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="d-flex justify-content-between mt-4">
            <a href="app/views/dashboard.php" class="btn btn-inicio-claro position-absolute" style="top:24px;left:24px;z-index:10;"><i class="bi bi-arrow-left"></i> Ir a Inicio</a>
            <button type="submit" class="btn btn-primary">Guardar</button>
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
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . '/../footer.php'; ?>
