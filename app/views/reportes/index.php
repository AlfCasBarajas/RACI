<?php if (isset($data) && is_array($data)) extract($data); include __DIR__ . '/../header.php'; ?>
<a href="app/views/dashboard.php" class="btn btn-secondary mb-3">Volver a inicio</a>
<style>
  .reportes-bg { background: linear-gradient(135deg, #f5f7fa 0%, #e3eafc 100%); min-height: 100vh; padding-top: 40px; padding-bottom: 40px; }
  .reportes-card { border-radius: 1.2rem; box-shadow: 0 2px 12px rgba(30,40,90,0.10); background: #fff; border: none; }
  .reportes-title { color: #37474f; font-weight: 700; letter-spacing: 1px; }
  .btn-reportes { background: #37474f; color: #fff; border-radius: 2rem; font-weight: 500; transition: background 0.2s; }
  .btn-reportes:hover { background: #263238; color: #fff; }
  .btn-reportes-outline { border: 2px solid #37474f; color: #37474f; background: #fff; border-radius: 2rem; font-weight: 500; transition: background 0.2s, color 0.2s; }
  .btn-reportes-outline:hover { background: #37474f; color: #fff; }
</style>
<div class="reportes-bg">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="card reportes-card p-4">
          <div class="mb-3">
            <div class="w-100 text-center mb-3">
              <h2 class="reportes-title mb-0"><i class="bi bi-file-earmark-text me-2"></i>Gestión de Reportes</h2>
            </div>
            <form class="d-flex flex-wrap justify-content-center align-items-center gap-2 mb-2" method="get" action="">
              <input type="hidden" name="controller" value="reportes">
              <input type="hidden" name="action" value="index">
              <input type="number" class="form-control" name="filtro_id" placeholder="ID" value="<?= isset($_GET['filtro_id']) ? htmlspecialchars($_GET['filtro_id']) : '' ?>" style="max-width: 90px;">
              <input type="text" class="form-control" name="filtro_nombre" placeholder="Nombre" value="<?= isset($_GET['filtro_nombre']) ? htmlspecialchars($_GET['filtro_nombre']) : '' ?>" style="max-width: 160px;">
              <select class="form-select" name="filtro_orden" style="max-width: 160px;">
                <option value="id_asc" <?= (isset($filtro_orden) && $filtro_orden == 'id_asc') ? 'selected' : '' ?>>ID (Asc)</option>
                <option value="id_desc" <?= (isset($filtro_orden) && $filtro_orden == 'id_desc') ? 'selected' : '' ?>>ID (Desc)</option>
                <option value="nombre_asc" <?= (isset($filtro_orden) && $filtro_orden == 'nombre_asc') ? 'selected' : '' ?>>Nombre (A-Z)</option>
                <option value="nombre_desc" <?= (isset($filtro_orden) && $filtro_orden == 'nombre_desc') ? 'selected' : '' ?>>Nombre (Z-A)</option>
              </select>
              <button type="submit" class="btn btn-reportes-outline"><i class="bi bi-funnel"></i> Filtrar</button>
              <a href="?controller=reportes&action=index" class="btn btn-secondary ms-2"><i class="bi bi-x-circle"></i> Limpiar</a>
            </form>
            <div class="text-end">
              <a href="?controller=reportes&action=create" class="btn btn-reportes"><i class="bi bi-plus-circle me-1"></i>Nuevo Reporte</a>
            </div>
          </div>
          <div class="table-responsive">
            <?php if (!empty($reportes)): ?>
              <?php foreach ($reportes as $rep): ?>
                <div class="card mb-3">
                  <div class="card-body">
                    <div class="row g-2">
                      <div class="col-md-6"><strong>ID:</strong></div><div class="col-md-6"><?= htmlspecialchars($rep['id_reporte']) ?></div>
                      <div class="col-md-6"><strong>Nombre:</strong></div><div class="col-md-6"><?= htmlspecialchars($rep['nombre']) ?></div>
                    </div>
                    <div class="mt-3 text-end">
                      <a href="?controller=reportes&action=edit&id=<?= $rep['id_reporte'] ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i> Editar</a>
                      <a href="?controller=reportes&action=delete&id=<?= $rep['id_reporte'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro de eliminar?')"><i class="bi bi-trash"></i> Eliminar</a>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php else: ?>
              <div class="alert alert-info text-center">No hay reportes registrados.</div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . '/../footer.php'; ?>
