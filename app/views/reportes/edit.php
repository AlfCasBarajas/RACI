<?php if (isset($data) && is_array($data)) extract($data); include __DIR__ . '/../header.php'; ?>
<div class="container mt-4">
  <h2>Editar Reporte</h2>
  <form method="post" action="?controller=reportes&action=update&id=<?= $reporte['id_reporte'] ?>">
    <div class="row">
      <div class="col-md-6 mb-2"><label>Nombre</label><input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($reporte['nombre']) ?>" required></div>
      <div class="col-12 mt-3">
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="?controller=reportes&action=index" class="btn btn-secondary">Cancelar</a>
      </div>
    </div>
  </form>
</div>
<?php include __DIR__ . '/../footer.php'; ?>
