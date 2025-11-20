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
                        <h2 class="card-title" style="color: #6f42c1;">
                            <i class="bi bi-person-badge me-2"></i>Reporte de Roles
                        </h2>
                        
                        <!-- Formulario de filtros -->
                        <form method="GET" action="" class="row g-3 align-items-center mb-3">
                            <input type="hidden" name="controller" value="reportes">
                            <input type="hidden" name="action" value="roles">
                            
                            <div class="col-auto">
                                <label for="nombre" class="form-label">Filtrar por nombre</label>
                            </div>
                            <div class="col-auto">
                                <input type="text" id="nombre" name="nombre" class="form-control" 
                                       placeholder="Nombre del rol" value="<?= htmlspecialchars($nombre ?? '') ?>">
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary">Filtrar</button>
                            </div>
                            <div class="col-auto">
                                <a href="?controller=reportes&action=roles" class="btn btn-secondary">Limpiar filtros</a>
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
                        
                        <!-- Tabla de roles -->
                        <div id="tabla-roles" class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre del Rol</th>
                                        <th>Descripción</th>
                                        <th>Permisos</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($roles)): ?>
                                        <?php foreach ($roles as $rol): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($rol['id_Rol']) ?></td>
                                                <td><?= htmlspecialchars($rol['nombre']) ?></td>
                                                <td>
                                                    <?php 
                                                    switch($rol['nombre']) {
                                                        case 'Administrador':
                                                            echo 'Control total del sistema, gestión de usuarios y configuraciones';
                                                            break;
                                                        case 'Supervisor':
                                                            echo 'Supervisión de operaciones y revisión de reportes';
                                                            break;
                                                        case 'Coordinador':
                                                            echo 'Coordinación de actividades y seguimiento de procesos';
                                                            break;
                                                        case 'Trabajador':
                                                            echo 'Acceso limitado para consulta y registro básico';
                                                            break;
                                                        default:
                                                            echo 'Rol personalizado del sistema';
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php 
                                                    switch($rol['nombre']) {
                                                        case 'Administrador':
                                                            echo '<span class="badge bg-success">Completos</span>';
                                                            break;
                                                        case 'Supervisor':
                                                            echo '<span class="badge bg-warning">Limitados</span>';
                                                            break;
                                                        case 'Coordinador':
                                                            echo '<span class="badge bg-info">Solo lectura</span>';
                                                            break;
                                                        case 'Trabajador':
                                                            echo '<span class="badge bg-secondary">Básicos</span>';
                                                            break;
                                                        default:
                                                            echo '<span class="badge bg-light text-dark">Personalizados</span>';
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="4" class="text-center">No hay roles para mostrar</td>
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
    const nombre = document.getElementById('nombre').value;
    let url = '?controller=reportes&action=roles&format=pdf';
    if (nombre) url += '&nombre=' + encodeURIComponent(nombre);
    window.location.href = url;
};

document.getElementById('descargar-excel').onclick = function(e) {
    e.preventDefault();
    const nombre = document.getElementById('nombre').value;
    let url = '?controller=reportes&action=roles&format=excel';
    if (nombre) url += '&nombre=' + encodeURIComponent(nombre);
    window.location.href = url;
};
</script>

<?php include __DIR__ . '/../footer.php'; ?>