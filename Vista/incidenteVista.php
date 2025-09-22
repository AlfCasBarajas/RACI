<h2>⚠️ Gestión de Incidentes</h2>

<?php if ($_SESSION["rol"] !== "Trabajador"): ?>
<form method="POST" class="formulario">
    <input type="date" name="fecha" required>
    <textarea name="descripcion" placeholder="Descripción del incidente" required></textarea>
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
    <button type="submit" name="crear">➕ Registrar Incidente</button>
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
        <?php foreach ($incidentes as $i): ?>
        <tr>
            <form method="POST">
                <td><?= $i["id_incidente"] ?></td>
                <td><input type="date" name="fecha" value="<?= $i["fecha_hora"] ?>"></td>
                <td><textarea name="descripcion"><?= $i["descripcion"] ?></textarea></td>
                <td>
                    <select name="id_empleado">
                        <?php foreach ($empleados as $e): ?>
                            <option value="<?= $e["id_empleado"] ?>" <?= $e["id_empleado"] == $i["id_incidente"] ? "selected" : "" ?>>
                                <?= $e["nombres"] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td>
                    <select name="id_area">
                        <?php foreach ($areas as $a): ?>
                            <option value="<?= $a["id_area"] ?>" <?= $a["id_area"] == $i["id_incidente"] ? "selected" : "" ?>>
                                <?= $a["nombre"] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <?php if ($_SESSION["rol"] !== "Trabajador"): ?>
                <td>
                    <input type="hidden" name="id" value="<?= $i["id_incidente"] ?>">
                    <button type="submit" name="actualizar">✏️</button>
                    <?php if ($_SESSION["rol"] === "Administrador"): ?>
                    <button type="submit" name="eliminar" onclick="return confirm('¿Eliminar este incidente?')">🗑️</button>
                    <?php endif; ?>
                </td>
                <?php endif; ?>
            </form>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
