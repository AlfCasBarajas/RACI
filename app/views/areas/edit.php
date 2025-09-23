<?php if (isset($data) && is_array($data)) extract($data); include __DIR__ . '/../header.php'; ?>
<a href="/dashboard.php" class="btn btn-secondary mb-3">Regresar al dashboard</a>
<style>
  .areas-bg {
    background: linear-gradient(135deg, #f5f7fa 0%, #e3eafc 100%);
    min-height: 100vh;
    padding-top: 40px;
    padding-bottom: 40px;
  }
  .areas-card {
    border-radius: 1.2rem;
    box-shadow: 0 2px 12px rgba(30,40,90,0.10);
    background: #fff;
    border: none;
  }
  .areas-title {
    color: #1a237e;
    font-weight: 700;
    letter-spacing: 1px;
  }
  .btn-areas {
    background: #1a237e;
    color: #fff;
    border-radius: 2rem;
    font-weight: 500;
    transition: background 0.2s;
  }
  .btn-areas:hover {
    background: #3949ab;
    color: #fff;
  }
  .btn-areas-outline {
    border: 2px solid #1a237e;
    color: #1a237e;
    background: #fff;
    border-radius: 2rem;
    font-weight: 500;
    transition: background 0.2s, color 0.2s;
  }
  .btn-areas-outline:hover {
    background: #1a237e;
    color: #fff;
  }
</style>
<div class="areas-bg">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <div class="card areas-card p-4">
          <h2 class="areas-title mb-4"><i class="bi bi-building me-2"></i>Editar Área</h2>
          <form method="post" action="?controller=areas&action=update&id=<?= $area['id_area'] ?>">
            <div class="mb-3">
              <label for="nombre" class="form-label">Nombre</label>
              <input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($area['nombre']) ?>" required>
            </div>
            <div class="mb-3">
              <label for="descripcion" class="form-label">Descripción</label>
              <textarea class="form-control" id="descripcion" name="descripcion" rows="3"><?= htmlspecialchars($area['descripcion']) ?></textarea>
            </div>
            <div class="d-flex justify-content-end">
              <button type="submit" class="btn btn-areas me-2"><i class="bi bi-check-circle me-1"></i>Actualizar</button>
              <a href="?controller=areas&action=index" class="btn btn-areas-outline">Cancelar</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . '/../footer.php'; ?>
