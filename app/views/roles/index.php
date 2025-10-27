<?php include __DIR__ . '/../header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php include __DIR__ . '/../sidebar.php'; ?>
        <main class="col-md-10 ms-sm-auto offset-md-2 px-4 main-content">
            <div style="border-radius: 1.2rem; box-shadow: 0 2px 12px rgba(30,40,90,0.10); background: #fff; border: none; padding: 2rem; margin-top: 2rem;">
                <h2 style="color: #1a237e; font-weight: 700; border-bottom: 3px solid #ffd600; margin-bottom: 1.5rem; padding-bottom: 0.5rem; text-align: center;"><i class="bi bi-person-badge me-2"></i>Gestión de Roles</h2>
                
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
                        <i class="bi bi-exclamation-triangle me-2"></i><?= $_SESSION['error'] ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>
                
                <!-- Filtros de búsqueda -->
                <div class="mb-4">
                    <form class="row g-3 align-items-end" method="get" action="">
                        <input type="hidden" name="controller" value="roles">
                        <input type="hidden" name="action" value="index">
                        <div class="col-md-4">
                            <label for="filtro_nombre" class="form-label">Filtrar por nombre</label>
                            <input type="text" class="form-control" id="filtro_nombre" name="filtro_nombre" placeholder="Ej: Administrador" value="<?= isset($_GET['filtro_nombre']) ? htmlspecialchars($_GET['filtro_nombre']) : '' ?>">
                        </div>
                        <div class="col-md-3">
                            <label for="orden" class="form-label">Ordenar por</label>
                            <select class="form-select" id="orden" name="orden">
                                <option value="">Seleccione</option>
                                <option value="asc" <?= (isset($_GET['orden']) && $_GET['orden'] == 'asc') ? 'selected' : '' ?>>A-Z</option>
                                <option value="desc" <?= (isset($_GET['orden']) && $_GET['orden'] == 'desc') ? 'selected' : '' ?>>Z-A</option>
                            </select>
                        </div>
                        <div class="col-md-5">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary"><i class="bi bi-funnel"></i> Filtrar</button>
                                <a href="?controller=roles&action=index" class="btn btn-secondary"><i class="bi bi-x-circle"></i> Limpiar</a>
                                <?php if (!$isCoordinador && !$isTrabajador): ?>
                                    <a href="?controller=roles&action=create" class="btn btn-success"><i class="bi bi-plus-circle me-1"></i>Nuevo Rol</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Tabla de roles -->
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th style="width: 100px;">ID</th>
                                <th>Nombre del Rol</th>
                                <th style="width: 200px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($roles)): ?>
                                <?php foreach ($roles as $rol): ?>
                                <tr>
                                    <td>
                                        <span class="badge bg-primary fs-6"><?= htmlspecialchars($rol['id_Rol']) ?></span>
                                    </td>
                                    <td>
                                        <span class="fw-semibold text-dark"><?= htmlspecialchars($rol['nombre']) ?></span>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <?php if (!$isCoordinador && !$isSupervisor && !$isTrabajador): ?>
                                                <a href="?controller=roles&action=edit&id=<?= $rol['id_Rol'] ?>" class="btn btn-primary btn-sm" title="Editar">
                                                    <i class="bi bi-pencil me-1"></i>Editar
                                                </a>
                                                <a href="?controller=roles&action=delete&id=<?= $rol['id_Rol'] ?>" class="btn btn-outline-danger btn-sm" title="Eliminar" onclick="return confirm('¿Seguro que deseas eliminar este rol?')">
                                                    <i class="bi bi-trash me-1"></i>Eliminar
                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted small">Sin permisos</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">
                                        <i class="bi bi-inbox display-6 d-block mb-2"></i>
                                        No hay roles disponibles
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include __DIR__ . '/../footer.php'; ?>
