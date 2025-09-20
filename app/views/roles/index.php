<?php include __DIR__ . '/../header.php'; ?>
<style>
    .roles-bg {
        background: linear-gradient(135deg, #e3eafc 0%, #f5f7fa 100%);
        min-height: 100vh;
        padding-top: 40px;
        padding-bottom: 40px;
    }
    .roles-card {
        border-radius: 1.2rem;
        box-shadow: 0 2px 12px rgba(30,40,90,0.10);
        background: #fff;
        border: none;
    }
    .roles-title {
        color: #1a237e;
        font-weight: 700;
        letter-spacing: 1px;
    }
    .roles-table th {
        background: #e3eafc;
        color: #1a237e;
        font-weight: 600;
    }
    .roles-table td {
        vertical-align: middle;
    }
    .btn-roles {
        background: #1a237e;
        color: #fff;
        border-radius: 2rem;
        font-weight: 500;
        transition: background 0.2s;
    }
    .btn-roles:hover {
        background: #3949ab;
        color: #fff;
    }
    .btn-roles-outline {
        border: 2px solid #1a237e;
        color: #1a237e;
        background: #fff;
        border-radius: 2rem;
        font-weight: 500;
        transition: background 0.2s, color 0.2s;
    }
    .btn-roles-outline:hover {
        background: #1a237e;
        color: #fff;
    }
</style>
<div class="roles-bg">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card roles-card p-4">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
                        <div class="w-100 text-center mb-2 mb-md-0">
                            <h2 class="roles-title mb-0"><i class="bi bi-person-badge me-2"></i>Gestión de Roles</h2>
                        </div>
                        <form class="d-flex align-items-center gap-2" method="get" action="">
                            <input type="hidden" name="controller" value="roles">
                            <input type="hidden" name="action" value="index">
                            <input type="text" class="form-control" name="filtro_nombre" placeholder="Filtrar por nombre" value="<?= isset($_GET['filtro_nombre']) ? htmlspecialchars($_GET['filtro_nombre']) : '' ?>" style="max-width: 200px;">
                            <select class="form-select" name="orden" style="max-width: 180px;">
                                <option value="">Ordenar por</option>
                                <option value="asc" <?= (isset($_GET['orden']) && $_GET['orden'] == 'asc') ? 'selected' : '' ?>>A-Z</option>
                                <option value="desc" <?= (isset($_GET['orden']) && $_GET['orden'] == 'desc') ? 'selected' : '' ?>>Z-A</option>
                            </select>
                            <button type="submit" class="btn btn-roles-outline"><i class="bi bi-funnel"></i> Filtrar</button>
                            <a href="?controller=roles&action=index" class="btn btn-secondary ms-2"><i class="bi bi-x-circle"></i> Limpiar</a>
                        </form>
                        <a href="?controller=roles&action=create" class="btn btn-roles"><i class="bi bi-plus-circle me-1"></i>Nuevo Rol</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table roles-table align-middle">
                            <thead>
                                <tr>
                                    <th style="width: 80px;">ID</th>
                                    <th>Nombre</th>
                                    <th style="width: 180px;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($roles as $rol): ?>
                                <tr>
                                    <td><?= htmlspecialchars($rol['id_Rol']) ?></td>
                                    <td><?= htmlspecialchars($rol['nombre']) ?></td>
                                    <td>
                                        <a href="?controller=roles&action=edit&id=<?= $rol['id_Rol'] ?>" class="btn btn-roles-outline btn-sm me-2"><i class="bi bi-pencil"></i> Editar</a>
                                        <a href="?controller=roles&action=delete&id=<?= $rol['id_Rol'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar este rol?')"><i class="bi bi-trash"></i> Eliminar</a>
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
</div>
<?php include __DIR__ . '/../footer.php'; ?>
