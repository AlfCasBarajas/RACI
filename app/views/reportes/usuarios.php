<?php
if (isset($data) && is_array($data)) extract($data);
include __DIR__ . '/../header.php';
?>

<div class="container-fluid">
    <div class="row">
        <?php include __DIR__ . '/../sidebar.php'; ?>
        <main class="col-md-10 ms-sm-auto offset-md-2 px-4 main-content">
            <div class="container mt-4">
                <?php if (isset($_GET['pdf_saved'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle-fill"></i>
                        <strong>¡PDF guardado exitosamente!</strong> El archivo <code><?= htmlspecialchars($_GET['pdf_saved']) ?></code> se ha guardado.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                
                <?php if (isset($_GET['excel_saved'])): ?>
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <i class="bi bi-file-earmark-excel-fill"></i>
                        <strong>¡Excel guardado exitosamente!</strong> El archivo <code><?= htmlspecialchars($_GET['excel_saved']) ?></code> se ha guardado.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h2 class="card-title text-dark">
                            <i class="bi bi-people me-2"></i>Reporte de Usuarios
                        </h2>
                        
                        <!-- Formulario de filtros -->
                        <form method="GET" action="" class="row g-3 align-items-center mb-3">
                            <input type="hidden" name="controller" value="reportes">
                            <input type="hidden" name="action" value="usuarios">
                            
                            <div class="col-auto">
                                <label for="usuario" class="form-label">Filtrar por usuario</label>
                            </div>
                            <div class="col-auto">
                                <input type="text" id="usuario" name="usuario" class="form-control" 
                                       placeholder="Nombre de usuario" value="<?= htmlspecialchars($usuario ?? '') ?>">
                            </div>
                            <div class="col-auto">
                                <label for="rol" class="form-label">Rol</label>
                            </div>
                            <div class="col-auto">
                                <select id="rol" name="rol" class="form-select">
                                    <option value="">Todos los roles</option>
                                    <option value="1" <?= (isset($rol) && $rol == '1') ? 'selected' : '' ?>>Administrador</option>
                                    <option value="2" <?= (isset($rol) && $rol == '2') ? 'selected' : '' ?>>Supervisor</option>
                                    <option value="3" <?= (isset($rol) && $rol == '3') ? 'selected' : '' ?>>Coordinador</option>
                                    <option value="4" <?= (isset($rol) && $rol == '4') ? 'selected' : '' ?>>Trabajador</option>
                                </select>
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary">Filtrar</button>
                            </div>
                            <div class="col-auto">
                                <a href="?controller=reportes&action=usuarios" class="btn btn-secondary">Limpiar filtros</a>
                            </div>
                        </form>
                        
                        <!-- Botones de descarga -->
                        <?php if (!$isTrabajador): ?>
                        <div class="mb-3">
                            <button class="btn btn-outline-danger me-2" id="descargar-pdf">
                                <i class="bi bi-file-earmark-pdf me-1"></i>Descargar PDF
                            </button>
                            <button class="btn btn-outline-success" id="descargar-excel">
                                <i class="bi bi-file-earmark-excel me-1"></i>Descargar Excel
                            </button>
                        </div>
                        <?php endif; ?>
                        
                        <!-- Tabla de usuarios -->
                        <div id="tabla-usuarios" class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Num. Documento</th>
                                        <th>Tipo Documento</th>
                                        <th>Usuario</th>
                                        <th>Teléfono</th>
                                        <th>Rol</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($usuarios)): ?>
                                        <?php foreach ($usuarios as $user): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($user['num_doc']) ?></td>
                                                <td><?= htmlspecialchars($user['tipo_doc']) ?></td>
                                                <td><?= htmlspecialchars($user['usuario']) ?></td>
                                                <td><?= htmlspecialchars($user['telefono'] ?? 'Sin teléfono') ?></td>
                                                <td>
                                                    <?php 
                                                    $rolClass = '';
                                                    switch($user['rol_nombre']) {
                                                        case 'Administrador':
                                                            $rolClass = 'badge bg-danger';
                                                            break;
                                                        case 'Supervisor':
                                                            $rolClass = 'badge bg-warning';
                                                            break;
                                                        case 'Coordinador':
                                                            $rolClass = 'badge bg-info';
                                                            break;
                                                        case 'Trabajador':
                                                            $rolClass = 'badge bg-secondary';
                                                            break;
                                                        default:
                                                            $rolClass = 'badge bg-light text-dark';
                                                    }
                                                    ?>
                                                    <span class="<?= $rolClass ?>"><?= htmlspecialchars($user['rol_nombre'] ?? 'Sin rol') ?></span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-success">Activo</span>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center">No hay usuarios para mostrar</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="text-end mt-3">
                            <a href="?controller=reportes&action=index" class="btn btn-dark">
                                <i class="bi bi-arrow-left me-1"></i>Volver a Reportes
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
document.getElementById('descargar-pdf').onclick = function(e) {
    e.preventDefault();
    const usuario = document.getElementById('usuario').value;
    const rol = document.getElementById('rol').value;
    let url = '?controller=reportes&action=usuarios&format=pdf';
    if (usuario) url += '&usuario=' + encodeURIComponent(usuario);
    if (rol) url += '&rol=' + encodeURIComponent(rol);
    window.location.href = url;
};

document.getElementById('descargar-excel').onclick = function(e) {
    e.preventDefault();
    const usuario = document.getElementById('usuario').value;
    const rol = document.getElementById('rol').value;
    let url = '?controller=reportes&action=usuarios&format=excel';
    if (usuario) url += '&usuario=' + encodeURIComponent(usuario);
    if (rol) url += '&rol=' + encodeURIComponent(rol);
    window.location.href = url;
};
</script>

<?php include __DIR__ . '/../footer.php'; ?>