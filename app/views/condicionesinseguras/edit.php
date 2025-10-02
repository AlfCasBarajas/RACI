<?php if (isset($data) && is_array($data)) extract($data); include __DIR__ . '/../header.php'; ?>
<div class="d-flex flex-column align-items-center justify-content-center min-vh-100">
  <div class="card condiciones-card p-4 w-100" style="max-width:700px;">
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
            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="?controller=condicionesinseguras&action=index" class="btn btn-secondary ms-2">Cancelar</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . '/../footer.php'; ?>
