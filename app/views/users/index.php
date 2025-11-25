<?php
if (isset($data) && is_array($data)) extract($data);
include __DIR__ . '/../header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <!-- Incluir sidebar -->
        <?php include __DIR__ . '/../sidebar.php'; ?>
        
        <!-- Contenido principal -->
        <main class="col-md-10 ms-sm-auto offset-md-2 px-4 main-content">
            <style>
              .users-title {
                color: #1a237e;
                font-weight: 700;
                border-bottom: 3px solid #ffd600;
                margin-bottom: 2rem;
                padding-bottom: 0.5rem;
              }
              .btn-users {
                background: #3949ab;
                color: #fff;
                border-radius: 2rem;
                font-weight: 600;
                border: 2px solid #ffd600;
                box-shadow: 0 2px 8px rgba(255,214,0,0.10);
                transition: background 0.2s, border 0.2s;
              }
              .btn-users:hover {
                background: #ffd600;
                color: #3949ab;
                border: 2px solid #3949ab;
              }
              .btn-users-outline {
                border: 2px solid #3949ab;
                color: #3949ab;
                background: #fff;
                border-radius: 2rem;
                font-weight: 600;
                transition: background 0.2s, color 0.2s, border 0.2s;
              }
              .btn-users-outline:hover {
                background: #3949ab;
                color: #fff;
                border: 2px solid #ffd600;
              }
              .users-card {
                border-radius: 1.2rem;
                box-shadow: 0 2px 12px rgba(30,40,90,0.10);
                background: #fff;
                border: none;
                padding: 2rem;
                margin-top: 2rem;
              }
              .users-actions {
                display: flex;
                gap: 0.5rem;
                justify-content: center;
                flex-wrap: wrap;
              }
            </style>

            <div class="users-card">
                <?php include __DIR__ . '/../messages.php'; ?>
                
                <div class="d-flex flex-column flex-lg-row align-items-center justify-content-center w-100 gap-5">
                    <div class="w-100" style="max-width:350px;">
                        <h2 class="users-title text-center"><i class="bi bi-people me-2"></i>Gestión de Usuarios</h2>
                        <form class="mb-3" method="get" action="">
                            <input type="hidden" name="controller" value="users">
                            <input type="hidden" name="action" value="index">
                            <div class="row g-2 mb-2">
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="filtro_doc" placeholder="Nº Documento" value="<?= isset($_GET['filtro_doc']) ? htmlspecialchars($_GET['filtro_doc']) : '' ?>">
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="filtro_usuario" placeholder="Usuario" value="<?= isset($_GET['filtro_usuario']) ? htmlspecialchars($_GET['filtro_usuario']) : '' ?>">
                                </div>
                                <div class="col-md-3">
                                    <select class="form-select" name="filtro_rol">
                                        <option value="">Todos los roles</option>
                                        <?php foreach ($roles as $rol): ?>
                                            <option value="<?= $rol['id_Rol'] ?>" <?= (isset($_GET['filtro_rol']) && $_GET['filtro_rol'] == $rol['id_Rol']) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($rol['nombre']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select class="form-select" name="orden">
                                        <option value="">Ordenar por</option>
                                        <option value="num_doc" <?= (isset($_GET['orden']) && $_GET['orden'] == 'num_doc') ? 'selected' : '' ?>>Nº Documento</option>
                                        <option value="usuario" <?= (isset($_GET['orden']) && $_GET['orden'] == 'usuario') ? 'selected' : '' ?>>Usuario</option>
                                        <option value="rol" <?= (isset($_GET['orden']) && $_GET['orden'] == 'rol') ? 'selected' : '' ?>>Rol</option>
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex gap-2 justify-content-between">
                                <button type="submit" class="btn btn-users-outline"><i class="bi bi-funnel"></i> Filtrar</button>
                                <a href="?controller=users&action=index" class="btn btn-secondary"><i class="bi bi-x-circle"></i> Limpiar</a>
                            </div>
                        </form>
                        <div class="text-center mb-3">
                            <?php if (!$isTrabajador): ?>
                                <a href="?controller=users&action=create" class="btn btn-users"><i class="bi bi-plus-circle me-1"></i>Nuevo Usuario</a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="w-100" style="max-width:700px;">
                        <div class="table-responsive">
                            <table class="table users-table align-middle mb-0 mx-auto" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th style="width: 80px;">Nº Doc</th>
                                        <th>Tipo Doc</th>
                                        <th>Usuario</th>
                                        <th>Teléfono</th>
                                        <th>Rol</th>
                                        <th style="width: 180px;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($usuarios as $usuario): ?>
                                    <tr>
                                        <td><span style="font-weight:700;color:#3949ab;"> <?= isset($usuario['num_doc']) ? htmlspecialchars($usuario['num_doc']) : '-' ?> </span></td>
                                        <td><?= isset($usuario['tipo_doc']) ? htmlspecialchars($usuario['tipo_doc']) : '-' ?></td>
                                        <td><span style="font-weight:600;color:#1a237e;background:#e3eafc;padding:0.2em 0.7em;border-radius:0.5em;box-shadow:0 2px 8px #3949ab22;"> <?= isset($usuario['usuario']) ? htmlspecialchars($usuario['usuario']) : '-' ?> </span></td>
                                        <td><?= isset($usuario['telefono']) ? htmlspecialchars($usuario['telefono']) : '-' ?></td>
                                        <td><?= isset($usuario['rol_nombre']) ? htmlspecialchars($usuario['rol_nombre']) : '-' ?></td>
                                        <td class="users-actions">
                                            <?php if (!$isCoordinador && !$isSupervisor && !$isTrabajador): ?>
                                                <a href="?controller=users&action=edit&id=<?= $usuario['num_doc'] ?>" class="btn btn-users-outline btn-sm"><i class="bi bi-pencil"></i> Editar</a>
                                                <a href="?controller=users&action=delete&id=<?= $usuario['num_doc'] ?>" class="btn btn-danger btn-sm" style="border-radius:2rem;font-weight:600;" onclick="return confirm('¿Seguro que deseas eliminar este usuario?')"><i class="bi bi-trash"></i> Eliminar</a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include __DIR__ . '/../footer.php'; ?>
