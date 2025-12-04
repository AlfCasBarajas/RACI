<?php if (isset($data) && is_array($data)) extract($data); include __DIR__ . '/../header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <!-- Incluir sidebar -->
        <?php include __DIR__ . '/../sidebar.php'; ?>
        
        <!-- Contenido principal -->
        <main class="col-md-10 ms-sm-auto offset-md-2 px-4 main-content">
            <style>
                .incidentes-card {
                    border-radius: 1.2rem;
                    box-shadow: 0 2px 12px rgba(30,40,90,0.10);
                    background: #fff;
                    border: none;
                    padding: 2rem;
                    margin-top: 2rem;
                }
                .incidentes-title {
                    color: #1a237e;
                    font-weight: 700;
                    border-bottom: 3px solid #ffd600;
                    margin-bottom: 2rem;
                    padding-bottom: 0.5rem;
                }
                .btn-incidentes {
                    background: #3949ab;
                    color: #fff;
                    border-radius: 2rem;
                    font-weight: 600;
                    border: 2px solid #ffd600;
                    transition: background 0.2s, border 0.2s;
                }
                .btn-incidentes:hover {
                    background: #ffd600;
                    color: #3949ab;
                    border: 2px solid #3949ab;
                }
                .btn-incidentes-outline {
                    border: 2px solid #3949ab;
                    color: #3949ab;
                    background: #fff;
                    border-radius: 2rem;
                    font-weight: 600;
                    transition: background 0.2s, color 0.2s;
                }
                .btn-incidentes-outline:hover {
                    background: #3949ab;
                    color: #fff;
                    border: 2px solid #ffd600;
                }
            </style>
    
