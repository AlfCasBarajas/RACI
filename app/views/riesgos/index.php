<?php if (isset($data) && is_array($data)) extract($data); include __DIR__ . '/../header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php include __DIR__ . '/../sidebar.php'; ?>
        <main class="col-md-10 ms-sm-auto offset-md-2 px-4 main-content">
            <div style="border-radius: 1.2rem; box-shadow: 0 2px 12px rgba(30,40,90,0.10); background: #fff; border: none; padding: 2rem; margin-top: 2rem;">
                <h2 style="color: #1a237e; font-weight: 700; border-bottom: 3px solid #ffd600; margin-bottom: 1.5rem; padding-bottom: 0.5rem; text-align: center;"><i class="bi bi-shield-check me-2"></i>Gestión de Riesgos</h2>
                
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
                
                <!-- Filtros de búsqueda -->
                <div class="mb-4">
                    <form class="d-flex flex-wrap justify-content-center align-items-center gap-2 mb-2" method="get" action="">
                      <input type="hidden" name="controller" value="riesgos">
                      <input type="hidden" name="action" value="index">
                      <input type="text" class="form-control" name="filtro_tipo" placeholder="Tipo" value="<?= isset($_GET['filtro_tipo']) ? htmlspecialchars($_GET['filtro_tipo']) : '' ?>" style="max-width: 150px;">
                      <select class="form-select" name="filtro_condicion" style="max-width: 180px;">
                        <option value="">Condición Insegura</option>
                        <?php foreach ($condiciones as $cond): ?>
                          <option value="<?= $cond['id_cond_inseg'] ?>" <?= (isset($_GET['filtro_condicion']) && $_GET['filtro_condicion'] == $cond['id_cond_inseg']) ? 'selected' : '' ?>><?= htmlspecialchars($cond['nombre']) ?></option>
                        <?php endforeach; ?>
                      </select>
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
                      <button type="submit" class="btn btn-primary"><i class="bi bi-funnel"></i> Filtrar</button>
                      <a href="?controller=riesgos&action=index" class="btn btn-secondary ms-2"><i class="bi bi-x-circle"></i> Limpiar</a>
                    </form>
                    <div class="text-end">
                      <?php if (!$isTrabajador): ?>
                      <a href="?controller=riesgos&action=create" class="btn btn-success"><i class="bi bi-plus"></i> Nuevo Riesgo</a>
                      <?php endif; ?>
                    </div>
                </div>

                <!-- Tabla de riesgos -->
                <div class="table-responsive">
            <table class="table align-middle table-hover">
              <thead class="table-light">
                <tr>
                  <th>ID</th>
                  <th>Tipo</th>
                  <th>Descripción</th>
                  <th>Condición Insegura</th>
                  <th>Área</th>
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
                    <td><?= htmlspecialchars($riesgo['nombre_area']) ?></td>
                    <td>
                      <?php if (!$isTrabajador): ?>
                        <a href="?controller=riesgos&action=edit&id=<?= $riesgo['id_riesgo'] ?>" class="btn btn-primary btn-sm me-2" title="Editar"><i class="bi bi-pencil me-1"></i>Editar</a>
                      <?php endif; ?>
                      <?php if (!$isCoordinador && !$isSupervisor && !$isTrabajador): ?>
                        <a href="?controller=riesgos&action=delete&id=<?= $riesgo['id_riesgo'] ?>" class="btn btn-outline-danger btn-sm" title="Eliminar" onclick="return confirm('¿Seguro que deseas eliminar este riesgo?');"><i class="bi bi-trash me-1"></i>Eliminar</a>
                      <?php endif; ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        
        </main>
    </div>
</div>
<?php include __DIR__ . '/../footer.php'; ?>
