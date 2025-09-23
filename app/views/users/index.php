<?php
if (isset($data) && is_array($data)) extract($data);
include __DIR__ . '/../header.php'; ?>
<a href="app/views/dashboard.php" class="btn btn-secondary mb-3">Volver a inicio</a>
<style>
  .users-bg {
    background: linear-gradient(135deg, #f5f7fa 0%, #e3eafc 100%);
    min-height: 100vh;
    padding-top: 40px;
    padding-bottom: 40px;
  }
  .users-card {
    border-radius: 1.2rem;
    box-shadow: 0 2px 12px rgba(30,40,90,0.10);
    background: #fff;
    border: none;
  }
  .users-title {
    color: #1a237e;
    font-weight: 700;
    letter-spacing: 1px;
  }
  .btn-users {
    background: #1a237e;
    color: #fff;
    border-radius: 2rem;
    font-weight: 500;
    transition: background 0.2s;
  }
  .btn-users:hover {
    background: #3949ab;
    color: #fff;
  }
  .btn-users-outline {
    border: 2px solid #1a237e;
    color: #1a237e;
    background: #fff;
    border-radius: 2rem;
    font-weight: 500;
    transition: background 0.2s, color 0.2s;
  }
  .btn-users-outline:hover {
    background: #1a237e;
    color: #fff;
  }
</style>
<div class="users-bg">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="card users-card p-4">
          <div class="mb-3">
            <div class="w-100 text-center mb-3">
              <h2 class="users-title mb-0"><i class="bi bi-people me-2"></i>Gestión de Usuarios</h2>
            </div>
            <form class="d-flex flex-wrap justify-content-center align-items-center gap-2 mb-2" method="get" action="">
              <input type="hidden" name="controller" value="users">
              <input type="hidden" name="action" value="index">
              <input type="text" class="form-control" name="filtro_doc" placeholder="N° Documento" value="<?= isset($_GET['filtro_doc']) ? htmlspecialchars($_GET['filtro_doc']) : '' ?>" style="max-width: 130px;">
              <input type="text" class="form-control" name="filtro_nombre" placeholder="Nombre" value="<?= isset($_GET['filtro_nombre']) ? htmlspecialchars($_GET['filtro_nombre']) : '' ?>" style="max-width: 150px;">
              <select class="form-select" name="filtro_rol" style="max-width: 140px;">
                <option value="">Rol</option>
                <?php
                $rolesFiltro = isset($roles) ? $roles : (class_exists('Rol') ? Rol::all() : []);
                foreach ($rolesFiltro as $rol): ?>
                  <option value="<?= $rol['id_Rol'] ?>" <?= (isset($_GET['filtro_rol']) && $_GET['filtro_rol'] == $rol['id_Rol']) ? 'selected' : '' ?>><?= htmlspecialchars($rol['nombre']) ?></option>
                <?php endforeach; ?>
              </select>
              <select class="form-select" name="orden" style="max-width: 160px;">
                <option value="">Ordenar por</option>
                <option value="num_doc" <?= (isset($_GET['orden']) && $_GET['orden'] == 'num_doc') ? 'selected' : '' ?>>N° Documento</option>
                <option value="nombres" <?= (isset($_GET['orden']) && $_GET['orden'] == 'nombres') ? 'selected' : '' ?>>Nombre</option>
                <option value="rol" <?= (isset($_GET['orden']) && $_GET['orden'] == 'rol') ? 'selected' : '' ?>>Rol</option>
              </select>
              <button type="submit" class="btn btn-users-outline"><i class="bi bi-funnel"></i> Filtrar</button>
              <a href="?controller=users&action=index" class="btn btn-secondary ms-2"><i class="bi bi-x-circle"></i> Limpiar</a>
            </form>
            <div class="text-end">
              <a href="?controller=users&action=create" class="btn btn-users"><i class="bi bi-plus-circle me-1"></i>Nuevo Usuario</a>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table align-middle table-hover">
              <thead class="table-light">
                <tr>
                  <th>N° Documento</th>
                  <th>Tipo Doc</th>
                  <th>Nombres</th>
                  <th>Apellidos</th>
                  <th>Rol</th>
                  <th>Teléfono</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                  <tr>
                    <td><?= htmlspecialchars($usuario['num_doc']) ?></td>
                    <td><?= htmlspecialchars($usuario['tipo_doc']) ?></td>
                    <td><?= htmlspecialchars($usuario['nombres']) ?></td>
                    <td><?= htmlspecialchars($usuario['apellidos']) ?></td>
                    <td><?= htmlspecialchars($usuario['rol_nombre']) ?></td>
                    <td><?= htmlspecialchars($usuario['telefono']) ?></td>
                    <td>
                      <a href="?controller=users&action=edit&id=<?= $usuario['num_doc'] ?>" class="btn btn-users btn-sm me-2" title="Editar"><i class="bi bi-pencil me-1"></i>Editar</a>
                      <a href="?controller=users&action=delete&id=<?= $usuario['num_doc'] ?>" class="btn btn-users-outline btn-sm" title="Eliminar" onclick="return confirm('¿Seguro que deseas eliminar este usuario?');"><i class="bi bi-trash me-1"></i>Eliminar</a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . '/../footer.php'; ?>
