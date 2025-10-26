<?php if (isset($data) && is_array($data)) extract($data); include __DIR__ . '/../header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <!-- Incluir sidebar -->
        <?php include __DIR__ . '/../sidebar.php'; ?>
        
        <!-- Contenido principal -->
        <main class="col-md-10 ms-sm-auto offset-md-2 px-4 main-content">
            <style>
                .areas-card {
                    border-radius: 1.2rem;
                    box-shadow: 0 2px 12px rgba(30,40,90,0.10);
                    background: #fff;
                    border: none;
                    padding: 2rem;
                    margin-top: 2rem;
                }
                .areas-title {
                    color: #1a237e;
                    font-weight: 700;
                    border-bottom: 3px solid #ffd600;
                    margin-bottom: 2rem;
                    padding-bottom: 0.5rem;
                }
                .btn-areas {
                    background: #3949ab;
                    color: #fff;
                    border-radius: 2rem;
                    font-weight: 600;
                    border: 2px solid #ffd600;
                    transition: background 0.2s, border 0.2s;
                }
                .btn-areas:hover {
                    background: #ffd600;
                    color: #3949ab;
                    border: 2px solid #3949ab;
                }
                .btn-areas-outline {
                    border: 2px solid #3949ab;
                    color: #3949ab;
                    background: #fff;
                    border-radius: 2rem;
                    font-weight: 600;
                    transition: background 0.2s, color 0.2s;
                }
                .btn-areas-outline:hover {
                    background: #3949ab;
                    color: #fff;
                    border: 2px solid #ffd600;
                }
            </style>

            <div class="areas-card">
                <div class="d-flex flex-column flex-lg-row align-items-center justify-content-center w-100 gap-5">
                    <div class="w-100" style="max-width:350px;">
                        <h2 class="areas-title text-center"><i class="bi bi-building me-2"></i>Gestión de Áreas</h2>
                        <form method="get" action="" class="mb-3">
                            <input type="hidden" name="controller" value="areas">
                            <input type="hidden" name="action" value="index">
                            <div class="mb-3">
                                <label for="filtro_nombre" class="form-label">Filtrar por nombre</label>
                                <input type="text" class="form-control" id="filtro_nombre" name="filtro_nombre" placeholder="Nombre del área" value="<?= isset($_GET['filtro_nombre']) ? htmlspecialchars($_GET['filtro_nombre']) : '' ?>">
                            </div>
                            <div class="mb-3">
                                <label for="orden" class="form-label">Ordenar por</label>
                                <select class="form-select" id="orden" name="orden">
                                    <option value="">Seleccione</option>
                                    <option value="asc" <?= (isset($_GET['orden']) && $_GET['orden'] == 'asc') ? 'selected' : '' ?>>A-Z</option>
                                    <option value="desc" <?= (isset($_GET['orden']) && $_GET['orden'] == 'desc') ? 'selected' : '' ?>>Z-A</option>
                                </select>
                            </div>
                            <div class="d-flex gap-2 justify-content-between">
                                <button type="submit" class="btn btn-areas-outline w-50"><i class="bi bi-funnel"></i> Filtrar</button>
                                <a href="?controller=areas&action=index" class="btn btn-secondary w-50"><i class="bi bi-x-circle"></i> Limpiar</a>
                            </div>
                        </form>
                        <div class="text-center">
                            <?php if (!$isCoordinador && !$isTrabajador): ?>
                                <a href="?controller=areas&action=create" class="btn btn-areas w-100"><i class="bi bi-plus-circle me-1"></i>Nueva Área</a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="w-100" style="max-width:700px;">
                        <h3 class="mb-3 text-center" style="color:#3949ab;font-weight:700;"><i class="bi bi-list-ul me-2"></i>Lista de Áreas</h3>
                        <div class="table-responsive">
                            <table class="table align-middle table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Descripción</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($areas as $area): ?>
                                    <tr>
                                        <td><span style="font-weight:700;color:#3949ab;"><?= htmlspecialchars($area['id_area']) ?></span></td>
                                        <td><span style="font-weight:600;color:#1a237e;background:#e3eafc;padding:0.2em 0.7em;border-radius:0.5em;box-shadow:0 2px 8px #3949ab22;"><?= htmlspecialchars($area['nombre']) ?></span></td>
                                        <td><?= htmlspecialchars($area['descripcion']) ?></td>
                                        <td>
                                            <?php if (!$isCoordinador && !$isSupervisor && !$isTrabajador): ?>
                                                <a href="?controller=areas&action=edit&id=<?= $area['id_area'] ?>" class="btn btn-areas-outline btn-sm me-1" title="Editar"><i class="bi bi-pencil"></i></a>
                                                <a href="?controller=areas&action=delete&id=<?= $area['id_area'] ?>" class="btn btn-danger btn-sm" title="Eliminar" onclick="return confirm('¿Seguro que deseas eliminar esta área?');" style="border-radius:2rem;"><i class="bi bi-trash"></i></a>
                                            <?php elseif (!$isCoordinador && $isSupervisor && !$isTrabajador): ?>
                                                <a href="?controller=areas&action=edit&id=<?= $area['id_area'] ?>" class="btn btn-areas-outline btn-sm" title="Editar"><i class="bi bi-pencil"></i></a>
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
