<?php if (isset($data) && is_array($data)) extract($data); include __DIR__ . '/../header.php'; ?>
<div class="container mt-4">
  <h2>Nueva Inspección Locativa</h2>
  <form method="post" action="?controller=inspeccionlocativa&action=store">
    <div class="row">
      <div class="col-md-4 mb-2"><label>Tipo Inspección</label><input type="text" name="tipo_inspeccion" class="form-control"></div>
      <div class="col-md-4 mb-2"><label>Fecha y Hora</label><input type="datetime-local" name="fecha_hora" class="form-control"></div>
      <div class="col-md-4 mb-2"><label>Descripción</label><input type="text" name="descripcion" class="form-control"></div>
      <div class="col-md-4 mb-2"><label>Estado Inspección</label><input type="text" name="estado_inspeccion" class="form-control"></div>
      <div class="col-md-4 mb-2"><label>Elementos de Trabajo</label><input type="text" name="element_trab" class="form-control"></div>
      <div class="col-md-4 mb-2"><label>Observaciones</label><input type="text" name="observaciones" class="form-control"></div>
      <div class="col-md-4 mb-2">
        <label>Categoría</label>
        <select name="categoria_id_categoria" class="form-control">
          <option value="">-- Selecciona categoría --</option>
          <?php if (isset($categorias)): foreach ($categorias as $cat): ?>
            <option value="<?= $cat['id_categoria'] ?>"><?= htmlspecialchars($cat['nombre']) ?></option>
          <?php endforeach; endif; ?>
        </select>
      </div>
      <div class="col-md-4 mb-2">
        <label>Incidente</label>
        <select name="incidente_id_incidente" class="form-control">
          <option value="">-- Selecciona incidente --</option>
          <?php if (isset($incidentes)): foreach ($incidentes as $inc): ?>
            <option value="<?= $inc['id_incidente'] ?>"><?= htmlspecialchars($inc['tipo']) ?></option>
          <?php endforeach; endif; ?>
        </select>
      </div>
      <div class="col-md-4 mb-2">
        <label>Accidente</label>
        <select name="accidente_id_accidente" class="form-control">
          <option value="">-- Selecciona accidente --</option>
          <?php if (isset($accidentes)): foreach ($accidentes as $acc): ?>
            <option value="<?= $acc['id_accidente'] ?>"><?= htmlspecialchars($acc['tipo']) ?></option>
          <?php endforeach; endif; ?>
        </select>
      </div>
      <div class="col-md-4 mb-2">
        <label>Riesgo</label>
        <select name="riesgo_id_riesgo" class="form-control">
          <option value="">-- Selecciona riesgo --</option>
          <?php if (isset($riesgos)): foreach ($riesgos as $ries): ?>
            <option value="<?= $ries['id_riesgo'] ?>"><?= htmlspecialchars($ries['tipo']) ?></option>
          <?php endforeach; endif; ?>
        </select>
      </div>
      <div class="col-12 mt-3">
        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="?controller=inspeccionlocativa&action=index" class="btn btn-secondary">Cancelar</a>
      </div>
    </div>
  </form>
</div>
<?php include __DIR__ . '/../footer.php'; ?>
