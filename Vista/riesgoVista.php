<h2>⚠️ Evaluación de Riesgos</h2>

<?php if ($_SESSION["rol"] !== "Trabajador"): ?>
<form method="POST" class="formulario">
    <textarea name="descripcion" placeholder="Descripción del riesgo" required></textarea>
    <select name="nivel" required>
        <option value="">Nivel de riesgo</option>
        <option value="Bajo">Bajo</option>
        <option value="Medio">Medio</option>
        <option value="Alto">Alto</option>
    </select>
    <select name="id_area" required>
        <option value="">Área</option>
        <?php foreach ($areas as $a): ?>
            <option value="<?= $a["id"] ?>"><?= $a["nombre"] ?></option>
        <?php endforeach; ?>
    </select>
    <select name="id_categoria" required>
        <option value="">Categoría</option>
        <?php foreach ($categorias as $c): ?>
            <option value="<?= $c["id"] ?>"><?= $c["nombre"] ?></option>
        <?php endforeach; ?>
    </select>
    <button type="submit" name="crear">➕ Registrar Riesgo</button>
</form>
<?php endif; ?>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Descripción</th>
            <th>Nivel</th>
            <th>Área</th>
            <th>Categoría</th>
            <?php if ($_SESSION["rol"] !== "Trabajador"): ?>
            <th>Acciones</th>
            <?php endif; ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($riesgos as $r): ?>
        <tr>
            <form method="POST">
                <td><?= $r["id"] ?></td>
                <td><textarea name="descripcion"><?= $r["descripcion"] ?></textarea></td>
                <td>
                    <select name="nivel">
                        <option value="Bajo" <?= $r["nivel"] == "Bajo" ? "selected" : "" ?>>Bajo</option>
                        <option value="Medio" <?= $r["nivel"] == "Medio" ? "selected" : "" ?>>Medio</option>
                        <option value="Alto" <?= $r["nivel"] == "Alto" ? "selected" : "" ?>>Alto</option>
                    </select>
                </td>
                <td>
                    <select name="id_area">
                        <?php foreach ($areas as $a): ?>
                            <option value="<?= $a["id"] ?>" <?= $a["id"] == $r["id_area"] ? "selected" : "" ?>>
                                <?= $a["nombre"] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td>
                    <select name="id_categoria">
                        <?php foreach ($categorias as $c): ?>
                            <option value="<?= $c["id"] ?>" <?= $c["id"] == $r["id_categoria"] ? "selected" : "" ?>>
                                <?= $c["nombre"] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <?php if ($_SESSION["rol"] !== "Trabajador"): ?>
                <td>
                    <input type="hidden" name="id" value="<?= $r["id"] ?>">
                    <button type="submit" name="actualizar">✏️</button>
                    <?php if ($_SESSION["rol"] === "Administrador"): ?>
                    <button type="submit" name="eliminar" onclick="return confirm('¿Eliminar este riesgo?')">🗑️</button>
                    <?php endif; ?>
                </td>
                <?php endif; ?>
            </form>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
