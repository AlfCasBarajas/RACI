<?php if (isset($data) && is_array($data)) extract($data); include __DIR__ . '/../header.php'; ?>
<div class="container mt-4">
  <div class="d-flex flex-column align-items-center justify-content-center min-vh-100">
    <div class="col-lg-7">
      <div class="card shadow p-4">
        <h3 class="mb-3 text-center"><i class="bi bi-shield-check me-2"></i>Nuevo Riesgo</h3>
        <form method="post" action="?controller=riesgos&action=store">
          <div class="mb-3">
            <label for="tipo" class="form-label">Tipo</label>
            <input type="text" class="form-control" id="tipo" name="tipo" required>
          </div>
          <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
          </div>
          <div class="mb-3">
            <label for="condicion_insegura_id_cond_inseg" class="form-label">Condición Insegura</label>
            <select class="form-select" id="condicion_insegura_id_cond_inseg" name="condicion_insegura_id_cond_inseg" required>
              <option value="">Seleccione una condición</option>
              <?php foreach ($condiciones as $cond): ?>
                <option value="<?= $cond['id_cond_inseg'] ?>"><?= htmlspecialchars($cond['nombre']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="d-flex justify-content-end mt-4">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="?controller=riesgos&action=index" class="btn btn-secondary ms-2">Cancelar</a>
          </div>
        </form>
      </div>
    </div>
  </div>
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
</div>
<?php include __DIR__ . '/../footer.php'; ?>
