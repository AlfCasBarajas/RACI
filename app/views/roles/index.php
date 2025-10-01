<?php include __DIR__ . '/../header.php'; ?>
<style>
    body {
    .btn-inicio {
        background: #3949ab;
        color: #fff;
        border-radius: 2rem;
        font-weight: 600;
        border: 2px solid #ffd600;
        transition: background 0.2s, color 0.2s, border 0.2s;
    }
    .btn-inicio:hover {
        background: #ffd600;
        color: #3949ab;
        border: 2px solid #3949ab;
        box-shadow: 0 2px 12px #ffd60055;
    }
        background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
        min-height: 100vh;
    }
    .roles-title {
    font-weight: 700;
    border-bottom: 3px solid #ffd600;
    color: #1a237e;
    }
    .roles-table td {
        vertical-align: middle;
        font-size: 1.08rem;
        color: #232f3e;
    }
    .btn-roles {
        background: #3949ab;
        color: #fff;
        border-radius: 2rem;
        font-weight: 600;
        border: 2px solid #ffd600;
        box-shadow: 0 2px 8px rgba(255,214,0,0.10);
        transition: background 0.2s, border 0.2s;
    }
    .btn-roles:hover {
        background: #ffd600;
        color: #3949ab;
        border: 2px solid #3949ab;
    }
    .btn-roles-outline {
        border: 2px solid #3949ab;
        color: #3949ab;
        background: #fff;
        border-radius: 2rem;
        font-weight: 600;
        transition: background 0.2s, color 0.2s, border 0.2s;
    }
    .btn-roles-outline:hover {
        background: #3949ab;
        color: #fff;
        border: 2px solid #ffd600;
    }
    .roles-actions {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
        flex-wrap: wrap;
    }
    @media (max-width: 768px) {
        .roles-card {
            padding: 1.2rem 0.5rem;
        }
        .roles-title {
            font-size: 1.3rem;
        }
        .roles-table th, .roles-table td {
            font-size: 0.98rem;
        }
    }
    .btn-inicio-claro {
        background: #e3f2fd;
        color: #3949ab;
        border-radius: 2rem;
        font-weight: 600;
        border: 2px solid #bbdefb;
        box-shadow: 0 2px 8px #bbdefb88;
        transition: background 0.2s, color 0.2s, border 0.2s;
    }
    .btn-inicio-claro:hover {
        background: #ffd600;
        color: #3949ab;
        border: 2px solid #3949ab;
        box-shadow: 0 2px 12px #ffd60055;
    }
</style>

<div class="roles-bg">
    <div class="container d-flex flex-column align-items-center justify-content-center min-vh-100 position-relative">
        <a href="app/views/dashboard.php" class="btn btn-inicio btn-inicio-claro position-absolute" style="top:24px;left:24px;z-index:10;"><i class="bi bi-arrow-left"></i> Ir a Inicio</a>
        <div class="d-flex flex-column flex-lg-row align-items-center justify-content-center w-100 gap-5" style="max-width:1200px;">
            <div class="card roles-card p-4 mb-3 h-100 d-flex flex-column justify-content-between align-items-center" style="min-width:320px;max-width:350px;width:100%;">
                <div class="mb-3 w-100">
                    <h2 class="roles-title mb-3 text-center"><i class="bi bi-person-badge me-2"></i>Gestión de Roles</h2>
                    <form method="get" action="">
                        <input type="hidden" name="controller" value="roles">
                        <input type="hidden" name="action" value="index">
                        <div class="mb-3">
                            <label for="filtro_nombre" class="form-label">Filtrar por nombre</label>
                            <input type="text" class="form-control" id="filtro_nombre" name="filtro_nombre" placeholder="Ej: Administrador" value="<?= isset($_GET['filtro_nombre']) ? htmlspecialchars($_GET['filtro_nombre']) : '' ?>">
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
                            <button type="submit" class="btn btn-roles-outline w-50"><i class="bi bi-funnel"></i> Filtrar</button>
                            <a href="?controller=roles&action=index" class="btn btn-secondary w-50"><i class="bi bi-x-circle"></i> Limpiar</a>
                        </div>
                    </form>
                </div>
                <div class="mt-auto w-100 text-center">
                    <a href="?controller=roles&action=create" class="btn btn-roles w-100"><i class="bi bi-plus-circle me-1"></i> Nuevo Rol</a>
                </div>
            </div>
            <div class="card roles-card p-4 h-100 d-flex flex-column align-items-center justify-content-center" style="max-width:700px;width:100%;margin:auto;">
                <h3 class="mb-3 text-center" style="color:#3949ab;font-weight:700;"><i class="bi bi-list-ul me-2"></i>Lista de Roles</h3>
                <div class="table-responsive w-100 d-flex justify-content-center">
                    <table class="table roles-table align-middle mb-0 mx-auto" style="width:100%;">
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
                                <td><span style="font-weight:700;color:#3949ab;">
                                    <?= htmlspecialchars($rol['id_Rol']) ?></span></td>
                                <td><span style="font-weight:600;color:#1a237e;background:#e3eafc;padding:0.2em 0.7em;border-radius:0.5em;box-shadow:0 2px 8px #3949ab22;">
                                    <?= htmlspecialchars($rol['nombre']) ?></span></td>
                                <td class="roles-actions">
                                    <a href="?controller=roles&action=edit&id=<?= $rol['id_Rol'] ?>" class="btn btn-roles-outline btn-sm"><i class="bi bi-pencil"></i> Editar</a>
                                    <a href="?controller=roles&action=delete&id=<?= $rol['id_Rol'] ?>" class="btn btn-danger btn-sm" style="border-radius:2rem;font-weight:600;" onclick="return confirm('¿Seguro que deseas eliminar este rol?')"><i class="bi bi-trash"></i> Eliminar</a>
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
