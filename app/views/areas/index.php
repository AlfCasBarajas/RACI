<?php if (isset($data) && is_array($data)) extract($data); include __DIR__ . '/../header.php'; ?>
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
      <div class="col-lg-10">
        <div class="card areas-card p-4">
          <div class="mb-3">
            <div class="w-100 text-center mb-3">
              <h2 class="areas-title mb-0"><i class="bi bi-building me-2"></i>Gestión de Áreas</h2>
            </div>
            <form class="d-flex flex-wrap justify-content-center align-items-center gap-2 mb-2" method="get" action="">
              <input type="hidden" name="controller" value="areas">
              <input type="hidden" name="action" value="index">
              <input type="text" class="form-control" name="filtro_nombre" placeholder="Nombre" value="<?= isset($_GET['filtro_nombre']) ? htmlspecialchars($_GET['filtro_nombre']) : '' ?>" style="max-width: 180px;">
              <select class="form-select" name="orden" style="max-width: 160px;">
                <option value="">Ordenar por</option>
                <option value="asc" <?= (isset($_GET['orden']) && $_GET['orden'] == 'asc') ? 'selected' : '' ?>>A-Z</option>
                <option value="desc" <?= (isset($_GET['orden']) && $_GET['orden'] == 'desc') ? 'selected' : '' ?>>Z-A</option>
              </select>
              <button type="submit" class="btn btn-areas-outline"><i class="bi bi-funnel"></i> Filtrar</button>
              <a href="?controller=areas&action=index" class="btn btn-secondary ms-2"><i class="bi bi-x-circle"></i> Limpiar</a>
            </form>
            <div class="text-end">
              <a href="?controller=areas&action=create" class="btn btn-areas"><i class="bi bi-plus-circle me-1"></i>Nueva Área</a>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table align-middle table-hover">
              <thead class="table-light">
                <tr>
                  <th>ID</th>
                  <th>Nombre</th>
                  <th>Descripción</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($areas as $area): ?>
                  <tr>
                    <td><?= htmlspecialchars($area['id_area']) ?></td>
                    <td><?= htmlspecialchars($area['nombre']) ?></td>
                    <td><?= htmlspecialchars($area['descripcion']) ?></td>
                    <td>
                      <a href="?controller=areas&action=edit&id=<?= $area['id_area'] ?>" class="btn btn-areas btn-sm me-2" title="Editar"><i class="bi bi-pencil me-1"></i>Editar</a>
                      <a href="?controller=areas&action=delete&id=<?= $area['id_area'] ?>" class="btn btn-areas-outline btn-sm" title="Eliminar" onclick="return confirm('¿Seguro que deseas eliminar esta área?');"><i class="bi bi-trash me-1"></i>Eliminar</a>
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
