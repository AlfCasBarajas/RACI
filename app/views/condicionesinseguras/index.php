<?php if (isset($data) && is_array($data)) extract($data); include __DIR__ . '/../header.php'; ?>
<style>
  .condiciones-bg { background: linear-gradient(135deg, #f5f7fa 0%, #e3eafc 100%); min-height: 100vh; padding-top: 40px; padding-bottom: 40px; }
  .condiciones-card { border-radius: 1.2rem; box-shadow: 0 2px 12px rgba(30,40,90,0.10); background: #fff; border: none; }
  .condiciones-title { color: #1a237e; font-weight: 700; letter-spacing: 1px; }
  .btn-condiciones { background: #1a237e; color: #fff; border-radius: 2rem; font-weight: 500; transition: background 0.2s; }
  .btn-condiciones:hover { background: #3949ab; color: #fff; }
  .btn-condiciones-outline { border: 2px solid #1a237e; color: #1a237e; background: #fff; border-radius: 2rem; font-weight: 500; transition: background 0.2s, color 0.2s; }
  .btn-condiciones-outline:hover { background: #1a237e; color: #fff; }
</style>
<div class="condiciones-bg">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="card condiciones-card p-4">
          <div class="mb-3">
            <div class="w-100 text-center mb-3">
              <h2 class="condiciones-title mb-0"><i class="bi bi-exclamation-triangle me-2"></i>Condiciones Inseguras</h2>
            </div>
            <form class="d-flex flex-wrap justify-content-center align-items-center gap-2 mb-2" method="get" action="">
              <input type="hidden" name="controller" value="condicionesinseguras">
              <input type="hidden" name="action" value="index">
              <input type="text" class="form-control" name="filtro_nombre" placeholder="Nombre" value="<?= isset($_GET['filtro_nombre']) ? htmlspecialchars($_GET['filtro_nombre']) : '' ?>" style="max-width: 180px;">
              <select class="form-select" name="filtro_orden" style="max-width: 160px;">
                <option value="nombre_asc" <?= (isset($_GET['filtro_orden']) && $_GET['filtro_orden'] == 'nombre_asc') ? 'selected' : '' ?>>Nombre (A-Z)</option>
                <option value="nombre_desc" <?= (isset($_GET['filtro_orden']) && $_GET['filtro_orden'] == 'nombre_desc') ? 'selected' : '' ?>>Nombre (Z-A)</option>
                <option value="id_asc" <?= (isset($_GET['filtro_orden']) && $_GET['filtro_orden'] == 'id_asc') ? 'selected' : '' ?>>ID (Asc)</option>
                <option value="id_desc" <?= (isset($_GET['filtro_orden']) && $_GET['filtro_orden'] == 'id_desc') ? 'selected' : '' ?>>ID (Desc)</option>
              </select>
              <button type="submit" class="btn btn-condiciones-outline"><i class="bi bi-funnel"></i> Filtrar</button>
              <a href="?controller=condicionesinseguras&action=index" class="btn btn-secondary ms-2"><i class="bi bi-x-circle"></i> Limpiar</a>
            </form>
            <div class="text-end">
              <a href="?controller=condicionesinseguras&action=create" class="btn btn-condiciones"><i class="bi bi-plus-circle me-1"></i>Nueva Condición</a>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table align-middle table-hover">
              <thead class="table-light">
                <tr>
                  <th>ID</th>
                  <th>Nombre</th>
                  <th>Descripción</th>
                  <th>Lugar</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($condiciones as $cond): ?>
                  <tr>
                    <td><?= htmlspecialchars($cond['id_cond_inseg']) ?></td>
                    <td><?= htmlspecialchars($cond['nombre']) ?></td>
                    <td><?= htmlspecialchars($cond['descripcion']) ?></td>
                    <td><?= htmlspecialchars($cond['lugar']) ?></td>
                    <td>
                      <a href="?controller=condicionesinseguras&action=edit&id=<?= $cond['id_cond_inseg'] ?>" class="btn btn-condiciones btn-sm me-2" title="Editar"><i class="bi bi-pencil me-1"></i>Editar</a>
                      <a href="?controller=condicionesinseguras&action=delete&id=<?= $cond['id_cond_inseg'] ?>" class="btn btn-condiciones-outline btn-sm" title="Eliminar" onclick="return confirm('¿Seguro que deseas eliminar esta condición?');"><i class="bi bi-trash me-1"></i>Eliminar</a>
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
