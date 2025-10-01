<?php if (isset($data) && is_array($data)) extract($data); include __DIR__ . '/../header.php'; ?>
<div class="container mt-4">
  <h2 class="text-center">Nueva Inspección Locativa</h2>
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
  <a href="app/views/dashboard.php" class="btn btn-inicio-claro position-absolute" style="top:24px;left:24px;z-index:10;"><i class="bi bi-arrow-left"></i> Ir a Inicio</a>
</div>
<style>
  .btn-inicio-claro {
    background: #e3f2fd;
    color: #3949ab;
    border-radius: 2rem;
    font-weight: 600;
    border: 2px solid #bbdefb;
    box-shadow: 0 2px 8px #bbdefb88;
    transition: background 0.2s, color 0.2s, border 0.2s;
  }
  .btn-inicio-claro:hover {
    background: #ffd600;
    color: #3949ab;
    border: 2px solid #3949ab;
    box-shadow: 0 2px 12px #ffd60055;
  }
</style>
<?php include __DIR__ . '/../footer.php'; ?>
