<?php if (isset($data) && is_array($data)) extract($data); include __DIR__ . '/../header.php'; ?>
<div class="container mt-4">
  <h2>Editar Accidente</h2>
  <a href="/dashboard.php" class="btn btn-secondary mb-3">Regresar al dashboard</a>
  <form method="post" action="?controller=accidentes&action=update&id=<?= $accidente['id_accidente'] ?>">
    <div class="row">
      <div class="col-md-4 mb-2">
        <label>Tipo</label>
        <input type="text" name="tipo" class="form-control" value="<?= htmlspecialchars($accidente['tipo']) ?>" required>
      </div>
      <div class="col-md-4 mb-2">
        <label>Clasificación</label>
        <input type="text" name="clasificacion" class="form-control" value="<?= htmlspecialchars($accidente['clasificacion']) ?>">
      </div>
      <div class="col-md-4 mb-2">
        <label>Estado</label>
        <input type="text" name="estado" class="form-control" value="<?= htmlspecialchars($accidente['estado']) ?>">
      </div>
      <div class="col-md-4 mb-2">
        <label>Fecha y Hora</label>
        <input type="datetime-local" name="fecha_hora" class="form-control" value="<?= date('Y-m-d\TH:i', strtotime($accidente['fecha_hora'])) ?>">
      </div>
      <div class="col-md-4 mb-2">
        <label>Lugar</label>
        <input type="text" name="lugar" class="form-control" value="<?= htmlspecialchars($accidente['lugar']) ?>">
      </div>
      <div class="col-md-4 mb-2">
        <label>Tipo Vinculación Laboral</label>
        <input type="text" name="tipo_vinc_lab_" class="form-control" value="<?= htmlspecialchars($accidente['tipo_vinc_lab_']) ?>">
      </div>
      <div class="col-md-4 mb-2">
        <label>Jornada Laboral</label>
        <input type="text" name="jornada_laboral" class="form-control" value="<?= htmlspecialchars($accidente['jornada_laboral']) ?>">
      </div>
      <div class="col-md-4 mb-2">
        <label>Turno Momento Accidente</label>
        <input type="text" name="turno_mom_acc" class="form-control" value="<?= htmlspecialchars($accidente['turno_mom_acc']) ?>">
      </div>
      <div class="col-md-4 mb-2">
        <label>Uso EPP</label>
        <input type="text" name="uso_epp" class="form-control" value="<?= htmlspecialchars($accidente['uso_epp']) ?>">
      </div>
      <div class="col-md-4 mb-2">
        <label>Consecuencias</label>
        <input type="text" name="consecuencias" class="form-control" value="<?= htmlspecialchars($accidente['consecuencias']) ?>">
      </div>
      <div class="col-md-4 mb-2">
        <label>Gravedad</label>
        <input type="text" name="gravedad" class="form-control" value="<?= htmlspecialchars($accidente['gravedad']) ?>">
      </div>
      <div class="col-md-4 mb-2">
        <label>Tipo Lesión</label>
        <input type="text" name="tipo_lesion" class="form-control" value="<?= htmlspecialchars($accidente['tipo_lesion']) ?>">
      </div>
      <div class="col-md-4 mb-2">
        <label>Parte Cuerpo Afectada</label>
        <input type="text" name="parte_cuerpo_afect" class="form-control" value="<?= htmlspecialchars($accidente['parte_cuerpo_afect']) ?>">
      </div>
      <div class="col-md-4 mb-2">
        <label>Incapacidad Laboral</label>
        <input type="text" name="incapacidad_lab" class="form-control" value="<?= htmlspecialchars($accidente['incapacidad_lab']) ?>">
      </div>
      <div class="col-md-4 mb-2">
        <label>Atención Médica Recibida</label>
        <input type="text" name="aten_med_recibida" class="form-control" value="<?= htmlspecialchars($accidente['aten_med_recibida']) ?>">
      </div>
      <div class="col-md-4 mb-2">
        <label>Persona que Informó</label>
        <input type="text" name="persona_informo" class="form-control" value="<?= htmlspecialchars($accidente['persona_informo']) ?>">
      </div>
      <div class="col-12 mt-3">
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="?controller=accidentes&action=index" class="btn btn-secondary">Cancelar</a>
      </div>
    </div>
  </form>
</div>
<?php include __DIR__ . '/../footer.php'; ?>
