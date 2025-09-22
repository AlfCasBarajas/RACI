<h2>🔍 Inspección Locativa</h2>

<?php if ($_SESSION["rol"] !== "Trabajador"): ?>
<form method="POST" class="formulario">
    <input type="date" name="fecha" required>
    <textarea name="observacion" placeholder="Observación locativa" required></textarea>
    <select name="id_area" required>
        <option value="">Área</option>
        <?php foreach ($areas as $a): ?>
            <option value="<?= $a["id"] ?>"><?= $a["nombre"] ?></option>
        <?php endforeach; ?>
    </select>
    <button type="submit" name="crear">➕ Registrar Inspección</button>
</form>
<?php endif; ?>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Fecha</th>
            <th>Observación</th>
            <th>Área</th>
            <?php if ($_SESSION["rol"] !== "Trabajador"): ?>
            <th>Acciones</th>
            <?php endif; ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($inspecciones as $i): ?>
        <tr>
            <form method="POST">
                <td><?= $i["id"] ?></td>
                <td><input type="date" name="fecha" value="<?= $i["fecha"] ?>"></td>
                <td><textarea name="observacion"><?= $i["observacion"] ?></textarea></td>
                <td>
                    <select name="id_area">
                        <?php foreach ($areas as $a): ?>
                            <option value="<?= $a["id"] ?>" <?= $a["id"] == $i["id_area"] ? "selected" : "" ?>>
                                <?= $a["nombre"] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <?php if ($_SESSION["rol"] !== "Trabajador"): ?>
                <td>
                    <input type="hidden" name="id" value="<?= $i["id"] ?>">
                    <button type="submit" name="actualizar">✏️</button>
                    <?php if ($_SESSION["rol"] === "Administrador"): ?>
                    <button type="submit" name="eliminar" onclick="return confirm('¿Eliminar esta inspección?')">🗑️</button>
                    <?php endif; ?>
                </td>
                <?php endif; ?>
            </form>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
