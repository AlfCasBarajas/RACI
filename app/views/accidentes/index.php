<?php if (isset($data) && is_array($data)) extract($data); include __DIR__ . '/../header.php'; ?>
<a href="app/views/dashboard.php" class="btn btn-secondary mb-3">Volver a inicio</a>
<style>
  .accidentes-bg { background: linear-gradient(135deg, #f5f7fa 0%, #e3eafc 100%); min-height: 100vh; padding-top: 40px; padding-bottom: 40px; }
  .accidentes-card { border-radius: 1.2rem; box-shadow: 0 2px 12px rgba(30,40,90,0.10); background: #fff; border: none; }
  .accidentes-title { color: #b71c1c; font-weight: 700; letter-spacing: 1px; }
  .btn-accidentes { background: #b71c1c; color: #fff; border-radius: 2rem; font-weight: 500; transition: background 0.2s; }
  .btn-accidentes:hover { background: #d32f2f; color: #fff; }
  .btn-accidentes-outline { border: 2px solid #b71c1c; color: #b71c1c; background: #fff; border-radius: 2rem; font-weight: 500; transition: background 0.2s, color 0.2s; }
  .btn-accidentes-outline:hover { background: #b71c1c; color: #fff; }
</style>
<div class="accidentes-bg">
  <div class="container">
    <a href="/dashboard.php" class="btn btn-secondary mb-3">Regresar al dashboard</a>
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="card accidentes-card p-4">
          <div class="mb-3">
            <div class="w-100 text-center mb-3">
              <h2 class="accidentes-title mb-0"><i class="bi bi-activity me-2"></i>Gestión de Accidentes</h2>
            </div>
            <form class="d-flex flex-wrap justify-content-center align-items-center gap-2 mb-2" method="get" action="">
              <input type="hidden" name="controller" value="accidentes">
              <input type="hidden" name="action" value="index">
              <input type="number" class="form-control" name="filtro_id" placeholder="ID" value="<?= isset($_GET['filtro_id']) ? htmlspecialchars($_GET['filtro_id']) : '' ?>" style="max-width: 100px;">
              <input type="text" class="form-control" name="filtro_tipo" placeholder="Tipo" value="<?= isset($_GET['filtro_tipo']) ? htmlspecialchars($_GET['filtro_tipo']) : '' ?>" style="max-width: 120px;">
              <input type="date" class="form-control" name="filtro_fecha" value="<?= isset($_GET['filtro_fecha']) ? htmlspecialchars($_GET['filtro_fecha']) : '' ?>" style="max-width: 150px;">
              <input type="text" class="form-control" name="filtro_lugar" placeholder="Lugar" value="<?= isset($_GET['filtro_lugar']) ? htmlspecialchars($_GET['filtro_lugar']) : '' ?>" style="max-width: 120px;">
              <select class="form-select" name="filtro_orden" style="max-width: 160px;">
                <option value="id_asc" <?= (isset($filtro_orden) && $filtro_orden == 'id_asc') ? 'selected' : '' ?>>ID (Asc)</option>
                <option value="id_desc" <?= (isset($filtro_orden) && $filtro_orden == 'id_desc') ? 'selected' : '' ?>>ID (Desc)</option>
                <option value="tipo_asc" <?= (isset($filtro_orden) && $filtro_orden == 'tipo_asc') ? 'selected' : '' ?>>Tipo (A-Z)</option>
                <option value="tipo_desc" <?= (isset($filtro_orden) && $filtro_orden == 'tipo_desc') ? 'selected' : '' ?>>Tipo (Z-A)</option>
              </select>
              <button type="submit" class="btn btn-accidentes-outline"><i class="bi bi-funnel"></i> Filtrar</button>
              <a href="?controller=accidentes&action=index" class="btn btn-secondary ms-2"><i class="bi bi-x-circle"></i> Limpiar</a>
            </form>
            <div class="text-end">
              <a href="?controller=accidentes&action=create" class="btn btn-accidentes"><i class="bi bi-plus-circle me-1"></i>Nuevo Accidente</a>
            </div>
          </div>
          <div class="table-responsive">
            <?php if (!empty($accidentes)): ?>
              <?php foreach ($accidentes as $acc): ?>
                <div class="card mb-4">
                  <div class="card-body">
                    <div class="row g-2">
                      <div class="col-md-6"><strong>ID:</strong></div><div class="col-md-6"><?= htmlspecialchars($acc['id_accidente']) ?></div>
                      <div class="col-md-6"><strong>Tipo:</strong></div><div class="col-md-6"><?= htmlspecialchars($acc['tipo']) ?></div>
                      <div class="col-md-6"><strong>Descripción:</strong></div><div class="col-md-6"><?= htmlspecialchars($acc['descripcion']) ?></div>
                      <div class="col-md-6"><strong>Clasificación:</strong></div><div class="col-md-6"><?= htmlspecialchars($acc['clasificacion']) ?></div>
                      <div class="col-md-6"><strong>Estado:</strong></div><div class="col-md-6"><?= htmlspecialchars($acc['estado']) ?></div>
                      <div class="col-md-6"><strong>Fecha y Hora:</strong></div><div class="col-md-6"><?= htmlspecialchars($acc['fecha_hora']) ?></div>
                      <div class="col-md-6"><strong>Lugar:</strong></div><div class="col-md-6"><?= htmlspecialchars($acc['lugar']) ?></div>
                      <div class="col-md-6"><strong>Tipo Vinculación Laboral:</strong></div><div class="col-md-6"><?= htmlspecialchars($acc['tipo_vinc_lab_']) ?></div>
                      <div class="col-md-6"><strong>Jornada Laboral:</strong></div><div class="col-md-6"><?= htmlspecialchars($acc['jornada_laboral']) ?></div>
                      <div class="col-md-6"><strong>Turno Momento Accidente:</strong></div><div class="col-md-6"><?= htmlspecialchars($acc['turno_mom_acc']) ?></div>
                      <div class="col-md-6"><strong>Uso EPP:</strong></div><div class="col-md-6"><?= htmlspecialchars($acc['uso_epp']) ?></div>
                      <div class="col-md-6"><strong>Consecuencias:</strong></div><div class="col-md-6"><?= htmlspecialchars($acc['consecuencias']) ?></div>
                      <div class="col-md-6"><strong>Gravedad:</strong></div><div class="col-md-6"><?= htmlspecialchars($acc['gravedad']) ?></div>
                      <div class="col-md-6"><strong>Tipo Lesión:</strong></div><div class="col-md-6"><?= htmlspecialchars($acc['tipo_lesion']) ?></div>
                      <div class="col-md-6"><strong>Parte Cuerpo Afectada:</strong></div><div class="col-md-6"><?= htmlspecialchars($acc['parte_cuerpo_afect']) ?></div>
                      <div class="col-md-6"><strong>Incapacidad Laboral:</strong></div><div class="col-md-6"><?= htmlspecialchars($acc['incapacidad_lab']) ?></div>
                      <div class="col-md-6"><strong>Atención Médica Recibida:</strong></div><div class="col-md-6"><?= htmlspecialchars($acc['aten_med_recibida']) ?></div>
                      <div class="col-md-6"><strong>Persona que Informó:</strong></div><div class="col-md-6"><?= htmlspecialchars($acc['persona_informo']) ?></div>
                    </div>
                    <div class="mt-3 text-end">
                      <a href="?controller=accidentes&action=edit&id=<?= $acc['id_accidente'] ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i> Editar</a>
                      <a href="?controller=accidentes&action=delete&id=<?= $acc['id_accidente'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro de eliminar?')"><i class="bi bi-trash"></i> Eliminar</a>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php else: ?>
              <div class="alert alert-info text-center">No hay accidentes registrados.</div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . '/../footer.php'; ?>
