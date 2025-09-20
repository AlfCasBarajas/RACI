<!DOCTYPE html>
<html>
<head><title>Crear Usuario</title></head>
<body>
<h1>Nuevo Usuario</h1>
<form method="POST" action="?controller=user&action=store">
    <label>Documento: <input name="num_doc" required></label><br>
    <label>Tipo Doc: <input name="tipo_doc" required></label><br>
    <label>Nombres: <input name="nombres" required></label><br>
    <label>Apellidos: <input name="apellidos" required></label><br>
    <label>Rol:
        <select name="rol" required>
            <?php foreach ($roles as $role): ?>
                <option value="<?= $role['id_Rol'] ?>"><?= $role['nombre'] ?></option>
            <?php endforeach; ?>
        </select>
    </label><br>
    <label>Contraseña: <input type="password" name="contrasena" required></label><br>
    <label>Teléfono: <input name="telefono"></label><br>
    <button type="submit">Guardar</button>
</form>
</body>
</html>
