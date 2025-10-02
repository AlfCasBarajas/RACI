<?php if (isset($data) && is_array($data)) extract($data); include __DIR__ . '/../header.php'; ?>
<div class="d-flex flex-column align-items-center justify-content-center min-vh-100">
  <div class="card categorias-card p-4 w-100" style="max-width:700px;">
        <h3 class="mb-3 text-center"><i class="bi bi-pencil-square me-2"></i>Editar Categoría</h3>
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
</style>
        <form method="post" action="?controller=categorias&action=update&id=<?= $categoria['id_categoria'] ?>">
          <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($categoria['nombre']) ?>" required>
          </div>
          <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="3"><?= htmlspecialchars($categoria['descripcion']) ?></textarea>
          </div>
          <div class="mb-3">
            <label for="area_id_area" class="form-label">Área</label>
            <select class="form-select" id="area_id_area" name="area_id_area" required>
              <option value="">Seleccione un área</option>
              <?php foreach ($areas as $area): ?>
                <option value="<?= $area['id_area'] ?>" <?= $categoria['area_id_area'] == $area['id_area'] ? 'selected' : '' ?>><?= htmlspecialchars($area['nombre']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <label for="user_num_doc" class="form-label">Usuario</label>
            <select class="form-select" id="user_num_doc" name="user_num_doc" required>
              <option value="">Seleccione un usuario</option>
              <?php foreach ($usuarios as $usuario): ?>
                <option value="<?= $usuario['num_doc'] ?>" <?= $categoria['user_num_doc'] == $usuario['num_doc'] ? 'selected' : '' ?>><?= htmlspecialchars($usuario['usuario']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <label for="empleado_id_empleado" class="form-label">Empleado</label>
            <select class="form-select" id="empleado_id_empleado" name="empleado_id_empleado" required>
              <option value="">Seleccione un empleado</option>
              <?php foreach ($empleados as $empleado): ?>
                <option value="<?= $empleado['id_empleado'] ?>" <?= $categoria['empleado_id_empleado'] == $empleado['id_empleado'] ? 'selected' : '' ?>><?= htmlspecialchars($empleado['nombres']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="d-flex justify-content-between mt-4">
            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="?controller=categorias&action=index" class="btn btn-secondary ms-2">Cancelar</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . '/../footer.php'; ?>
