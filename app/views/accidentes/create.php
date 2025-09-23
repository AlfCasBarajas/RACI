<?php if (isset($data) && is_array($data)) extract($data); include __DIR__ . '/../header.php'; ?>
<div class="container mt-4">
  <h2>Registrar Accidente</h2>
  <form method="post" action="?controller=accidentes&action=store">
    <div class="row">
      <div class="col-md-4 mb-2">
        <label>Tipo</label>
        <input type="text" name="tipo" class="form-control" required>
      </div>
      <div class="col-md-4 mb-2">
        <label>Clasificación</label>
        <input type="text" name="clasificacion" class="form-control">
      </div>
      <div class="col-md-4 mb-2">
        <label>Estado</label>
        <input type="text" name="estado" class="form-control">
      </div>
      <div class="col-md-4 mb-2">
        <label>Fecha y Hora</label>
        <input type="datetime-local" name="fecha_hora" class="form-control">
      </div>
      <div class="col-md-4 mb-2">
        <label>Lugar</label>
        <input type="text" name="lugar" class="form-control">
      </div>
      <div class="col-md-4 mb-2">
        <label>Tipo Vinculación Laboral</label>
        <input type="text" name="tipo_vinc_lab_" class="form-control">
      </div>
      <div class="col-md-4 mb-2">
        <label>Jornada Laboral</label>
        <input type="text" name="jornada_laboral" class="form-control">
      </div>
      <div class="col-md-4 mb-2">
        <label>Turno Momento Accidente</label>
        <input type="text" name="turno_mom_acc" class="form-control">
      </div>
      <div class="col-md-4 mb-2">
        <label>Uso EPP</label>
        <input type="text" name="uso_epp" class="form-control">
      </div>
      <div class="col-md-4 mb-2">
        <label>Consecuencias</label>
        <input type="text" name="consecuencias" class="form-control">
      </div>
      <div class="col-md-4 mb-2">
        <label>Gravedad</label>
        <input type="text" name="gravedad" class="form-control">
      </div>
      <div class="col-md-4 mb-2">
        <label>Tipo Lesión</label>
        <input type="text" name="tipo_lesion" class="form-control">
      </div>
      <div class="col-md-4 mb-2">
        <label>Parte Cuerpo Afectada</label>
        <input type="text" name="parte_cuerpo_afect" class="form-control">
      </div>
      <div class="col-md-4 mb-2">
        <label>Incapacidad Laboral</label>
        <input type="text" name="incapacidad_lab" class="form-control">
      </div>
      <div class="col-md-4 mb-2">
        <label>Atención Médica Recibida</label>
        <input type="text" name="aten_med_recibida" class="form-control">
      </div>
      <div class="col-md-4 mb-2">
        <label>Persona que Informó</label>
        <input type="text" name="persona_informo" class="form-control">
      </div>
      <div class="col-12 mt-3">
        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="?controller=accidentes&action=index" class="btn btn-secondary">Cancelar</a>
      </div>
    </div>
  </form>
</div>
<?php include __DIR__ . '/../footer.php'; ?>
