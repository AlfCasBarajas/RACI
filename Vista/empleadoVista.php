<h2 class="text-center mb-4"><i class="fas fa-users-cog"></i> Gestión de Empleados</h2>

<?php if ($_SESSION["rol"] !== "Trabajador"): ?>
<!-- Formulario para crear empleado -->
<div class="container">
    <form method="POST" class="formulario mx-auto" style="max-width: 600px;">
        <div class="mb-3">
            <input type="text" name="nombre" class="form-control" placeholder="Nombre completo" required>
        </div>
        <div class="mb-3">
            <input type="number" name="documento" class="form-control" placeholder="Documento" required>
        </div>
        <div class="mb-3">
            <input type="text" name="cargo" class="form-control" placeholder="Cargo" required>
        </div>
        <div class="mb-3">
            <select name="id_area" class="form-select" required>
                <option value="">Selecciona un Área</option>
                <?php foreach ($areas as $a): ?>
                    <option value="<?= $a["id_area"] ?>"><?= $a["nombre"] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" name="crear" class="btn btn-success w-100">
            <i class="fas fa-user-plus"></i> Crear Empleado
        </button>
    </form>
</div>
<?php endif; ?>

<!-- Tabla de empleados -->
<div class="container mt-5">
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Documento</th>
                <th>Cargo</th>
                <th>Área</th>
                <?php if ($_SESSION["rol"] !== "Trabajador"): ?>
                    <th>Acciones</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($empleados as $e): ?>
            <tr>
                <form method="POST">
                    <td><?= $e["id_empleado"] ?></td>
                    <td><input type="text" name="nombre" value="<?= $e["nombres"] ?>" class="form-control"></td>
                    <td><input type="number" name="documento" value="<?= $e["tipo_doc"] ?>" class="form-control"></td>
                    <td><input type="text" name="cargo" value="<?= $e["cargo_funcion"] ?>" class="form-control"></td>
                    <td>
                        <select name="id_area" class="form-select">
                            <?php foreach ($areas as $a): ?>
                                <option value="<?= $a["id_area"] ?>" <?= $a["id_area"] == $e["id_empleado"] ? "selected" : "" ?>>
                                    <?= $a["nombre"] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <?php if ($_SESSION["rol"] !== "Trabajador"): ?>
                    <td>
                        <input type="hidden" name="id" value="<?= $e["id_empleado"] ?>">
                        <button type="submit" name="actualizar" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Editar
                        </button>
                        <?php if ($_SESSION["rol"] !== "Administrador"): ?>
                        <button type="submit" name="eliminar" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este empleado?')">
                            <i class="fas fa-trash"></i> Eliminar
                        </button>
                        <?php endif; ?>
                    </td>
                    <?php endif; ?>
                </form>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
