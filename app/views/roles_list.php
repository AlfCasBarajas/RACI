<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Roles</title>
</head>
<body>
    <h1>Lista de Roles</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
        </tr>
        <?php foreach ($roles as $rol): ?>
        <tr>
            <td><?php echo htmlspecialchars($rol['id_Rol']); ?></td>
            <td><?php echo htmlspecialchars($rol['nombre']); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <!-- Botones para crear, editar y eliminar roles se agregarán después -->
</body>
</html>
