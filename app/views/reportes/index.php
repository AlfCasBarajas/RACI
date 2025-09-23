<?php
// Función auxiliar para obtener el empleado relacionado a una categoría
function getEmpleadoByCategoria($catId) {
  try {
    $pdo = new PDO('mysql:host=localhost;dbname=raci_db', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->prepare('SELECT e.* FROM categoria c JOIN empleado e ON c.empleado_id_empleado = e.id_empleado WHERE c.id_categoria = ?');
    $stmt->execute([$catId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  } catch (Exception $ex) {
    return null;
  }
}
if (isset($data) && is_array($data)) extract($data);
include __DIR__ . '/../header.php';
// ...aquí termina el bloque PHP, el resto es HTML y CSS...
?>
<a href="app/views/dashboard.php" class="btn btn-secondary mb-3">Volver a inicio</a>
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
              <hr>
              <h4>Reportes generados:</h4>
              <?php foreach ($reportes as $reporte): ?>
                <div class="card mb-2">
                  <div class="card-body">
                    <div><strong>ID Reporte:</strong> <?= htmlspecialchars($reporte['id_reporte']) ?></div>
                    <div><strong>Nombre:</strong> <?= htmlspecialchars($reporte['nombre']) ?></div>
                    <div><strong>Fecha:</strong> <?= htmlspecialchars($reporte['fecha_hora']) ?></div>
                    <div><strong>Descripción:</strong> <?= htmlspecialchars($reporte['descripcion']) ?></div>
                    <?php if (!empty($reporte['inspeccion_locativa'])): ?>
                      <?php if (!empty($reporte['inspeccion_locativa']['categoria_id_categoria'])): ?>
                        <?php
                        // Obtener datos del empleado relacionado a la categoría
                        $catId = $reporte['inspeccion_locativa']['categoria_id_categoria'];
                        $empleado = null;
                        if (function_exists('getEmpleadoByCategoria')) {
                          $empleado = getEmpleadoByCategoria($catId);
                        }
                        ?>
                        <?php if (!empty($empleado)): ?>
                          <hr>
                          <h5>Empleado relacionado</h5>
                          <div><strong>ID:</strong> <?= htmlspecialchars($empleado['id_empleado']) ?></div>
                          <div><strong>Nombres:</strong> <?= htmlspecialchars($empleado['nombres']) ?></div>
                          <div><strong>Apellidos:</strong> <?= htmlspecialchars($empleado['apellidos']) ?></div>
                          <div><strong>Teléfono:</strong> <?= htmlspecialchars($empleado['telefono']) ?></div>
                          <div><strong>Cargo/Función:</strong> <?= htmlspecialchars($empleado['cargo_funcion']) ?></div>
                          <hr>
                          <h5>Incidentes asociados al empleado</h5>
                          <?php
                          // Consultar incidentes asociados al empleado
                          try {
                            $pdo = new PDO('mysql:host=localhost;dbname=raci_db', 'root', '');
                            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            $stmt = $pdo->prepare('SELECT * FROM incidente WHERE id_incidente IN (SELECT il.incidente_id_incidente FROM inspeccion_locativa il JOIN categoria c ON il.categoria_id_categoria = c.id_categoria WHERE c.empleado_id_empleado = ?)');
                            $stmt->execute([$empleado['id_empleado']]);
                            $incidentesEmpleado = $stmt->fetchAll(PDO::FETCH_ASSOC);
                          } catch (Exception $ex) {
                            $incidentesEmpleado = [];
                          }
                          ?>
                          <?php if (!empty($incidentesEmpleado)): ?>
                            <?php foreach ($incidentesEmpleado as $inc): ?>
                              <div class="card mb-2">
                                <div class="card-body">
                                  <div><strong>ID Incidente:</strong> <?= htmlspecialchars($inc['id_incidente']) ?></div>
                                  <div><strong>Tipo:</strong> <?= htmlspecialchars($inc['tipo']) ?></div>
                                  <div><strong>Fecha:</strong> <?= htmlspecialchars($inc['fecha_hora']) ?></div>
                                  <div><strong>Descripción:</strong> <?= htmlspecialchars($inc['descripcion']) ?></div>
                                  <div><strong>Lugar:</strong> <?= htmlspecialchars($inc['lugar']) ?></div>
                                  <!-- Puedes agregar más campos si lo deseas -->
                                </div>
                              </div>
                            <?php endforeach; ?>
                          <?php else: ?>
                            <div class="alert alert-info">No hay incidentes asociados al empleado.</div>
                          <?php endif; ?>
                          <h5>Accidentes asociados al empleado</h5>
                          <?php
                          // Consultar accidentes asociados al empleado
                          try {
                            $stmt = $pdo->prepare('SELECT * FROM accidente WHERE id_accidente IN (SELECT il.accidente_id_accidente FROM inspeccion_locativa il JOIN categoria c ON il.categoria_id_categoria = c.id_categoria WHERE c.empleado_id_empleado = ?)');
                            $stmt->execute([$empleado['id_empleado']]);
                            $accidentesEmpleado = $stmt->fetchAll(PDO::FETCH_ASSOC);
                          } catch (Exception $ex) {
                            $accidentesEmpleado = [];
                          }
                          ?>
                          <?php if (!empty($accidentesEmpleado)): ?>
                            <?php foreach ($accidentesEmpleado as $acc): ?>
                              <div class="card mb-2">
                                <div class="card-body">
                                  <div><strong>ID Accidente:</strong> <?= htmlspecialchars($acc['id_accidente']) ?></div>
                                  <div><strong>Tipo:</strong> <?= htmlspecialchars($acc['tipo']) ?></div>
                                  <div><strong>Fecha:</strong> <?= htmlspecialchars($acc['fecha_hora']) ?></div>
                                  <div><strong>Descripción:</strong> <?= htmlspecialchars($acc['descripcion']) ?></div>
                                  <div><strong>Lugar:</strong> <?= htmlspecialchars($acc['lugar']) ?></div>
                                  <!-- Puedes agregar más campos si lo deseas -->
                                </div>
                              </div>
                            <?php endforeach; ?>
                          <?php else: ?>
                            <div class="alert alert-info">No hay accidentes asociados al empleado.</div>
                          <?php endif; ?>
                        <?php endif; ?>
                      <?php endif; ?>
                      <hr>
                      <h5>Inspección locativa relacionada</h5>
                      <div><strong>ID:</strong> <?= htmlspecialchars($reporte['inspeccion_locativa']['id_insp_loc']) ?></div>
                      <div><strong>Tipo:</strong> <?= htmlspecialchars($reporte['inspeccion_locativa']['tipo_inspeccion']) ?></div>
                      <div><strong>Fecha:</strong> <?= htmlspecialchars($reporte['inspeccion_locativa']['fecha_hora']) ?></div>
                      <div><strong>Actividad económica:</strong> <?= htmlspecialchars($reporte['inspeccion_locativa']['act_economica']) ?></div>
                      <div><strong>Descripción:</strong> <?= htmlspecialchars($reporte['inspeccion_locativa']['descripcion']) ?></div>
                      <div><strong>Estado:</strong> <?= htmlspecialchars($reporte['inspeccion_locativa']['estado_inspeccion']) ?></div>
                      <div><strong>Elementos de trabajo:</strong> <?= htmlspecialchars($reporte['inspeccion_locativa']['element_trab']) ?></div>
                      <div><strong>Observaciones:</strong> <?= htmlspecialchars($reporte['inspeccion_locativa']['observaciones']) ?></div>
                    <?php else: ?>
                      <div><strong>Inspección locativa:</strong> <?= htmlspecialchars($reporte['inspeccion_locativa_id_insp_loc']) ?></div>
                    <?php endif; ?>
                    <?php if (isset($reporte['incidentes']) || isset($reporte['accidentes'])): ?>
                      <hr>
                      <h5>Incidentes</h5>
                      <?php if (!empty($reporte['incidentes'])): ?>
                        <?php foreach ($reporte['incidentes'] as $inc): ?>
                          <div class="card mb-2">
                            <div class="card-body">
                              <div><strong>ID Incidente:</strong> <?= htmlspecialchars($inc['id_incidente']) ?></div>
                              <div><strong>Tipo:</strong> <?= htmlspecialchars($inc['tipo']) ?></div>
                              <div><strong>Fecha:</strong> <?= htmlspecialchars($inc['fecha_hora']) ?></div>
                            </div>
                          </div>
                        <?php endforeach; ?>
                      <?php else: ?>
                        <div class="alert alert-info">No hay incidentes registrados.</div>
                      <?php endif; ?>
                      <h5>Accidentes</h5>
                      <?php if (!empty($reporte['accidentes'])): ?>
                        <?php foreach ($reporte['accidentes'] as $acc): ?>
                          <div class="card mb-2">
                            <div class="card-body">
                              <div><strong>ID Accidente:</strong> <?= htmlspecialchars($acc['id_accidente']) ?></div>
                              <div><strong>Tipo:</strong> <?= htmlspecialchars($acc['tipo']) ?></div>
                              <div><strong>Fecha:</strong> <?= htmlspecialchars($acc['fecha_hora']) ?></div>
                            </div>
                          </div>
                        <?php endforeach; ?>
                      <?php else: ?>
                        <div class="alert alert-info">No hay accidentes registrados.</div>
                      <?php endif; ?>
                    <?php endif; ?>
                    <div class="text-end mt-2">
                      <a href="?controller=reportes&action=edit&id=<?= $reporte['id_reporte'] ?>" class="btn btn-warning btn-sm me-1"><i class="bi bi-pencil"></i> Editar</a>
                      <a href="?controller=reportes&action=delete&id=<?= $reporte['id_reporte'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de eliminar este reporte?');"><i class="bi bi-trash"></i> Eliminar</a>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
              <?php if (empty($reportes)): ?>
                <div class="alert alert-info">No hay reportes para mostrar.</div>
              <?php endif; ?>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . '/../footer.php'; ?>
