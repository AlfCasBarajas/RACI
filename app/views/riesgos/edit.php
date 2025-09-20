<?php if (isset($data) && is_array($data)) extract($data); include __DIR__ . '/../header.php'; ?>
<div class="container mt-4">
  <div class="row justify-content-center">
    <div class="col-lg-7">
      <div class="card shadow p-4">
        <h3 class="mb-3 text-center"><i class="bi bi-pencil-square me-2"></i>Editar Riesgo</h3>
        <form method="post" action="?controller=riesgos&action=update&id=<?= $riesgo['id_riesgo'] ?>">
          <div class="mb-3">
            <label for="tipo" class="form-label">Tipo</label>
            <input type="text" class="form-control" id="tipo" name="tipo" value="<?= htmlspecialchars($riesgo['tipo']) ?>" required>
          </div>
          <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="3"><?= htmlspecialchars($riesgo['descripcion']) ?></textarea>
          </div>
          <div class="mb-3">
            <label for="condicion_insegura_id_cond_inseg" class="form-label">Condición Insegura</label>
            <select class="form-select" id="condicion_insegura_id_cond_inseg" name="condicion_insegura_id_cond_inseg" required>
              <option value="">Seleccione una condición</option>
              <?php foreach ($condiciones as $cond): ?>
                <option value="<?= $cond['id_cond_inseg'] ?>" <?= $riesgo['condicion_insegura_id_cond_inseg'] == $cond['id_cond_inseg'] ? 'selected' : '' ?>><?= htmlspecialchars($cond['nombre']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="d-flex justify-content-between mt-4">
            <a href="?controller=riesgos&action=index" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary">Actualizar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . '/../footer.php'; ?>
