<h2>🩺 Gestión de Accidentes</h2>

<?php if ($_SESSION["rol"] !== "Trabajador"): ?>
<form method="POST" class="formulario">
    <input type="date" name="fecha" required>
    <textarea name="descripcion" placeholder="Descripción del accidente" required></textarea>
    <select name="id_empleado" required>
        <option value="">Empleado</option>
        <?php foreach ($empleados as $e): ?>
            <option value="<?= $e["id_empleado"] ?>"><?= $e["nombres"] ?></option>
        <?php endforeach; ?>
    </select>
    <select name="id_area" required>
        <option value="">Área</option>
        <?php foreach ($areas as $a): ?>
            <option value="<?= $a["id_area"] ?>"><?= $a["nombre"] ?></option>
        <?php endforeach; ?>
    </select>
    <button type="submit" name="crear">➕ Registrar Accidente</button>
</form>
<?php endif; ?>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Fecha</th>
            <th>Descripción</th>
            <th>Empleado</th>
            <th>Área</th>
            <?php if ($_SESSION["rol"] !== "Trabajador"): ?>
            <th>Acciones</th>
            <?php endif; ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($accidentes as $a): ?>
        <tr>
            <form method="POST">
                <td><?= $a["id_accidente"] ?></td>
                <td><input type="date" name="fecha" value="<?= $a["fecha"] ?>"></td>
                <td><textarea name="descripcion"><?= $a["descripcion"] ?></textarea></td>
                <td>
                    <select name="id_empleado">
                        <?php foreach ($empleados as $e): ?>
                            <option value="<?= $e["id_empleado"] ?>" <?= $e["id_empleado"] == $a["id_accidente"] ? "selected" : "" ?>>
                                <?= $e["nombres"] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td>
                    <select name="id_area">
                        <?php foreach ($areas as $ar): ?>
                            <option value="<?= $ar["id_area"] ?>" <?= $ar["id_area"] == $a["id_accidente"] ? "selected" : "" ?>>
                                <?= $ar["nombre"] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <?php if ($_SESSION["rol"] !== "Trabajador"): ?>
                <td>
                    <input type="hidden" name="id" value="<?= $a["id_accidente"] ?>">
                    <button type="submit" name="actualizar">✏️</button>
                    <?php if ($_SESSION["rol"] === "Administrador"): ?>
                    <button type="submit" name="eliminar" onclick="return confirm('¿Eliminar este accidente?')">🗑️</button>
                    <?php endif; ?>
                </td>
                <?php endif; ?>
            </form>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
