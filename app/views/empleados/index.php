<?php
if (isset($data) && is_array($data)) extract($data);
include __DIR__ . '/../header.php'; ?>

<div class="container-fluid p-0">
    <div class="row g-0">
        <!-- Incluir sidebar -->
        <?php include __DIR__ . '/../sidebar.php'; ?>
        
        <!-- Contenido principal -->
        <main class="col-md-10 ms-sm-auto offset-md-2 px-2 main-content">
            <style>
                .empleados-card {
                    border-radius: 0.8rem;
                    box-shadow: 0 2px 12px rgba(30,40,90,0.10);
                    background: #fff;
                    border: none;
                    padding: 1rem;
                    margin-top: 1rem;
                }
                .empleados-title {
                    color: #1a237e;
                    font-weight: 700;
                    border-bottom: 3px solid #ffd600;
                    margin-bottom: 1rem;
                    padding-bottom: 0.5rem;
                    font-size: 1.5rem;
                }
                .btn-empleados {
                    background: #3949ab;
                    color: #fff;
                    border-radius: 2rem;
                    font-weight: 600;
                    border: 2px solid #ffd600;
                    transition: background 0.2s, border 0.2s;
                }
                .btn-empleados:hover {
                    background: #ffd600;
                    color: #3949ab;
                    border: 2px solid #3949ab;
                }
                .btn-empleados-outline {
                    border: 2px solid #3949ab;
                    color: #3949ab;
                    background: #fff;
                    border-radius: 2rem;
                    font-weight: 600;
                    transition: background 0.2s, color 0.2s;
                }
                .btn-empleados-outline:hover {
                    background: #3949ab;
                    color: #fff;
                    border: 2px solid #ffd600;
                }
                .table-empleados {
                    font-size: 0.85rem;
                }
                .table-empleados th {
                    background-color: #f8f9fa;
                    border-top: none;
                    font-weight: 600;
                    font-size: 0.8rem;
                    padding: 0.5rem 0.3rem;
                    white-space: nowrap;
                    text-align: left;
                }
                .table-empleados th:first-child {
                    text-align: center;
                }
                .table-empleados th:last-child {
                    text-align: center;
                }
                .table-empleados td {
                    padding: 0.4rem 0.3rem;
                    vertical-align: middle;
                    font-size: 0.8rem;
                }
                .table-empleados td:first-child {
                    text-align: center;
                }
                .table-empleados td:last-child {
                    text-align: center;
                }
                .table-responsive {
                    border-radius: 0.5rem;
                    max-height: 70vh;
                    overflow-y: auto;
                }
                .filters-compact {
                    background: #f8f9fa;
                    border-radius: 0.5rem;
                    padding: 0.8rem;
                    margin-bottom: 0.5rem;
                }
                .content-wrapper {
                    max-width: 100% !important;
                    width: 100% !important;
                }
            </style>

            <div class="empleados-card">
                <div class="d-flex flex-column w-100 gap-2">
                    <div class="w-100">
                        <h2 class="empleados-title text-center"><i class="bi bi-person-lines-fill me-2"></i>Gestión de Empleados</h2>
                        
                        <!-- Mensajes de éxito y error -->
                        <?php if (isset($_SESSION['success'])): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle me-2"></i><?= $_SESSION['success'] ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                            <?php unset($_SESSION['success']); ?>
                        <?php endif; ?>
                        
                        <?php if (isset($_SESSION['error'])): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                <div><?= nl2br(htmlspecialchars($_SESSION['error'])) ?></div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                            <?php unset($_SESSION['error']); ?>
                        <?php endif; ?>
                        
                        <form method="get" action="" class="filters-compact">
                            <input type="hidden" name="controller" value="empleados">
                            <input type="hidden" name="action" value="index">
                            <div class="row g-2 align-items-center">
                                <div class="col-md-2">
                                    <input type="text" class="form-control form-control-sm" name="filtro_tipo_doc" placeholder="Tipo Doc" value="<?= isset($_GET['filtro_tipo_doc']) ? htmlspecialchars($_GET['filtro_tipo_doc']) : '' ?>">
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control form-control-sm" name="filtro_nombre" placeholder="Nombre" value="<?= isset($_GET['filtro_nombre']) ? htmlspecialchars($_GET['filtro_nombre']) : '' ?>">
                                </div>
                                <div class="col-md-2">
                                    <select class="form-select form-select-sm" name="filtro_rol">
                                        <option value="">Rol</option>
                                        <?php foreach ($roles as $rol): ?>
                                            <option value="<?= $rol['id_Rol'] ?>" <?= (isset($_GET['filtro_rol']) && $_GET['filtro_rol'] == $rol['id_Rol']) ? 'selected' : '' ?>><?= htmlspecialchars($rol['nombre']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select class="form-select form-select-sm" name="filtro_area">
                                        <option value="">Área</option>
                                        <?php foreach ($areas as $area): ?>
                                            <option value="<?= $area['id_area'] ?>" <?= (isset($_GET['filtro_area']) && $_GET['filtro_area'] == $area['id_area']) ? 'selected' : '' ?>><?= htmlspecialchars($area['nombre']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select class="form-select form-select-sm" name="orden">
                                        <option value="">Ordenar</option>
                                        <option value="tipo_doc" <?= (isset($_GET['orden']) && $_GET['orden'] == 'tipo_doc') ? 'selected' : '' ?>>Tipo Doc</option>
                                        <option value="nombres" <?= (isset($_GET['orden']) && $_GET['orden'] == 'nombres') ? 'selected' : '' ?>>Nombre</option>
                                        <option value="apellidos" <?= (isset($_GET['orden']) && $_GET['orden'] == 'apellidos') ? 'selected' : '' ?>>Apellidos</option>
                                        <option value="cargo" <?= (isset($_GET['orden']) && $_GET['orden'] == 'cargo') ? 'selected' : '' ?>>Cargo</option>
                                        <option value="rol" <?= (isset($_GET['orden']) && $_GET['orden'] == 'rol') ? 'selected' : '' ?>>Rol</option>
                                        <option value="area" <?= (isset($_GET['orden']) && $_GET['orden'] == 'area') ? 'selected' : '' ?>>Área</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <div class="d-flex gap-1">
                                        <button type="submit" class="btn btn-empleados btn-sm"><i class="bi bi-search"></i></button>
                                        <a href="?controller=empleados&action=index" class="btn btn-outline-secondary btn-sm"><i class="bi bi-x"></i></a>
                                        <?php if (!$isTrabajador): ?>
                                            <a href="?controller=empleados&action=create" class="btn btn-success btn-sm" title="Nuevo"><i class="bi bi-plus"></i></a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="content-wrapper">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-empleados">
                                <thead>
                                    <tr>
                                        <th style="width: 8%;">ID</th>
                                        <th style="width: 6%;">Tipo</th>
                                        <th style="width: 13%;">Nombres</th>
                                        <th style="width: 13%;">Apellidos</th>
                                        <th style="width: 10%;">Teléfono</th>
                                        <th style="width: 10%;">EPS</th>
                                        <th style="width: 10%;">ARL</th>
                                        <th style="width: 12%;">Cargo</th>
                                        <th style="width: 8%;">Antigüedad</th>
                                        <th style="width: 8%;">Rol</th>
                                        <th style="width: 8%;">Área</th>
                                        <th style="width: 4%;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($empleados as $empleado): ?>
                                    <tr>
                                        <td><span class="badge bg-light text-dark border"><?= htmlspecialchars($empleado['id_empleado']) ?></span></td>
                                        <td><small class="text-muted"><?= htmlspecialchars($empleado['tipo_doc']) ?></small></td>
                                        <td><strong><?= htmlspecialchars($empleado['nombres']) ?></strong></td>
                                        <td><?= htmlspecialchars($empleado['apellidos']) ?></td>
                                        <td><small><?= htmlspecialchars($empleado['telefono']) ?></small></td>
                                        <td><small class="text-info"><?= htmlspecialchars($empleado['eps'] ?? 'N/A') ?></small></td>
                                        <td><small class="text-info"><?= htmlspecialchars($empleado['arl'] ?? 'N/A') ?></small></td>
                                        <td><small class="text-secondary"><?= htmlspecialchars($empleado['cargo_funcion']) ?></small></td>
                                        <td><small class="text-muted"><?= htmlspecialchars($empleado['antig_cargo'] ?? 'N/A') ?></small></td>
                                        <td><span class="badge bg-primary"><?= htmlspecialchars($empleado['rol_nombre']) ?></span></td>
                                        <td><span class="badge bg-info"><?= htmlspecialchars($empleado['area_nombre'] ?? 'Sin área') ?></span></td>
                                        <td>
                                            <?php if (!$isCoordinador && !$isSupervisor && !$isTrabajador): ?>
                                                <div class="btn-group" role="group">
                                                    <a href="?controller=empleados&action=edit&id=<?= $empleado['id_empleado'] ?>" class="btn btn-outline-primary btn-sm" title="Editar"><i class="bi bi-pencil"></i></a>
                                                    <a href="?controller=empleados&action=delete&id=<?= $empleado['id_empleado'] ?>" class="btn btn-outline-danger btn-sm" title="Eliminar" onclick="return confirm('¿Seguro que deseas eliminar este empleado?');"><i class="bi bi-trash"></i></a>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include __DIR__ . '/../footer.php'; ?>
