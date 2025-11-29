<?php if (isset($data) && is_array($data)) extract($data); include __DIR__ . '/../header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <!-- Incluir sidebar -->
        <?php include __DIR__ . '/../sidebar.php'; ?>
        
        <!-- Contenido principal -->
        <main class="col-md-10 ms-sm-auto offset-md-2 px-4 main-content">
            <style>
                .empleados-card {
                    border-radius: 1.2rem;
                    box-shadow: 0 2px 12px rgba(30,40,90,0.10);
                    background: #fff;
                    border: none;
                    padding: 2rem;
                    margin-top: 2rem;
                }
                .empleados-title {
                    color: #1a237e;
                    font-weight: 700;
                    border-bottom: 3px solid #ffd600;
                    margin-bottom: 2rem;
                    padding-bottom: 0.5rem;
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
            </style>

            <div class="empleados-card">
                <div class="d-flex flex-column flex-lg-row align-items-center justify-content-center w-100 gap-5">
                    <div class="w-100" style="max-width:450px;">
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
                        
                        <form method="get" action="" class="mb-3">
                            <input type="hidden" name="controller" value="empleados">
                            <input type="hidden" name="action" value="index">
                            <div class="mb-3">
                                <label for="filtro_nombre" class="form-label">Filtrar por nombre</label>
                                <input type="text" class="form-control" id="filtro_nombre" name="filtro_nombre" placeholder="Nombre del empleado" value="<?= isset($_GET['filtro_nombre']) ? htmlspecialchars($_GET['filtro_nombre']) : '' ?>">
                            </div>
                            <div class="mb-3">
                                <label for="filtro_tipo_doc" class="form-label">Filtrar por tipo de documento</label>
                                <select class="form-select" id="filtro_tipo_doc" name="filtro_tipo_doc">
                                    <option value="">Seleccione tipo</option>
                                    <option value="CC" <?= (isset($_GET['filtro_tipo_doc']) && $_GET['filtro_tipo_doc'] == 'CC') ? 'selected' : '' ?>>Cédula de Ciudadanía</option>
                                    <option value="CE" <?= (isset($_GET['filtro_tipo_doc']) && $_GET['filtro_tipo_doc'] == 'CE') ? 'selected' : '' ?>>Cédula de Extranjería</option>
                                    <option value="TI" <?= (isset($_GET['filtro_tipo_doc']) && $_GET['filtro_tipo_doc'] == 'TI') ? 'selected' : '' ?>>Tarjeta de Identidad</option>
                                    <option value="PP" <?= (isset($_GET['filtro_tipo_doc']) && $_GET['filtro_tipo_doc'] == 'PP') ? 'selected' : '' ?>>Pasaporte</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="filtro_rol" class="form-label">Filtrar por rol</label>
                                <select class="form-select" id="filtro_rol" name="filtro_rol">
                                    <option value="">Seleccione un rol</option>
                                    <?php foreach ($roles as $rol): ?>
                                        <option value="<?= $rol['id_Rol'] ?>" <?= (isset($_GET['filtro_rol']) && $_GET['filtro_rol'] == $rol['id_Rol']) ? 'selected' : '' ?>><?= htmlspecialchars($rol['nombre']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="filtro_area" class="form-label">Filtrar por área</label>
                                <select class="form-select" id="filtro_area" name="filtro_area">
                                    <option value="">Seleccione un área</option>
                                    <?php foreach ($areas as $area): ?>
                                        <option value="<?= $area['id_area'] ?>" <?= (isset($_GET['filtro_area']) && $_GET['filtro_area'] == $area['id_area']) ? 'selected' : '' ?>><?= htmlspecialchars($area['nombre']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="orden" class="form-label">Ordenar por</label>
                                <select class="form-select" id="orden" name="orden">
                                    <option value="">Seleccione</option>
                                    <option value="tipo_doc" <?= (isset($_GET['orden']) && $_GET['orden'] == 'tipo_doc') ? 'selected' : '' ?>>Tipo Documento</option>
                                    <option value="nombres" <?= (isset($_GET['orden']) && $_GET['orden'] == 'nombres') ? 'selected' : '' ?>>Nombres (A-Z)</option>
                                    <option value="apellidos" <?= (isset($_GET['orden']) && $_GET['orden'] == 'apellidos') ? 'selected' : '' ?>>Apellidos (A-Z)</option>
                                    <option value="cargo" <?= (isset($_GET['orden']) && $_GET['orden'] == 'cargo') ? 'selected' : '' ?>>Cargo</option>
                                    <option value="rol" <?= (isset($_GET['orden']) && $_GET['orden'] == 'rol') ? 'selected' : '' ?>>Rol</option>
                                    <option value="area" <?= (isset($_GET['orden']) && $_GET['orden'] == 'area') ? 'selected' : '' ?>>Área</option>
                                </select>
                            </div>
                            <div class="d-flex gap-2 justify-content-between">
                                <button type="submit" class="btn btn-empleados-outline w-50"><i class="bi bi-funnel"></i> Filtrar</button>
                                <a href="?controller=empleados&action=index" class="btn btn-secondary w-50"><i class="bi bi-x-circle"></i> Limpiar</a>
                            </div>
                        </form>
                        <div class="text-center">
                            <?php if (!$isTrabajador): ?>
                                <a href="?controller=empleados&action=create" class="btn btn-empleados w-100"><i class="bi bi-plus-circle me-1"></i>Nuevo Empleado</a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="w-100" style="max-width:1200px;">
                        <h3 class="mb-3 text-center" style="color:#3949ab;font-weight:700;"><i class="bi bi-list-ul me-2"></i>Lista de Empleados</h3>
                        <div class="table-responsive">
                            <table class="table align-middle table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Tipo Doc</th>
                                        <th>Nombres</th>
                                        <th>Apellidos</th>
                                        <th>Teléfono</th>
                                        <th>EPS</th>
                                        <th>ARL</th>
                                        <th>Cargo</th>
                                        <th>Antigüedad</th>
                                        <th>Rol</th>
                                        <th>Área</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($empleados as $empleado): ?>
                                    <tr>
                                        <td><span style="font-weight:700;color:#3949ab;"><?= htmlspecialchars($empleado['id_empleado']) ?></span></td>
                                        <td><small class="text-muted"><?= htmlspecialchars($empleado['tipo_doc']) ?></small></td>
                                        <td><span style="font-weight:600;color:#1a237e;background:#e3eafc;padding:0.2em 0.7em;border-radius:0.5em;box-shadow:0 2px 8px #3949ab22;"><?= htmlspecialchars($empleado['nombres']) ?></span></td>
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
                                                <a href="?controller=empleados&action=edit&id=<?= $empleado['id_empleado'] ?>" class="btn btn-empleados-outline btn-sm me-1" title="Editar"><i class="bi bi-pencil"></i></a>
                                                <a href="?controller=empleados&action=delete&id=<?= $empleado['id_empleado'] ?>" class="btn btn-danger btn-sm" title="Eliminar" onclick="return confirm('¿Seguro que deseas eliminar este empleado?');" style="border-radius:2rem;"><i class="bi bi-trash"></i></a>
                                            <?php elseif (!$isCoordinador && $isSupervisor && !$isTrabajador): ?>
                                                <a href="?controller=empleados&action=edit&id=<?= $empleado['id_empleado'] ?>" class="btn btn-empleados-outline btn-sm" title="Editar"><i class="bi bi-pencil"></i></a>
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
