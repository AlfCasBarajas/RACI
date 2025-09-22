<h2 class="text-center mb-4"><i class="fas fa-users"></i> Gestión de Usuarios</h2>

<!-- Formulario de creación de usuario -->
<div class="container">
    <form method="POST" class="formulario mx-auto" style="max-width: 600px;">
        <div class="mb-3">
            <input type="text" name="nombres" class="form-control" placeholder="Nombres" required>
        </div>
        <div class="mb-3">
            <input type="text" name="apellidos" class="form-control" placeholder="Apellidos" required>
        </div>
        <div class="mb-3">
            <input type="number" name="num_doc" class="form-control" placeholder="Documento" required>
        </div>
        <div class="mb-3">
            <input type="password" name="contrasena" class="form-control" placeholder="Contraseña" required>
        </div>
        <div class="mb-3">
            <select name="rol" class="form-select" required>
                <option value="">Selecciona un Rol</option>
                <?php foreach ($roles as $r): ?>
                    <option value="<?= $r["id_Rol"] ?>"><?= $r["nombre"] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" name="crear" class="btn btn-primary w-100">
            <i class="fas fa-user-plus"></i> Crear Usuario
        </button>
    </form>
</div>

<!-- Tabla de usuarios -->
<div class="container mt-5">
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Documento</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $u): ?>
                <tr>
                    <form method="POST">
                        <td><?= $u["num_doc"] ?></td>
                        <td><input type="text" name="nombres" value="<?= $u["nombres"] ?>" class="form-control"></td>
                        <td><input type="text" name="apellidos" value="<?= $u["apellidos"] ?>" class="form-control"></td>
                        <td><input type="number" name="num_doc" value="<?= $u["num_doc"] ?>" class="form-control"></td>
                        <td>
                            <select name="rol" class="form-select">
                                <?php foreach ($roles as $r): ?>
                                    <option value="<?= $r["id_Rol"] ?>" <?= $r["id_Rol"] == $u["rol"] ? "selected" : "" ?>>
                                        <?= $r["nombre"] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td>
                            <input type="hidden" name="id" value="<?= $u["num_doc"] ?>">
                            <button type="submit" name="actualizar" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Editar
                            </button>
                            <button type="submit" name="eliminar" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este usuario?')">
                                <i class="fas fa-trash"></i> Eliminar
                            </button>
                        </td>
                    </form>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
