<!DOCTYPE html>
<html>
<head><title>Lista de Usuarios</title></head>
<body>
<h1>Usuarios</h1>
<a href="?controller=user&action=create">Crear Usuario</a>
<table border="1">
    <tr>
        <th>Documento</th><th>Nombre</th><th>Rol</th><th>Acciones</th>
    </tr>
    <?php foreach ($users as $user): ?>
        <tr>
            <td><?= $user['num_doc'] ?></td>
            <td><?= $user['nombres'] . ' ' . $user['apellidos'] ?></td>
            <td><?= $user['rol_nombre'] ?></td>
            <td>
                <a href="?controller=user&action=delete&id=<?= $user['num_doc'] ?>">Eliminar</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
</body>
</html>
