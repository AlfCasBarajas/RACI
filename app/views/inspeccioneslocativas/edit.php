<?php if (isset($data) && is_array($data)) extract($data); include __DIR__ . '/../header.php'; ?>
<div class="container mt-4">
  <h2>Editar Inspección Locativa</h2>
  <form method="post" action="?controller=inspeccionlocativa&action=update&id=<?= $inspeccion['id_insp_loc'] ?>">
    <div class="row">
      <div class="col-md-4 mb-2"><label>Tipo Inspección</label><input type="text" name="tipo_inspeccion" class="form-control" value="<?= htmlspecialchars($inspeccion['tipo_inspeccion']) ?>"></div>
      <div class="col-md-4 mb-2"><label>Fecha y Hora</label><input type="datetime-local" name="fecha_hora" class="form-control" value="<?= date('Y-m-d\TH:i', strtotime($inspeccion['fecha_hora'])) ?>"></div>
      <div class="col-md-4 mb-2"><label>Descripción</label><input type="text" name="descripcion" class="form-control" value="<?= htmlspecialchars($inspeccion['descripcion']) ?>"></div>
      <div class="col-md-4 mb-2"><label>Estado Inspección</label><input type="text" name="estado_inspeccion" class="form-control" value="<?= htmlspecialchars($inspeccion['estado_inspeccion']) ?>"></div>
      <div class="col-md-4 mb-2"><label>Elementos de Trabajo</label><input type="text" name="element_trab" class="form-control" value="<?= htmlspecialchars($inspeccion['element_trab']) ?>"></div>
      <div class="col-md-4 mb-2"><label>Observaciones</label><input type="text" name="observaciones" class="form-control" value="<?= htmlspecialchars($inspeccion['observaciones']) ?>"></div>
      <div class="col-md-4 mb-2">
        <label>Categoría</label>
        <select name="categoria_id_categoria" class="form-control">
          <option value="">-- Selecciona categoría --</option>
          <?php if (isset($categorias)): foreach ($categorias as $cat): ?>
            <option value="<?= $cat['id_categoria'] ?>" <?= ($inspeccion['categoria_id_categoria'] == $cat['id_categoria']) ? 'selected' : '' ?>><?= htmlspecialchars($cat['nombre']) ?></option>
          <?php endforeach; endif; ?>
        </select>
      </div>
      <div class="col-md-4 mb-2">
        <label>Incidente</label>
        <select name="incidente_id_incidente" class="form-control">
          <option value="">-- Selecciona incidente --</option>
          <?php if (isset($incidentes)): foreach ($incidentes as $inc): ?>
            <option value="<?= $inc['id_incidente'] ?>" <?= ($inspeccion['incidente_id_incidente'] == $inc['id_incidente']) ? 'selected' : '' ?>><?= htmlspecialchars($inc['tipo']) ?></option>
          <?php endforeach; endif; ?>
        </select>
      </div>
      <div class="col-md-4 mb-2">
        <label>Accidente</label>
        <select name="accidente_id_accidente" class="form-control">
          <option value="">-- Selecciona accidente --</option>
          <?php if (isset($accidentes)): foreach ($accidentes as $acc): ?>
            <option value="<?= $acc['id_accidente'] ?>" <?= ($inspeccion['accidente_id_accidente'] == $acc['id_accidente']) ? 'selected' : '' ?>><?= htmlspecialchars($acc['tipo']) ?></option>
          <?php endforeach; endif; ?>
        </select>
      </div>
      <div class="col-md-4 mb-2">
        <label>Riesgo</label>
        <select name="riesgo_id_riesgo" class="form-control">
          <option value="">-- Selecciona riesgo --</option>
          <?php if (isset($riesgos)): foreach ($riesgos as $ries): ?>
            <option value="<?= $ries['id_riesgo'] ?>" <?= ($inspeccion['riesgo_id_riesgo'] == $ries['id_riesgo']) ? 'selected' : '' ?>><?= htmlspecialchars($ries['tipo']) ?></option>
          <?php endforeach; endif; ?>
        </select>
      </div>
      <div class="col-12 mt-3">
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="?controller=inspeccionlocativa&action=index" class="btn btn-secondary">Cancelar</a>
      </div>
    </div>
  </form>
</div>
<?php include __DIR__ . '/../footer.php'; ?>
