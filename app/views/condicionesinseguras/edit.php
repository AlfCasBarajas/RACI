<?php if (isset($data) && is_array($data)) extract($data); include __DIR__ . '/../header.php'; ?>
<div class="container mt-4">
  <div class="row justify-content-center">
    <div class="col-lg-7">
      <div class="card shadow p-4">
        <h3 class="mb-3 text-center"><i class="bi bi-pencil-square me-2"></i>Editar Condición Insegura</h3>
        <form method="post" action="?controller=condicionesinseguras&action=update&id=<?= $condicion['id_cond_inseg'] ?>">
          <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($condicion['nombre']) ?>" required>
          </div>
          <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="3"><?= htmlspecialchars($condicion['descripcion']) ?></textarea>
          </div>
          <div class="mb-3">
            <label for="lugar" class="form-label">Lugar</label>
            <input type="text" class="form-control" id="lugar" name="lugar" value="<?= htmlspecialchars($condicion['lugar']) ?>">
          </div>
          <div class="d-flex justify-content-between mt-4">
            <a href="?controller=condicionesinseguras&action=index" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary">Actualizar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . '/../footer.php'; ?>
