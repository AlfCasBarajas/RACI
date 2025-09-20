<?php if (isset($data) && is_array($data)) extract($data); include __DIR__ . '/../header.php'; ?>
<div class="container mt-4">
  <div class="row justify-content-center">
    <div class="col-lg-7">
      <div class="card shadow p-4">
        <h3 class="mb-3 text-center"><i class="bi bi-pencil-square me-2"></i>Editar Categoría</h3>
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
                <option value="<?= $usuario['num_doc'] ?>" <?= $categoria['user_num_doc'] == $usuario['num_doc'] ? 'selected' : '' ?>><?= htmlspecialchars($usuario['nombres']) ?></option>
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
            <a href="?controller=categorias&action=index" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary">Actualizar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . '/../footer.php'; ?>
