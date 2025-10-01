<?php
if (isset($data) && is_array($data)) extract($data);
include __DIR__ . '/../header.php'; ?>
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
  body {
    background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
    min-height: 100vh;
  }
  .users-bg {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .users-card {
    border-radius: 1.2rem;
    box-shadow: 0 2px 12px rgba(30,40,90,0.10);
    background: #fff;
    border: none;
    max-width: 400px;
    margin: auto;
    display: flex;
    flex-direction: column;
    align-items: center;
  }
  .users-title {
    color: #1a237e;
    font-weight: 700;
    letter-spacing: 1px;
    text-align: center;
    width: 100%;
    border-bottom: 3px solid #ffd600;
    margin-bottom: 2rem;
    padding-bottom: 0.5rem;
  }
  .btn-users {
    background: #3949ab;
    color: #fff;
    border-radius: 2rem;
    font-weight: 600;
    border: 2px solid #ffd600;
    box-shadow: 0 2px 8px rgba(255,214,0,0.10);
    transition: background 0.2s, border 0.2s;
  }
  .btn-users:hover {
    background: #ffd600;
    color: #3949ab;
    border: 2px solid #3949ab;
  }
  .btn-users-outline {
    border: 2px solid #3949ab;
    color: #3949ab;
    background: #fff;
    border-radius: 2rem;
    font-weight: 600;
    transition: background 0.2s, color 0.2s, border 0.2s;
  }
  .btn-users-outline:hover {
    background: #3949ab;
    color: #fff;
    border: 2px solid #ffd600;
  }
</style>
<div class="users-bg">
  <div class="container">
    <div class="d-flex flex-column align-items-center justify-content-center min-vh-100">
      <div class="card users-card p-4 w-100" style="max-width:1200px;">
        <div class="d-flex flex-column flex-lg-row align-items-center justify-content-center w-100 gap-5">
          <div class="w-100" style="max-width:350px;">
            <div class="w-100 text-center mb-3">
              <h2 class="users-title mb-0"><i class="bi bi-people me-2"></i>Gestión de Usuarios</h2>
            </div>
            <form class="d-flex flex-wrap justify-content-center align-items-center gap-2 mb-2" method="get" action="">
              <input type="hidden" name="controller" value="users">
              <input type="hidden" name="action" value="index">
              <input type="text" class="form-control" name="filtro_doc" placeholder="Nº Documento" value="<?= isset($_GET['filtro_doc']) ? htmlspecialchars($_GET['filtro_doc']) : '' ?>" style="max-width: 130px;">
              <input type="text" class="form-control" name="filtro_usuario" placeholder="Usuario" value="<?= isset($_GET['filtro_usuario']) ? htmlspecialchars($_GET['filtro_usuario']) : '' ?>" style="max-width: 150px;">
              <select class="form-select" name="orden" style="max-width: 120px;">
                <option value="">Ordenar por</option>
                <option value="asc" <?= (isset($_GET['orden']) && $_GET['orden'] == 'asc') ? 'selected' : '' ?>>A-Z</option>
                <option value="desc" <?= (isset($_GET['orden']) && $_GET['orden'] == 'desc') ? 'selected' : '' ?>>Z-A</option>
              </select>
              <button type="submit" class="btn btn-users-outline"><i class="bi bi-funnel"></i> Filtrar</button>
              <a href="?controller=users&action=index" class="btn btn-secondary ms-2"><i class="bi bi-x-circle"></i> Limpiar</a>
            </form>
            <div class="text-end">
              <a href="?controller=users&action=create" class="btn btn-users"><i class="bi bi-plus-circle me-1"></i>Nuevo Usuario</a>
            </div>
          </div>
          <div class="w-100" style="max-width:700px;">
            <div class="table-responsive mt-4">
              <table class="table users-table align-middle mb-0 mx-auto" style="width:100%;">
                <thead>
                  <tr>
                    <th style="width: 80px;">Nº Doc</th>
                    <th>Tipo Doc</th>
                    <th>Usuario</th>
                    <th>Teléfono</th>
                    <th>Rol</th>
                    <th style="width: 180px;">Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($usuarios as $usuario): ?>
                  <tr>
                    <td><span style="font-weight:700;color:#3949ab;"> <?= isset($usuario['num_doc']) ? htmlspecialchars($usuario['num_doc']) : '-' ?> </span></td>
                    <td><?= isset($usuario['tipo_doc']) ? htmlspecialchars($usuario['tipo_doc']) : '-' ?></td>
                    <td><span style="font-weight:600;color:#1a237e;background:#e3eafc;padding:0.2em 0.7em;border-radius:0.5em;box-shadow:0 2px 8px #3949ab22;"> <?= isset($usuario['usuario']) ? htmlspecialchars($usuario['usuario']) : '-' ?> </span></td>
                    <td><?= isset($usuario['telefono']) ? htmlspecialchars($usuario['telefono']) : '-' ?></td>
                    <td><?= isset($usuario['rol_nombre']) ? htmlspecialchars($usuario['rol_nombre']) : '-' ?></td>
                    <td class="users-actions">
                      <a href="?controller=users&action=edit&id=<?= $usuario['num_doc'] ?>" class="btn btn-users-outline btn-sm"><i class="bi bi-pencil"></i> Editar</a>
                      <a href="?controller=users&action=delete&id=<?= $usuario['num_doc'] ?>" class="btn btn-danger btn-sm" style="border-radius:2rem;font-weight:600;" onclick="return confirm('¿Seguro que deseas eliminar este usuario?')"><i class="bi bi-trash"></i> Eliminar</a>
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
                    </td>
                  </tr>
                <!-- endforeach duplicado eliminado -->
    </div>
  </div>
</div>
<?php include __DIR__ . '/../footer.php'; ?>