</style>
<div class="incidentes-bg">
  <div class="d-flex flex-column align-items-center justify-content-center min-vh-100">
    <div class="card incidentes-card p-4 w-100" style="max-width:1200px;">
          <div class="mb-3">
            <div class="w-100 text-center mb-3">
              <h2 class="incidentes-title mb-0"><i class="bi bi-exclamation-triangle me-2"></i>Gestión de Incidentes</h2>
            </div>
            
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i><?= $_SESSION['success'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <div><?= nl2br(htmlspecialchars($_SESSION['error'])) ?></div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>
            
            <form class="d-flex flex-wrap justify-content-center align-items-center gap-2 mb-2" method="get" action="">
              <input type="hidden" name="controller" value="incidentes">
              <input type="hidden" name="action" value="index">
              <input type="text" class="form-control" name="filtro_tipo" placeholder="Tipo" value="<?= isset($_GET['filtro_tipo']) ? htmlspecialchars($_GET['filtro_tipo']) : '' ?>" style="max-width: 120px;">
              <input type="date" class="form-control" name="filtro_fecha" value="<?= isset($_GET['filtro_fecha']) ? htmlspecialchars($_GET['filtro_fecha']) : '' ?>" style="max-width: 150px;">
              <input type="text" class="form-control" name="filtro_lugar" placeholder="Lugar" value="<?= isset($_GET['filtro_lugar']) ? htmlspecialchars($_GET['filtro_lugar']) : '' ?>" style="max-width: 120px;">
              <select class="form-select" name="filtro_area" style="max-width: 150px;">
                <option value="">Todas las áreas</option>
                <?php if (isset($areas)): ?>
                  <?php foreach ($areas as $area): ?>
                    <option value="<?= $area['id_area'] ?>" <?= (isset($filtro_area) && $filtro_area == $area['id_area']) ? 'selected' : '' ?>>
                      <?= htmlspecialchars($area['nombre']) ?>
                    </option>
                  <?php endforeach; ?>
                <?php endif; ?>
              </select>
              <select class="form-select" name="filtro_orden" style="max-width: 160px;">
                <option value="id_asc" <?= (isset($filtro_orden) && $filtro_orden == 'id_asc') ? 'selected' : '' ?>>ID (Asc)</option>
                <option value="id_desc" <?= (isset($filtro_orden) && $filtro_orden == 'id_desc') ? 'selected' : '' ?>>ID (Desc)</option>
                <option value="tipo_asc" <?= (isset($filtro_orden) && $filtro_orden == 'tipo_asc') ? 'selected' : '' ?>>Tipo (A-Z)</option>
                <option value="tipo_desc" <?= (isset($filtro_orden) && $filtro_orden == 'tipo_desc') ? 'selected' : '' ?>>Tipo (Z-A)</option>
                <option value="area_asc" <?= (isset($filtro_orden) && $filtro_orden == 'area_asc') ? 'selected' : '' ?>>Área (A-Z)</option>
                <option value="area_desc" <?= (isset($filtro_orden) && $filtro_orden == 'area_desc') ? 'selected' : '' ?>>Área (Z-A)</option>
              </select>
              <button type="submit" class="btn btn-incidentes-outline"><i class="bi bi-funnel"></i> Filtrar</button>
              <a href="?controller=incidentes&action=index" class="btn btn-secondary ms-2"><i class="bi bi-x-circle"></i> Limpiar</a>
            </form>
            <div class="text-end">
              <?php if (!$isTrabajador): ?>
                <a href="?controller=incidentes&action=create" class="btn btn-incidentes"><i class="bi bi-plus-circle me-1"></i>Nuevo Incidente</a>
              <?php endif; ?>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table align-middle table-hover">
              <thead class="table-light">
                <tr>
                  <th>ID</th>
                  <th>Tipo</th>
                  <th>Fecha</th>
                  <th>Lugar</th>
                  <th>Vinculación</th>
                  <th>Jornada</th>
                  <th>Turno/Momento</th>
                  <th>Descripción</th>
                  <th>Uso EPP</th>
                  <th>Área</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($incidentes as $inc): ?>
                  <tr>
                    <td><?= htmlspecialchars($inc['id_incidente']) ?></td>
                    <td><?= htmlspecialchars($inc['tipo']) ?></td>
                    <td><?= htmlspecialchars($inc['fecha_hora']) ?></td>
                    <td><?= htmlspecialchars($inc['lugar']) ?></td>
                    <td><?= htmlspecialchars($inc['tipo_vinc_lab'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($inc['jornada_laboral'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($inc['turno_mom_inc'] ?? '-') ?></td>
                    <td><?= htmlspecialchars(substr($inc['descripcion'], 0, 50)) ?><?= strlen($inc['descripcion']) > 50 ? '...' : '' ?></td>
                    <td><?= htmlspecialchars(substr($inc['uso_epp'] ?? '', 0, 30)) ?><?= strlen($inc['uso_epp'] ?? '') > 30 ? '...' : '' ?></td>
                    <td><?= htmlspecialchars($inc['nombre_area']) ?></td>
                    <td>
                      <?php if (!$isTrabajador): ?>
                        <a href="?controller=incidentes&action=edit&id=<?= $inc['id_incidente'] ?>" class="btn btn-incidentes btn-sm me-2" title="Editar"><i class="bi bi-pencil me-1"></i>Editar</a>
                      <?php endif; ?>
                      <?php if (!$isCoordinador && !$isSupervisor && !$isTrabajador): ?>
                        <a href="?controller=incidentes&action=delete&id=<?= $inc['id_incidente'] ?>" class="btn btn-incidentes-outline btn-sm" title="Eliminar" onclick="return confirm('¿Seguro que deseas eliminar este incidente?');"><i class="bi bi-trash me-1"></i>Eliminar</a>
                      <?php else: ?>
                        <!--<button class="btn btn-disabled btn-sm" disabled title="No tienes permisos para eliminar incidentes"><i class="bi bi-trash me-1"></i>Eliminar</button>-->
                      <?php endif; ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include __DIR__ . '/../footer.php'; ?>
