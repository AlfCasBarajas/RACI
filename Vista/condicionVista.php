<h2>🚧 Condiciones Inseguras</h2>

<?php if ($_SESSION["rol"] !== "Trabajador"): ?>
<form method="POST" class="formulario">
    <input type="text" name="nombre">
    <textarea name="descripcion" placeholder="Descripción de la condición" required></textarea>
    <select name="id_area" required>
        <option value="">Área</option>
        <?php foreach ($areas as $a): ?>
            <option value="<?= $a["id_area"] ?>"><?= $a["nombre"] ?></option>
        <?php endforeach; ?>
    </select>
    <button type="submit" name="crear">➕ Reportar Condición</button>
</form>
<?php endif; ?>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Fecha</th>
            <th>Descripción</th>
            <th>Área</th>
            <?php if ($_SESSION["rol"] !== "Trabajador"): ?>
            <th>Acciones</th>
            <?php endif; ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($condiciones as $c): ?>
        <tr>
            <form method="POST">
                <td><?= $c["id_cond_inseg"] ?></td>
                <td><input type="text" name="nombre" value="<?= $c["nombre"] ?>"></td>
                <td><textarea name="descripcion"><?= $c["descripcion"] ?></textarea></td>
                <td>
                    <select name="id_area">
                        <?php foreach ($areas as $a): ?>
                            <option value="<?= $a["id_area"] ?>" <?= $a["id_area"] == $c["id_cond_inseg"] ? "selected" : "" ?>>
                                <?= $a["nombre"] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <?php if ($_SESSION["rol"] !== "Trabajador"): ?>
                <td>
                    <input type="hidden" name="id" value="<?= $c["id_cond_inseg"] ?>">
                    <button type="submit" name="actualizar">✏️</button>
                    <?php if ($_SESSION["rol"] !== "Administrador"): ?>
                    <button type="submit" name="eliminar" onclick="return confirm('¿Eliminar esta condición?')">🗑️</button>
                    <?php endif; ?>
                </td>
                <?php endif; ?>
            </form>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
