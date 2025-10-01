<?php include __DIR__ . '/../header.php'; ?>
<style>
    body {
        background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
        min-height: 100vh;
    }
    .roles-bg {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .roles-card {
        border-radius: 1.2rem;
        box-shadow: 0 2px 12px rgba(30,40,90,0.10);
        background: #fff;
        border: none;
        max-width: 400px;
        margin: auto;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .roles-title {
        color: #1a237e;
        font-weight: 700;
        letter-spacing: 1px;
        text-align: center;
        width: 100%;
        border-bottom: 3px solid #ffd600;
        margin-bottom: 2rem;
        padding-bottom: 0.5rem;
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
</style>
<div class="roles-bg">
    <div class="d-flex flex-column align-items-center justify-content-center min-vh-100">
        <div class="card roles-card p-4 w-100">
            <h2 class="roles-title mb-4"><i class="bi bi-person-badge me-2"></i>Editar Rol</h2>
            <form method="post" action="?controller=roles&action=update&id=<?= $rol['id_Rol'] ?>" class="w-100">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre del Rol</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($rol['nombre']) ?>" required>
                </div>
                <div class="d-flex justify-content-center gap-3">
                    <button type="submit" class="btn btn-roles"><i class="bi bi-check-circle me-1"></i>Actualizar</button>
                    <a href="?controller=roles&action=index" class="btn btn-roles-outline">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include __DIR__ . '/../footer.php'; ?>
