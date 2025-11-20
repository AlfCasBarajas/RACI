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
                        <h2 class="card-title text-primary">
                            <i class="bi bi-person-lines-fill me-2"></i>Reporte de Empleados
                        </h2>
                        
                        <!-- Formulario de filtros -->
                        <form method="GET" action="" class="row g-3 align-items-center mb-3">
                            <input type="hidden" name="controller" value="reportes">
                            <input type="hidden" name="action" value="empleados">
                            
                            <div class="col-auto">
                                <label for="nombre" class="form-label">Filtrar por nombre</label>
                            </div>
                            <div class="col-auto">
                                <input type="text" id="nombre" name="nombre" class="form-control" 
                                       placeholder="Nombre del empleado" value="<?= htmlspecialchars($nombre ?? '') ?>">
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
                                <a href="?controller=reportes&action=empleados" class="btn btn-secondary">Limpiar filtros</a>
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
                        
                        <!-- Tabla de empleados -->
                        <div id="tabla-empleados" class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Tipo Doc.</th>
                                        <th>Nombres</th>
                                        <th>Apellidos</th>
                                        <th>Teléfono</th>
                                        <th>EPS</th>
                                        <th>ARL</th>
                                        <th>Cargo/Función</th>
                                        <th>Antigüedad</th>
                                        <th>Rol</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($empleados)): ?>
                                        <?php foreach ($empleados as $empleado): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($empleado['id_empleado']) ?></td>
                                                <td><?= htmlspecialchars($empleado['tipo_doc']) ?></td>
                                                <td><?= htmlspecialchars($empleado['nombres']) ?></td>
                                                <td><?= htmlspecialchars($empleado['apellidos']) ?></td>
                                                <td><?= htmlspecialchars($empleado['telefono']) ?></td>
                                                <td><?= htmlspecialchars($empleado['eps']) ?></td>
                                                <td><?= htmlspecialchars($empleado['arl']) ?></td>
                                                <td><?= htmlspecialchars($empleado['cargo_funcion']) ?></td>
                                                <td><?= htmlspecialchars($empleado['antig_cargo']) ?></td>
                                                <td><?= htmlspecialchars($empleado['rol_nombre'] ?? 'Sin asignar') ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="10" class="text-center">No hay empleados para mostrar</td>
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
<?php if (!$isTrabajador): ?>
document.getElementById('descargar-pdf').onclick = function(e) {
    e.preventDefault();
    const nombre = document.getElementById('nombre').value;
    const rol = document.getElementById('rol').value;
    let url = '?controller=reportes&action=empleados&format=pdf';
    if (nombre) url += '&nombre=' + encodeURIComponent(nombre);
    if (rol) url += '&rol=' + encodeURIComponent(rol);
    window.location.href = url;
};

document.getElementById('descargar-excel').onclick = function(e) {
    e.preventDefault();
    const nombre = document.getElementById('nombre').value;
    const rol = document.getElementById('rol').value;
    let url = '?controller=reportes&action=empleados&format=excel';
    if (nombre) url += '&nombre=' + encodeURIComponent(nombre);
    if (rol) url += '&rol=' + encodeURIComponent(rol);
    window.location.href = url;
};
<?php endif; ?>
</script>

<?php include __DIR__ . '/../footer.php'; ?>