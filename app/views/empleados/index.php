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
                .empleados-card {
                    border-radius: 1.2rem;
                    box-shadow: 0 2px 12px rgba(30,40,90,0.10);
                    background: #fff;
                    border: none;
                    padding: 2rem;
                    margin-top: 2rem;
                }
                .empleados-title {
                    color: #1a237e;
                    font-weight: 700;
                    border-bottom: 3px solid #ffd600;
                    margin-bottom: 2rem;
                    padding-bottom: 0.5rem;
                }
                .btn-empleados {
                    background: #3949ab;
                    color: #fff;
                    border-radius: 2rem;
                    font-weight: 600;
                    border: 2px solid #ffd600;
                    transition: background 0.2s, border 0.2s;
                }
                .btn-empleados:hover {
                    background: #ffd600;
                    color: #3949ab;
                    border: 2px solid #3949ab;
                }
                .btn-empleados-outline {
                    border: 2px solid #3949ab;
                    color: #3949ab;
                    background: #fff;
                    border-radius: 2rem;
                    font-weight: 600;
                    transition: background 0.2s, color 0.2s;
                }
                .btn-empleados-outline:hover {
                    background: #3949ab;
                    color: #fff;
                    border: 2px solid #ffd600;
                }
            </style>

            <div class="empleados-card">
                <div class="d-flex flex-column flex-lg-row align-items-center justify-content-center w-100 gap-5">
                    <div class="w-100" style="max-width:350px;">
                        <h2 class="empleados-title text-center"><i class="bi bi-person-lines-fill me-2"></i>Gestión de Empleados</h2>
                        
                        <!-- Mensajes de éxito y error -->
                        <?php if (isset($_SESSION['success'])): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle me-2"></i><?= $_SESSION['success'] ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                            <?php unset($_SESSION['success']); ?>
                        <?php endif; ?>
                        
                        <?php if (isset($_SESSION['error'])): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                <div><?= nl2br(htmlspecialchars($_SESSION['error'])) ?></div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                            <?php unset($_SESSION['error']); ?>
                        <?php endif; ?>
                        
                        <form method="get" action="" class="mb-3">
                            <input type="hidden" name="controller" value="empleados">
                            <input type="hidden" name="action" value="index">
                            <div class="row g-2 mb-2">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="filtro_tipo_doc" placeholder="Tipo Doc" value="<?= isset($_GET['filtro_tipo_doc']) ? htmlspecialchars($_GET['filtro_tipo_doc']) : '' ?>">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="filtro_nombre" placeholder="Nombre" value="<?= isset($_GET['filtro_nombre']) ? htmlspecialchars($_GET['filtro_nombre']) : '' ?>">
                                </div>
                                <div class="col-md-6">
                                    <select class="form-select" name="filtro_rol">
                                        <option value="">Rol</option>
                                        <?php foreach ($roles as $rol): ?>
                                            <option value="<?= $rol['id_Rol'] ?>" <?= (isset($_GET['filtro_rol']) && $_GET['filtro_rol'] == $rol['id_Rol']) ? 'selected' : '' ?>><?= htmlspecialchars($rol['nombre']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <select class="form-select" name="orden">
                                        <option value="">Ordenar por</option>
                                        <option value="tipo_doc" <?= (isset($_GET['orden']) && $_GET['orden'] == 'tipo_doc') ? 'selected' : '' ?>>Tipo Doc</option>
                                        <option value="nombres" <?= (isset($_GET['orden']) && $_GET['orden'] == 'nombres') ? 'selected' : '' ?>>Nombre</option>
                                        <option value="rol" <?= (isset($_GET['orden']) && $_GET['orden'] == 'rol') ? 'selected' : '' ?>>Rol</option>
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex gap-2 justify-content-between">
                                <button type="submit" class="btn btn-empleados-outline"><i class="bi bi-funnel"></i> Filtrar</button>
                                <a href="?controller=empleados&action=index" class="btn btn-secondary"><i class="bi bi-x-circle"></i> Limpiar</a>
                            </div>
                        </form>
                        <div class="text-center">
                            <?php if (!$isTrabajador): ?>
                                <a href="?controller=empleados&action=create" class="btn btn-empleados w-100"><i class="bi bi-plus-circle me-1"></i>Nuevo Empleado</a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="w-100" style="max-width:800px;">
                        <div class="table-responsive">
                            <table class="table align-middle table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Tipo Doc</th>
                                        <th>Nombres</th>
                                        <th>Apellidos</th>
                                        <th>Rol</th>
                                        <th>Teléfono</th>
                                        <th>Cargo</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($empleados as $empleado): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($empleado['id_empleado']) ?></td>
                                        <td><?= htmlspecialchars($empleado['tipo_doc']) ?></td>
                                        <td><?= htmlspecialchars($empleado['nombres']) ?></td>
                                        <td><?= htmlspecialchars($empleado['apellidos']) ?></td>
                                        <td><?= htmlspecialchars($empleado['rol_nombre']) ?></td>
                                        <td><?= htmlspecialchars($empleado['telefono']) ?></td>
                                        <td><?= htmlspecialchars($empleado['cargo_funcion']) ?></td>
                                        <td>
                                            <?php if (!$isCoordinador && !$isSupervisor && !$isTrabajador): ?>
                                                <a href="?controller=empleados&action=edit&id=<?= $empleado['id_empleado'] ?>" class="btn btn-empleados-outline btn-sm me-2" title="Editar"><i class="bi bi-pencil"></i></a>
                                                <a href="?controller=empleados&action=delete&id=<?= $empleado['id_empleado'] ?>" class="btn btn-danger btn-sm" title="Eliminar" onclick="return confirm('¿Seguro que deseas eliminar este empleado?');" style="border-radius:2rem;"><i class="bi bi-trash"></i></a>
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
