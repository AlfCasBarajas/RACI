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
            <div class="col-lg-6">
                <div class="card roles-card p-4">
                    <h2 class="roles-title mb-4"><i class="bi bi-person-badge me-2"></i>Nuevo Rol</h2>
                    <form method="post" action="?controller=roles&action=store">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre del Rol</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-roles me-2"><i class="bi bi-check-circle me-1"></i>Guardar</button>
                            <a href="?controller=roles&action=index" class="btn btn-roles-outline">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include __DIR__ . '/../footer.php'; ?>
