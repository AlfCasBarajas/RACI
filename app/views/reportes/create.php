<?php if (isset($data) && is_array($data)) extract($data); include __DIR__ . '/../header.php'; ?>
<div class="container mt-4">
  <h2>Nuevo Reporte</h2>
  <form method="post" action="?controller=reportes&action=generarEmpleado">
    <div class="row">
      <div class="col-md-3 mb-2">
        <label for="nombre">Nombre del reporte:</label>
        <input type="text" name="nombre" id="nombre" class="form-control" required>
      </div>
      <div class="col-md-3 mb-2">
        <label for="fecha_actual">Fecha actual:</label>
        <input type="text" name="fecha_actual" id="fecha_actual" class="form-control" value="<?= date('Y-m-d') ?>" readonly>
      </div>
      <div class="col-md-3 mb-2">
        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" id="descripcion" class="form-control" rows="1" required></textarea>
      </div>
      <div class="col-md-3 mb-2">
        <label for="inspeccion_locativa_id_insp_loc">Inspección locativa:</label>
        <select name="inspeccion_locativa_id_insp_loc" id="inspeccion_locativa_id_insp_loc" class="form-select" required>
          <option value="">-- Selecciona inspección --</option>
          <?php if (isset($inspecciones) && is_array($inspecciones) && count($inspecciones) > 0): ?>
            <?php foreach ($inspecciones as $insp): ?>
              <option value="<?= $insp['id_insp_loc'] ?>"><?= $insp['id_insp_loc'] ?> - <?= htmlspecialchars($insp['tipo_inspeccion']) ?></option>
            <?php endforeach; ?>
          <?php else: ?>
            <option disabled>No hay inspecciones locativas registradas</option>
          <?php endif; ?>
        </select>
      </div>
      <div class="col-md-6 mb-2">
        <label for="tipo_reporte">Tipo de reporte:</label>
        <select name="tipo_reporte" id="tipo_reporte" class="form-select" required onchange="mostrarCampoEmpleado()">
          <option value="">-- Selecciona tipo de reporte --</option>
          <option value="usuarios">Usuarios</option>
          <option value="empleados">Empleados</option>
          <option value="roles">Roles</option>
          <option value="inspecciones">Inspecciones</option>
          <option value="categoria">Categoría</option>
          <option value="area">Área</option>
          <option value="riesgo">Riesgo</option>
          <option value="condiciones_inseguras">Condiciones Inseguras</option>
          <option value="incidentes">Incidentes</option>
          <option value="accidentes">Accidentes</option>
          <option value="inspecciones_locativas">Inspecciones Locativas</option>
        </select>
      </div>
      <div class="col-md-6 mb-2" id="campoEmpleado" style="display:none;">
        <label for="empleado_id">ID o número de documento del empleado:</label>
        <input type="text" name="empleado_id" id="empleado_id" class="form-control" placeholder="Ingrese el ID o número de documento">
      </div>
    </div>
    <script>
      function mostrarCampoEmpleado() {
        var tipo = document.getElementById('tipo_reporte').value;
        var campo = document.getElementById('campoEmpleado');
        campo.style.display = (tipo === 'empleados') ? 'block' : 'none';
      }
      document.addEventListener('DOMContentLoaded', mostrarCampoEmpleado);
    </script>
    </div>
    <div class="col-12 mt-3">
      <button type="submit" class="btn btn-primary">Generar reporte</button>
      <a href="?controller=reportes&action=index" class="btn btn-secondary">Cancelar</a>
    </div>
  </form>
  <?php if (!empty($reporteEmpleado)): ?>
    <?php if (!empty($inspeccionSeleccionada)): ?>
      <hr>
      <h4>Inspección Locativa Seleccionada</h4>
      <div class="card mb-2">
        <div class="card-body">
          <div><strong>ID Inspección:</strong> <?= htmlspecialchars($inspeccionSeleccionada['id_insp_loc']) ?></div>
          <div><strong>Tipo Inspección:</strong> <?= htmlspecialchars($inspeccionSeleccionada['tipo_inspeccion']) ?></div>
          <div><strong>Fecha y Hora:</strong> <?= htmlspecialchars($inspeccionSeleccionada['fecha_hora']) ?></div>
          <div><strong>Actividad Económica:</strong> <?= htmlspecialchars($inspeccionSeleccionada['act_economica']) ?></div>
          <div><strong>Descripción:</strong> <?= htmlspecialchars($inspeccionSeleccionada['descripcion']) ?></div>
          <div><strong>Estado Inspección:</strong> <?= htmlspecialchars($inspeccionSeleccionada['estado_inspeccion']) ?></div>
          <div><strong>Elementos de Trabajo:</strong> <?= htmlspecialchars($inspeccionSeleccionada['element_trab']) ?></div>
          <div><strong>Observaciones:</strong> <?= htmlspecialchars($inspeccionSeleccionada['observaciones']) ?></div>
        </div>
      </div>
    <?php endif; ?>
    <?php if (!empty($empleado) && !empty($nombre)): ?>
      <div class="alert alert-success">El reporte ha sido guardado correctamente.</div>
    <?php endif; ?>
    <hr>
    <h4>Reporte de incidentes y accidentes del empleado</h4>
    <div class="card mb-2">
      <div class="card-body">
        <div><strong>ID Empleado:</strong> <?= htmlspecialchars($reporteEmpleado['id_empleado']) ?></div>
        <div><strong>Nombre:</strong> <?= htmlspecialchars($reporteEmpleado['nombres']) ?></div>
        <div><strong>Apellidos:</strong> <?= htmlspecialchars($reporteEmpleado['apellidos']) ?></div>
      </div>
    </div>
    <?php if (!empty($reporteEmpleado['incidentes'])): ?>
      <h5>Incidentes</h5>
      <?php foreach ($reporteEmpleado['incidentes'] as $inc): ?>
        <div class="card mb-2">
          <div class="card-body">
            <div><strong>ID Incidente:</strong> <?= htmlspecialchars($inc['id_incidente']) ?></div>
            <div><strong>Tipo:</strong> <?= htmlspecialchars($inc['tipo']) ?></div>
            <div><strong>Fecha:</strong> <?= htmlspecialchars($inc['fecha_hora']) ?></div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
    <?php if (!empty($reporteEmpleado['accidentes'])): ?>
      <h5>Accidentes</h5>
      <?php foreach ($reporteEmpleado['accidentes'] as $acc): ?>
        <div class="card mb-2">
          <div class="card-body">
            <div><strong>ID Accidente:</strong> <?= htmlspecialchars($acc['id_accidente']) ?></div>
            <div><strong>Tipo:</strong> <?= htmlspecialchars($acc['tipo']) ?></div>
            <div><strong>Fecha:</strong> <?= htmlspecialchars($acc['fecha_hora']) ?></div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
    <?php if (empty($reporteEmpleado['incidentes']) && empty($reporteEmpleado['accidentes'])): ?>
      <div class="alert alert-info">No hay incidentes ni accidentes registrados en el periodo.</div>
    <?php endif; ?>
  <?php endif; ?>
</div>
<?php include __DIR__ . '/../footer.php'; ?>
