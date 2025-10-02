<?php if (isset($data) && is_array($data)) extract($data); include __DIR__ . '/../header.php'; ?>
<div class="container mt-4">
  <div class="d-flex flex-column align-items-center justify-content-center min-vh-100">
    <div class="card shadow p-4 w-100" style="max-width:700px;">
      <h2 class="text-center mb-4">Editar Reporte</h2>
      <form method="post" action="?controller=reportes&action=update&id=<?= $reporte['id_reporte'] ?>">
        <div class="row">
          <div class="col-md-6 mb-2"><label>Nombre</label><input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($reporte['nombre']) ?>" required></div>
          <div class="col-md-6 mb-2"><label>Descripción</label><textarea name="descripcion" class="form-control" rows="3"><?= isset($reporte['descripcion']) ? htmlspecialchars($reporte['descripcion']) : '' ?></textarea></div>
          <div class="col-md-6 mb-2">
            <label>Inspección Locativa</label>
            <select name="inspeccion_locativa_id_insp_loc" class="form-control">
              <option value="">-- Selecciona inspección --</option>
              <?php if (isset($inspeccioneslocativas)): foreach ($inspeccioneslocativas as $insp): ?>
                <option value="<?= $insp['id_insp_loc'] ?>" <?= (isset($reporte['inspeccion_locativa_id_insp_loc']) && $reporte['inspeccion_locativa_id_insp_loc'] == $insp['id_insp_loc']) ? 'selected' : '' ?>><?= htmlspecialchars($insp['tipo_inspeccion']) ?> - <?= date('d/m/Y H:i', strtotime($insp['fecha_hora'])) ?></option>
              <?php endforeach; endif; ?>
            </select>
          </div>
          <div class="col-12 mt-3 d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="?controller=reportes&action=index" class="btn btn-inicio-claro ms-2">Cancelar</a>
          </div>
        </div>
      </form>
    </div>
  </div>
  <a href="app/views/dashboard.php" class="btn btn-inicio-claro position-absolute" style="top:24px;left:24px;z-index:10;"><i class="bi bi-arrow-left"></i> Ir a Inicio</a>
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
</div>
<?php include __DIR__ . '/../footer.php'; ?>
