<?php if (isset($data) && is_array($data)) extract($data); include __DIR__ . '/../header.php'; ?>
<style>
  .inspecciones-bg { background: linear-gradient(135deg, #f5f7fa 0%, #e3eafc 100%); min-height: 100vh; padding-top: 40px; padding-bottom: 40px; }
  .inspecciones-card { border-radius: 1.2rem; box-shadow: 0 2px 12px rgba(30,40,90,0.10); background: #fff; border: none; }
  .inspecciones-title { color: #00695c; font-weight: 700; letter-spacing: 1px; }
  .btn-inspecciones { background: #00695c; color: #fff; border-radius: 2rem; font-weight: 500; transition: background 0.2s; }
  .btn-inspecciones:hover { background: #00897b; color: #fff; }
  .btn-inspecciones-outline { border: 2px solid #00695c; color: #00695c; background: #fff; border-radius: 2rem; font-weight: 500; transition: background 0.2s, color 0.2s; }
  .btn-inspecciones-outline:hover { background: #00695c; color: #fff; }
</style>
<div class="inspecciones-bg">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="card inspecciones-card p-4">
          <div class="mb-3">
            <div class="w-100 text-center mb-3">
              <h2 class="inspecciones-title mb-0"><i class="bi bi-clipboard-check me-2"></i>Gestión de Inspecciones Locativas</h2>
            </div>
            <form class="d-flex flex-wrap justify-content-center align-items-center gap-2 mb-2" method="get" action="">
              <input type="hidden" name="controller" value="inspeccionlocativa">
              <input type="hidden" name="action" value="index">
              <input type="number" class="form-control" name="filtro_id" placeholder="ID" value="<?= isset($_GET['filtro_id']) ? htmlspecialchars($_GET['filtro_id']) : '' ?>" style="max-width: 90px;">
              <input type="text" class="form-control" name="filtro_tipo_inspeccion" placeholder="Tipo Inspección" value="<?= isset($_GET['filtro_tipo_inspeccion']) ? htmlspecialchars($_GET['filtro_tipo_inspeccion']) : '' ?>" style="max-width: 130px;">
              <input type="date" class="form-control" name="filtro_fecha_hora" value="<?= isset($_GET['filtro_fecha_hora']) ? htmlspecialchars($_GET['filtro_fecha_hora']) : '' ?>" style="max-width: 130px;">
              <input type="text" class="form-control" name="filtro_estado_inspeccion" placeholder="Estado" value="<?= isset($_GET['filtro_estado_inspeccion']) ? htmlspecialchars($_GET['filtro_estado_inspeccion']) : '' ?>" style="max-width: 110px;">
              <input type="number" class="form-control" name="filtro_categoria" placeholder="ID Categoría" value="<?= isset($_GET['filtro_categoria']) ? htmlspecialchars($_GET['filtro_categoria']) : '' ?>" style="max-width: 110px;">
              <input type="number" class="form-control" name="filtro_incidente" placeholder="ID Incidente" value="<?= isset($_GET['filtro_incidente']) ? htmlspecialchars($_GET['filtro_incidente']) : '' ?>" style="max-width: 110px;">
              <input type="number" class="form-control" name="filtro_accidente" placeholder="ID Accidente" value="<?= isset($_GET['filtro_accidente']) ? htmlspecialchars($_GET['filtro_accidente']) : '' ?>" style="max-width: 110px;">
              <input type="number" class="form-control" name="filtro_riesgo" placeholder="ID Riesgo" value="<?= isset($_GET['filtro_riesgo']) ? htmlspecialchars($_GET['filtro_riesgo']) : '' ?>" style="max-width: 110px;">
              <select class="form-select" name="filtro_orden" style="max-width: 160px;">
                <option value="id_asc" <?= (isset($filtro_orden) && $filtro_orden == 'id_asc') ? 'selected' : '' ?>>ID (Asc)</option>
                <option value="id_desc" <?= (isset($filtro_orden) && $filtro_orden == 'id_desc') ? 'selected' : '' ?>>ID (Desc)</option>
                <option value="fecha_asc" <?= (isset($filtro_orden) && $filtro_orden == 'fecha_asc') ? 'selected' : '' ?>>Fecha (Asc)</option>
                <option value="fecha_desc" <?= (isset($filtro_orden) && $filtro_orden == 'fecha_desc') ? 'selected' : '' ?>>Fecha (Desc)</option>
              </select>
              <button type="submit" class="btn btn-inspecciones-outline"><i class="bi bi-funnel"></i> Filtrar</button>
              <a href="?controller=inspeccionlocativa&action=index" class="btn btn-secondary ms-2"><i class="bi bi-x-circle"></i> Limpiar</a>
            </form>
            <div class="text-end">
              <a href="?controller=inspeccionlocativa&action=create" class="btn btn-inspecciones"><i class="bi bi-plus-circle me-1"></i>Nueva Inspección</a>
            </div>
          </div>
          <div class="table-responsive">
            <?php if (!empty($inspecciones)): ?>
              <?php foreach ($inspecciones as $insp): ?>
                <div class="card mb-4">
                  <div class="card-body">
                    <div class="row g-2">
                      <div class="col-md-6"><strong>ID:</strong></div><div class="col-md-6"><?= htmlspecialchars($insp['id_insp_loc']) ?></div>
                      <div class="col-md-6"><strong>Tipo Inspección:</strong></div><div class="col-md-6"><?= htmlspecialchars($insp['tipo_inspeccion']) ?></div>
                      <div class="col-md-6"><strong>Fecha y Hora:</strong></div><div class="col-md-6"><?= htmlspecialchars($insp['fecha_hora']) ?></div>
                      <div class="col-md-6"><strong>Actividad Económica:</strong></div><div class="col-md-6"><?= htmlspecialchars($insp['act_economica']) ?></div>
                      <div class="col-md-6"><strong>Descripción:</strong></div><div class="col-md-6"><?= htmlspecialchars($insp['descripcion']) ?></div>
                      <div class="col-md-6"><strong>Estado Inspección:</strong></div><div class="col-md-6"><?= htmlspecialchars($insp['estado_inspeccion']) ?></div>
                      <div class="col-md-6"><strong>Elementos de Trabajo:</strong></div><div class="col-md-6"><?= htmlspecialchars($insp['element_trab']) ?></div>
                      <div class="col-md-6"><strong>Observaciones:</strong></div><div class="col-md-6"><?= htmlspecialchars($insp['observaciones']) ?></div>
                      <div class="col-md-6"><strong>ID Categoría:</strong></div><div class="col-md-6"><?= htmlspecialchars($insp['categoria_id_categoria']) ?></div>
                      <div class="col-md-6"><strong>ID Incidente:</strong></div><div class="col-md-6"><?= htmlspecialchars($insp['incidente_id_incidente']) ?></div>
                      <div class="col-md-6"><strong>ID Accidente:</strong></div><div class="col-md-6"><?= htmlspecialchars($insp['accidente_id_accidente']) ?></div>
                      <div class="col-md-6"><strong>ID Riesgo:</strong></div><div class="col-md-6"><?= htmlspecialchars($insp['riesgo_id_riesgo']) ?></div>
                      <div class="col-md-6"><strong>ID Reporte:</strong></div><div class="col-md-6"><?= htmlspecialchars($insp['reporte_id_reporte']) ?></div>
                    </div>
                    <div class="mt-3 text-end">
                      <a href="?controller=inspeccionlocativa&action=edit&id=<?= $insp['id_insp_loc'] ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i> Editar</a>
                      <a href="?controller=inspeccionlocativa&action=delete&id=<?= $insp['id_insp_loc'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro de eliminar?')"><i class="bi bi-trash"></i> Eliminar</a>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php else: ?>
              <div class="alert alert-info text-center">No hay inspecciones registradas.</div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . '/../footer.php'; ?>
