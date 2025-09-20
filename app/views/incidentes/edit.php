<?php if (isset($data) && is_array($data)) extract($data); include __DIR__ . '/../header.php'; ?>
<div class="container mt-4">
  <div class="row justify-content-center">
    <div class="col-lg-7">
      <div class="card shadow p-4">
        <h3 class="mb-3 text-center"><i class="bi bi-pencil-square me-2"></i>Editar Incidente</h3>
        <form method="post" action="?controller=incidentes&action=update&id=<?= $incidente['id_incidente'] ?>">
          <div class="mb-3">
            <label for="tipo" class="form-label">Tipo</label>
            <input type="text" class="form-control" id="tipo" name="tipo" value="<?= htmlspecialchars($incidente['tipo']) ?>" required>
          </div>
          <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="3"><?= htmlspecialchars($incidente['descripcion']) ?></textarea>
          </div>
          <div class="mb-3">
            <label for="fecha" class="form-label">Fecha</label>
            <input type="date" class="form-control" id="fecha" name="fecha" value="<?= isset($incidente['fecha_hora']) ? htmlspecialchars(substr($incidente['fecha_hora'],0,10)) : '' ?>" required>
          </div>
          <div class="mb-3">
            <label for="lugar" class="form-label">Lugar</label>
            <input type="text" class="form-control" id="lugar" name="lugar" value="<?= htmlspecialchars($incidente['lugar']) ?>">
          </div>
          <div class="d-flex justify-content-between mt-4">
            <a href="?controller=incidentes&action=index" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary">Actualizar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . '/../footer.php'; ?>
