<?php if (isset($data) && is_array($data)) extract($data); include __DIR__ . '/../header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <!-- Incluir sidebar -->
        <?php include __DIR__ . '/../sidebar.php'; ?>
        
        <!-- Contenido principal -->
        <main class="col-md-10 ms-sm-auto offset-md-2 px-4 main-content">
            <style>
                .condicionesinseguras-card {
                    border-radius: 1.2rem;
                    box-shadow: 0 2px 12px rgba(30,40,90,0.10);
                    background: #fff;
                    border: none;
                    padding: 2rem;
                    margin-top: 2rem;
                }
                .condicionesinseguras-title {
                    color: #1a237e;
                    font-weight: 700;
                    border-bottom: 3px solid #ffd600;
                    margin-bottom: 2rem;
                    padding-bottom: 0.5rem;
                }
                .btn-condicionesinseguras {
                    background: #ff5722;
                    color: #fff;
                    border-radius: 2rem;
                    font-weight: 600;
                    border: 2px solid #ffd600;
                    transition: background 0.2s, border 0.2s;
                }
                .btn-condicionesinseguras:hover {
                    background: #ffd600;
                    color: #ff5722;
                    border: 2px solid #ff5722;
                }
                .btn-condicionesinseguras-outline {
                    border: 2px solid #ff5722;
                    color: #ff5722;
                    background: #fff;
                    border-radius: 2rem;
                    font-weight: 600;
                    transition: background 0.2s, color 0.2s;
                }
                .btn-condicionesinseguras-outline:hover {
                    background: #ff5722;
                    color: #fff;
                    border: 2px solid #ffd600;
                }
            </style>

            <div class="condicionesinseguras-card">
                <div class="d-flex flex-column flex-lg-row align-items-center justify-content-center w-100 gap-5">
                    <div class="w-100" style="max-width:350px;">
                        <h2 class="condicionesinseguras-title text-center"><i class="bi bi-exclamation-diamond me-2"></i>Gestión de Condiciones Inseguras</h2>
                        <form method="get" action="" class="mb-3">
                            <input type="hidden" name="controller" value="condicionesinseguras">
                            <input type="hidden" name="action" value="index">
                            <div class="row g-2 mb-2">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="filtro_nombre" placeholder="Nombre" value="<?= isset($_GET['filtro_nombre']) ? htmlspecialchars($_GET['filtro_nombre']) : '' ?>">
                                </div>
                                <div class="col-md-6">
                                    <select class="form-select" name="filtro_area">
                                        <option value="">Todas las áreas</option>
                                        <?php if (isset($areas)): ?>
                                            <?php foreach ($areas as $area): ?>
                                                <option value="<?= $area['id_area'] ?>" <?= (isset($filtro_area) && $filtro_area == $area['id_area']) ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($area['nombre']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <select class="form-select" name="filtro_orden">
                                        <option value="">Ordenar por</option>
                                        <option value="nombre_asc" <?= (isset($_GET['filtro_orden']) && $_GET['filtro_orden'] == 'nombre_asc') ? 'selected' : '' ?>>Nombre (A-Z)</option>
                                        <option value="nombre_desc" <?= (isset($_GET['filtro_orden']) && $_GET['filtro_orden'] == 'nombre_desc') ? 'selected' : '' ?>>Nombre (Z-A)</option>
                                        <option value="area_asc" <?= (isset($_GET['filtro_orden']) && $_GET['filtro_orden'] == 'area_asc') ? 'selected' : '' ?>>Área (A-Z)</option>
                                        <option value="area_desc" <?= (isset($_GET['filtro_orden']) && $_GET['filtro_orden'] == 'area_desc') ? 'selected' : '' ?>>Área (Z-A)</option>
                                        <option value="id_asc" <?= (isset($_GET['filtro_orden']) && $_GET['filtro_orden'] == 'id_asc') ? 'selected' : '' ?>>ID (Asc)</option>
                                        <option value="id_desc" <?= (isset($_GET['filtro_orden']) && $_GET['filtro_orden'] == 'id_desc') ? 'selected' : '' ?>>ID (Desc)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex gap-2 justify-content-between">
                                <button type="submit" class="btn btn-condicionesinseguras-outline"><i class="bi bi-funnel"></i> Filtrar</button>
                                <a href="?controller=condicionesinseguras&action=index" class="btn btn-secondary"><i class="bi bi-x-circle"></i> Limpiar</a>
                            </div>
                        </form>
                        <div class="text-center">
                            <?php if (!$isTrabajador): ?>
                                <a href="?controller=condicionesinseguras&action=create" class="btn btn-condicionesinseguras w-100"><i class="bi bi-plus-circle me-1"></i>Nueva Condición Insegura</a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="w-100" style="max-width:700px;">
                        <div class="table-responsive">
                            <table class="table align-middle table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Descripción</th>
                                        <th>Lugar</th>
                                        <th>Área</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($condiciones as $cond): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($cond['id_cond_inseg']) ?></td>
                                        <td><?= htmlspecialchars($cond['nombre']) ?></td>
                                        <td><?= htmlspecialchars($cond['descripcion']) ?></td>
                                        <td><?= htmlspecialchars($cond['lugar']) ?></td>
                                        <td><?= htmlspecialchars($cond['nombre_area']) ?></td>
                                        <td>
                                            <?php if (!$isTrabajador): ?>
                                                <a href="?controller=condicionesinseguras&action=edit&id=<?= $cond['id_cond_inseg'] ?>" class="btn btn-condicionesinseguras-outline btn-sm me-2" title="Editar"><i class="bi bi-pencil"></i></a>
                                            <?php endif; ?>
                                            <?php if (!$isCoordinador && !$isSupervisor && !$isTrabajador): ?>
                                                <a href="?controller=condicionesinseguras&action=delete&id=<?= $cond['id_cond_inseg'] ?>" class="btn btn-danger btn-sm" title="Eliminar" onclick="return confirm('¿Seguro que deseas eliminar esta condición?');" style="border-radius:2rem;"><i class="bi bi-trash"></i></a>
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
