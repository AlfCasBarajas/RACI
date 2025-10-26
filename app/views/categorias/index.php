<?php if (isset($data) && is_array($data)) extract($data); include __DIR__ . '/../header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <!-- Incluir sidebar -->
        <?php include __DIR__ . '/../sidebar.php'; ?>
        
        <!-- Contenido principal -->
        <main class="col-md-10 ms-sm-auto offset-md-2 px-4 main-content">
            <style>
                .categorias-card {
                    border-radius: 1.2rem;
                    box-shadow: 0 2px 12px rgba(30,40,90,0.10);
                    background: #fff;
                    border: none;
                    padding: 2rem;
                    margin-top: 2rem;
                }
                .categorias-title {
                    color: #1a237e;
                    font-weight: 700;
                    border-bottom: 3px solid #ffd600;
                    margin-bottom: 2rem;
                    padding-bottom: 0.5rem;
                }
                .btn-categorias {
                    background: #3949ab;
                    color: #fff;
                    border-radius: 2rem;
                    font-weight: 600;
                    border: 2px solid #ffd600;
                    transition: background 0.2s, border 0.2s;
                }
                .btn-categorias:hover {
                    background: #ffd600;
                    color: #3949ab;
                    border: 2px solid #3949ab;
                }
                .btn-categorias-outline {
                    border: 2px solid #3949ab;
                    color: #3949ab;
                    background: #fff;
                    border-radius: 2rem;
                    font-weight: 600;
                    transition: background 0.2s, color 0.2s;
                }
                .btn-categorias-outline:hover {
                    background: #3949ab;
                    color: #fff;
                    border: 2px solid #ffd600;
                }
            </style>

            <div class="categorias-card">
                <div class="d-flex flex-column flex-lg-row align-items-stretch justify-content-center w-100 gap-5">
                    <div class="w-100" style="max-width:350px;">
                        <h2 class="categorias-title text-center"><i class="bi bi-folder2-open me-2"></i>Gestión de Categorías</h2>
                        <form method="get" action="" class="mb-3">
                            <input type="hidden" name="controller" value="categorias">
                            <input type="hidden" name="action" value="index">
                            <div class="row g-2 mb-2">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="filtro_nombre" placeholder="Nombre" value="<?= isset($_GET['filtro_nombre']) ? htmlspecialchars($_GET['filtro_nombre']) : '' ?>">
                                </div>
                                <div class="col-md-6">
                                    <select class="form-select" name="filtro_area">
                                        <option value="">Área</option>
                                        <?php foreach ($areas as $area): ?>
                                            <option value="<?= $area['id_area'] ?>" <?= (isset($_GET['filtro_area']) && $_GET['filtro_area'] == $area['id_area']) ? 'selected' : '' ?>><?= htmlspecialchars($area['nombre']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <select class="form-select" name="filtro_usuario">
                                        <option value="">Usuario</option>
                                        <?php foreach ($usuarios as $usuario): ?>
                                            <option value="<?= $usuario['num_doc'] ?>" <?= (isset($_GET['filtro_usuario']) && $_GET['filtro_usuario'] == $usuario['num_doc']) ? 'selected' : '' ?>><?= htmlspecialchars($usuario['usuario']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <select class="form-select" name="filtro_orden">
                                        <option value="nombre_asc" <?= (isset($filtro_orden) && $filtro_orden == 'nombre_asc') ? 'selected' : '' ?>>Nombre (A-Z)</option>
                                        <option value="nombre_desc" <?= (isset($filtro_orden) && $filtro_orden == 'nombre_desc') ? 'selected' : '' ?>>Nombre (Z-A)</option>
                                        <option value="id_asc" <?= (isset($filtro_orden) && $filtro_orden == 'id_asc') ? 'selected' : '' ?>>ID (Asc)</option>
                                        <option value="id_desc" <?= (isset($filtro_orden) && $filtro_orden == 'id_desc') ? 'selected' : '' ?>>ID (Desc)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex gap-2 justify-content-between">
                                <button type="submit" class="btn btn-categorias-outline"><i class="bi bi-funnel"></i> Filtrar</button>
                                <a href="?controller=categorias&action=index" class="btn btn-secondary"><i class="bi bi-x-circle"></i> Limpiar</a>
                            </div>
                        </form>
                        <div class="text-center">
                            <?php if (!$isCoordinador && !$isTrabajador): ?>
                                <a href="?controller=categorias&action=create" class="btn btn-categorias w-100"><i class="bi bi-plus-circle me-1"></i>Nueva Categoría</a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="w-100" style="max-width:800px;">
                        <div class="table-responsive">
                            <table class="table align-middle table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Descripción</th>
                                        <th>Área</th>
                                        <th>Usuario</th>
                                        <th>Empleado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($categorias as $cat): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($cat['id_categoria']) ?></td>
                                        <td><?= htmlspecialchars($cat['nombre']) ?></td>
                                        <td><?= htmlspecialchars($cat['descripcion']) ?></td>
                                        <td><?= htmlspecialchars($cat['area_nombre']) ?></td>
                                        <td><?= htmlspecialchars($cat['usuario_nombre']) ?></td>
                                        <td><?= htmlspecialchars($cat['empleado_nombre']) ?></td>
                                        <td>
                                            <?php if (!$isCoordinador && !$isSupervisor && !$isTrabajador): ?>
                                                <a href="?controller=categorias&action=edit&id=<?= $cat['id_categoria'] ?>" class="btn btn-categorias-outline btn-sm me-2" title="Editar"><i class="bi bi-pencil"></i></a>
                                                <a href="?controller=categorias&action=delete&id=<?= $cat['id_categoria'] ?>" class="btn btn-danger btn-sm" title="Eliminar" onclick="return confirm('¿Seguro que deseas eliminar esta categoría?');" style="border-radius:2rem;"><i class="bi bi-trash"></i></a>
                                            <?php elseif (!$isCoordinador && $isSupervisor && !$isTrabajador): ?>
                                                <a href="?controller=categorias&action=edit&id=<?= $cat['id_categoria'] ?>" class="btn btn-categorias-outline btn-sm me-2" title="Editar"><i class="bi bi-pencil"></i></a>
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
