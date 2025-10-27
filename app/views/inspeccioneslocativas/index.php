<?php if (isset($data) && is_array($data)) extract($data); include __DIR__ . '/../header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php include __DIR__ . '/../sidebar.php'; ?>
        <main class="col-md-10 ms-sm-auto offset-md-2 px-4 main-content">
            <div style="border-radius: 1.2rem; box-shadow: 0 2px 12px rgba(30,40,90,0.10); background: #fff; border: none; padding: 2rem; margin-top: 2rem;">
                <h2 style="color: #1a237e; font-weight: 700; border-bottom: 3px solid #ffd600; margin-bottom: 2rem; padding-bottom: 0.5rem; text-align: center;"><i class="bi bi-clipboard-check me-2"></i>Gestión de Inspecciones Locativas</h2>
                
                <!-- Mensajes de éxito y error -->
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-2"></i><?= $_SESSION['success'] ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php unset($_SESSION['success']); ?>
                <?php endif; ?>
                
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i><?= $_SESSION['error'] ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>
                <!-- Filtros de búsqueda -->
                <div class="mb-3">
                    <form class="d-flex flex-wrap justify-content-center align-items-center gap-2 mb-2" method="get" action="">
                      <input type="hidden" name="controller" value="inspeccionlocativa">
                      <input type="hidden" name="action" value="index">
                      <input type="number" class="form-control" name="filtro_id" placeholder="ID" value="<?= isset($_GET['filtro_id']) ? htmlspecialchars($_GET['filtro_id']) : '' ?>" style="max-width: 90px;">
                      <input type="text" class="form-control" name="filtro_tipo_inspeccion" placeholder="Tipo Inspección" value="<?= isset($_GET['filtro_tipo_inspeccion']) ? htmlspecialchars($_GET['filtro_tipo_inspeccion']) : '' ?>" style="max-width: 130px;">
                      <input type="date" class="form-control" name="filtro_fecha_hora" value="<?= isset($_GET['filtro_fecha_hora']) ? htmlspecialchars($_GET['filtro_fecha_hora']) : '' ?>" style="max-width: 130px;">
                      <input type="text" class="form-control" name="filtro_estado_inspeccion" placeholder="Estado" value="<?= isset($_GET['filtro_estado_inspeccion']) ? htmlspecialchars($_GET['filtro_estado_inspeccion']) : '' ?>" style="max-width: 110px;">
                      <select class="form-select" name="filtro_orden" style="max-width: 160px;">
                        <option value="id_asc" <?= (isset($filtro_orden) && $filtro_orden == 'id_asc') ? 'selected' : '' ?>>ID (Asc)</option>
                        <option value="id_desc" <?= (isset($filtro_orden) && $filtro_orden == 'id_desc') ? 'selected' : '' ?>>ID (Desc)</option>
                        <option value="fecha_asc" <?= (isset($filtro_orden) && $filtro_orden == 'fecha_asc') ? 'selected' : '' ?>>Fecha (Asc)</option>
                        <option value="fecha_desc" <?= (isset($filtro_orden) && $filtro_orden == 'fecha_desc') ? 'selected' : '' ?>>Fecha (Desc)</option>
                      </select>
                      <button type="submit" class="btn btn-primary"><i class="bi bi-funnel"></i> Filtrar</button>
                      <a href="?controller=inspeccionlocativa&action=index" class="btn btn-secondary ms-2"><i class="bi bi-x-circle"></i> Limpiar</a>
                    </form>
                    <div class="text-end">
                      <?php if (!$isTrabajador): ?>
                        <a href="?controller=inspeccionlocativa&action=create" class="btn btn-success"><i class="bi bi-plus-circle me-1"></i>Nueva Inspección</a>
                      <?php endif; ?>
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
                      <div class="col-md-6"><strong>Descripción:</strong></div><div class="col-md-6"><?= htmlspecialchars($insp['descripcion']) ?></div>
                      <div class="col-md-6"><strong>Estado Inspección:</strong></div><div class="col-md-6"><?= htmlspecialchars($insp['estado_inspeccion']) ?></div>
                      <div class="col-md-6"><strong>Elementos de Trabajo:</strong></div><div class="col-md-6"><?= htmlspecialchars($insp['element_trab']) ?></div>
                      <div class="col-md-6"><strong>Observaciones:</strong></div><div class="col-md-6"><?= htmlspecialchars($insp['observaciones']) ?></div>
                      <div class="col-md-6"><strong>Categoría:</strong></div><div class="col-md-6"><?= htmlspecialchars($insp['categoria_nombre'] ?? $insp['categoria_id_categoria']) ?></div>
                      <div class="col-md-6"><strong>Incidente:</strong></div><div class="col-md-6"><?= htmlspecialchars($insp['incidente_tipo'] ?? $insp['incidente_id_incidente']) ?></div>
                      <div class="col-md-6"><strong>Accidente:</strong></div><div class="col-md-6"><?= htmlspecialchars($insp['accidente_tipo'] ?? $insp['accidente_id_accidente']) ?></div>
                      <div class="col-md-6"><strong>Riesgo:</strong></div><div class="col-md-6"><?= htmlspecialchars($insp['riesgo_tipo'] ?? $insp['riesgo_id_riesgo']) ?></div>
                      <div class="col-md-6"><strong>Empleado:</strong></div><div class="col-md-6"><?= htmlspecialchars((isset($insp['empleado_nombres']) ? $insp['empleado_nombres'] . ' ' . $insp['empleado_apellidos'] : $insp['empleado_id_empleado'])) ?></div>
                      <div class="col-md-6"><strong>Área:</strong></div><div class="col-md-6"><?= htmlspecialchars($insp['area_nombre'] ?? $insp['area_id_area']) ?></div>
                    </div>
                    <div class="mt-3 text-end">
                      <?php if (!$isTrabajador): ?>
                        <a href="?controller=inspeccionlocativa&action=edit&id=<?= $insp['id_insp_loc'] ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i> Editar</a>
                      <?php endif; ?>
                      <?php if (!$isCoordinador && !$isSupervisor && !$isTrabajador): ?>
                        <a href="?controller=inspeccionlocativa&action=delete&id=<?= $insp['id_insp_loc'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro de eliminar?')"><i class="bi bi-trash"></i> Eliminar</a>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php else: ?>
              <div class="alert alert-info text-center">No hay inspecciones registradas.</div>
            <?php endif; ?>
          </div>
        
        </main>
    </div>
</div>
<?php include __DIR__ . '/../footer.php'; ?>
