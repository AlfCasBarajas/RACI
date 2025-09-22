<?php if (isset($data) && is_array($data)) extract($data); include __DIR__ . '/../header.php'; ?>
<div class="container mt-4">
  <h2>Nueva Inspección Locativa</h2>
  <form method="post" action="?controller=inspeccionlocativa&action=store">
    <div class="row">
      <div class="col-md-4 mb-2"><label>Tipo Inspección</label><input type="text" name="tipo_inspeccion" class="form-control"></div>
      <div class="col-md-4 mb-2"><label>Fecha y Hora</label><input type="datetime-local" name="fecha_hora" class="form-control"></div>
      <div class="col-md-4 mb-2"><label>Actividad Económica</label><input type="text" name="act_economica" class="form-control"></div>
      <div class="col-md-4 mb-2"><label>Descripción</label><input type="text" name="descripcion" class="form-control"></div>
      <div class="col-md-4 mb-2"><label>Estado Inspección</label><input type="text" name="estado_inspeccion" class="form-control"></div>
      <div class="col-md-4 mb-2"><label>Elementos de Trabajo</label><input type="text" name="element_trab" class="form-control"></div>
      <div class="col-md-4 mb-2"><label>Observaciones</label><input type="text" name="observaciones" class="form-control"></div>
      <div class="col-md-4 mb-2"><label>ID Categoría</label><input type="number" name="categoria_id_categoria" class="form-control"></div>
      <div class="col-md-4 mb-2"><label>ID Incidente</label><input type="number" name="incidente_id_incidente" class="form-control"></div>
      <div class="col-md-4 mb-2"><label>ID Accidente</label><input type="number" name="accidente_id_accidente" class="form-control"></div>
      <div class="col-md-4 mb-2"><label>ID Riesgo</label><input type="number" name="riesgo_id_riesgo" class="form-control"></div>
      <div class="col-md-4 mb-2"><label>ID Reporte</label><input type="number" name="reporte_id_reporte" class="form-control"></div>
      <div class="col-12 mt-3">
        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="?controller=inspeccionlocativa&action=index" class="btn btn-secondary">Cancelar</a>
      </div>
    </div>
  </form>
</div>
<?php include __DIR__ . '/../footer.php'; ?>
