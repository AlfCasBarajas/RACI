<?php if (isset($data) && is_array($data)) extract($data); include __DIR__ . '/../header.php'; ?>
<style>
  .riesgos-bg { background: linear-gradient(135deg, #f5f7fa 0%, #e3eafc 100%); min-height: 100vh; padding-top: 40px; padding-bottom: 40px; }
  .riesgos-card { border-radius: 1.2rem; box-shadow: 0 2px 12px rgba(30,40,90,0.10); background: #fff; border: none; }
  .riesgos-title { color: #1a237e; font-weight: 700; letter-spacing: 1px; }
  .btn-riesgos { background: #1a237e; color: #fff; border-radius: 2rem; font-weight: 500; transition: background 0.2s; }
  .btn-riesgos:hover { background: #3949ab; color: #fff; }
  .btn-riesgos-outline { border: 2px solid #1a237e; color: #1a237e; background: #fff; border-radius: 2rem; font-weight: 500; transition: background 0.2s, color 0.2s; }
  .btn-riesgos-outline:hover { background: #1a237e; color: #fff; }
</style>
<div class="riesgos-bg">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="card riesgos-card p-4">
          <div class="mb-3">
            <div class="w-100 text-center mb-3">
              <h2 class="riesgos-title mb-0"><i class="bi bi-shield-check me-2"></i>Gestión de Riesgos</h2>
            </div>
            <form class="d-flex flex-wrap justify-content-center align-items-center gap-2 mb-2" method="get" action="">
              <input type="hidden" name="controller" value="riesgos">
              <input type="hidden" name="action" value="index">
              <input type="text" class="form-control" name="filtro_tipo" placeholder="Tipo" value="<?= isset($_GET['filtro_tipo']) ? htmlspecialchars($_GET['filtro_tipo']) : '' ?>" style="max-width: 180px;">
              <select class="form-select" name="filtro_condicion" style="max-width: 180px;">
                <option value="">Condición Insegura</option>
                <?php foreach ($condiciones as $cond): ?>
                  <option value="<?= $cond['id_cond_inseg'] ?>" <?= (isset($_GET['filtro_condicion']) && $_GET['filtro_condicion'] == $cond['id_cond_inseg']) ? 'selected' : '' ?>><?= htmlspecialchars($cond['nombre']) ?></option>
                <?php endforeach; ?>
              </select>
              <button type="submit" class="btn btn-riesgos-outline"><i class="bi bi-funnel"></i> Filtrar</button>
              <a href="?controller=riesgos&action=index" class="btn btn-secondary ms-2"><i class="bi bi-x-circle"></i> Limpiar</a>
            </form>
            <div class="text-end">
              <a href="?controller=riesgos&action=create" class="btn btn-riesgos"><i class="bi bi-plus-circle me-1"></i>Nuevo Riesgo</a>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table align-middle table-hover">
              <thead class="table-light">
                <tr>
                  <th>ID</th>
                  <th>Tipo</th>
                  <th>Descripción</th>
                  <th>Condición Insegura</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($riesgos as $riesgo): ?>
                  <tr>
                    <td><?= htmlspecialchars($riesgo['id_riesgo']) ?></td>
                    <td><?= htmlspecialchars($riesgo['tipo']) ?></td>
                    <td><?= htmlspecialchars($riesgo['descripcion']) ?></td>
                    <td><?= htmlspecialchars($riesgo['condicion_nombre']) ?></td>
                    <td>
                      <a href="?controller=riesgos&action=edit&id=<?= $riesgo['id_riesgo'] ?>" class="btn btn-riesgos btn-sm me-2" title="Editar"><i class="bi bi-pencil me-1"></i>Editar</a>
                      <a href="?controller=riesgos&action=delete&id=<?= $riesgo['id_riesgo'] ?>" class="btn btn-riesgos-outline btn-sm" title="Eliminar" onclick="return confirm('¿Seguro que deseas eliminar este riesgo?');"><i class="bi bi-trash me-1"></i>Eliminar</a>
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
