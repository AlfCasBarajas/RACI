<?php if (isset($data) && is_array($data)) extract($data); include __DIR__ . '/../header.php'; ?>
<a href="app/views/dashboard.php" class="btn btn-secondary mb-3">Volver a inicio</a>
<style>
  .incidentes-bg { background: linear-gradient(135deg, #f5f7fa 0%, #e3eafc 100%); min-height: 100vh; padding-top: 40px; padding-bottom: 40px; }
  .incidentes-card { border-radius: 1.2rem; box-shadow: 0 2px 12px rgba(30,40,90,0.10); background: #fff; border: none; }
  .incidentes-title { color: #1a237e; font-weight: 700; letter-spacing: 1px; }
  .btn-incidentes { background: #1a237e; color: #fff; border-radius: 2rem; font-weight: 500; transition: background 0.2s; }
  .btn-incidentes:hover { background: #3949ab; color: #fff; }
  .btn-incidentes-outline { border: 2px solid #1a237e; color: #1a237e; background: #fff; border-radius: 2rem; font-weight: 500; transition: background 0.2s, color 0.2s; }
  .btn-incidentes-outline:hover { background: #1a237e; color: #fff; }
</style>
<div class="incidentes-bg">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="card incidentes-card p-4">
          <div class="mb-3">
            <div class="w-100 text-center mb-3">
              <h2 class="incidentes-title mb-0"><i class="bi bi-exclamation-triangle me-2"></i>Gestión de Incidentes</h2>
            </div>
            <form class="d-flex flex-wrap justify-content-center align-items-center gap-2 mb-2" method="get" action="">
              <input type="hidden" name="controller" value="incidentes">
              <input type="hidden" name="action" value="index">
              <input type="text" class="form-control" name="filtro_tipo" placeholder="Tipo" value="<?= isset($_GET['filtro_tipo']) ? htmlspecialchars($_GET['filtro_tipo']) : '' ?>" style="max-width: 120px;">
              <input type="date" class="form-control" name="filtro_fecha" value="<?= isset($_GET['filtro_fecha']) ? htmlspecialchars($_GET['filtro_fecha']) : '' ?>" style="max-width: 150px;">
              <input type="text" class="form-control" name="filtro_lugar" placeholder="Lugar" value="<?= isset($_GET['filtro_lugar']) ? htmlspecialchars($_GET['filtro_lugar']) : '' ?>" style="max-width: 120px;">
              <select class="form-select" name="filtro_orden" style="max-width: 160px;">
                <option value="id_asc" <?= (isset($filtro_orden) && $filtro_orden == 'id_asc') ? 'selected' : '' ?>>ID (Asc)</option>
                <option value="id_desc" <?= (isset($filtro_orden) && $filtro_orden == 'id_desc') ? 'selected' : '' ?>>ID (Desc)</option>
                <option value="tipo_asc" <?= (isset($filtro_orden) && $filtro_orden == 'tipo_asc') ? 'selected' : '' ?>>Tipo (A-Z)</option>
                <option value="tipo_desc" <?= (isset($filtro_orden) && $filtro_orden == 'tipo_desc') ? 'selected' : '' ?>>Tipo (Z-A)</option>
              </select>
              <button type="submit" class="btn btn-incidentes-outline"><i class="bi bi-funnel"></i> Filtrar</button>
              <a href="?controller=incidentes&action=index" class="btn btn-secondary ms-2"><i class="bi bi-x-circle"></i> Limpiar</a>
            </form>
            <div class="text-end">
              <a href="?controller=incidentes&action=create" class="btn btn-incidentes"><i class="bi bi-plus-circle me-1"></i>Nuevo Incidente</a>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table align-middle table-hover">
              <thead class="table-light">
                <tr>
                  <th>ID</th>
                  <th>Tipo</th>
                  <th>Descripción</th>
                  <th>Fecha</th>
                  <th>Lugar</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($incidentes as $inc): ?>
                  <tr>
                    <td><?= htmlspecialchars($inc['id_incidente']) ?></td>
                    <td><?= htmlspecialchars($inc['tipo']) ?></td>
                    <td><?= htmlspecialchars($inc['descripcion']) ?></td>
                    <td><?= htmlspecialchars($inc['fecha_hora']) ?></td>
                    <td><?= htmlspecialchars($inc['lugar']) ?></td>
                    <td>
                      <a href="?controller=incidentes&action=edit&id=<?= $inc['id_incidente'] ?>" class="btn btn-incidentes btn-sm me-2" title="Editar"><i class="bi bi-pencil me-1"></i>Editar</a>
                      <a href="?controller=incidentes&action=delete&id=<?= $inc['id_incidente'] ?>" class="btn btn-incidentes-outline btn-sm" title="Eliminar" onclick="return confirm('¿Seguro que deseas eliminar este incidente?');"><i class="bi bi-trash me-1"></i>Eliminar</a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . '/../footer.php'; ?>
