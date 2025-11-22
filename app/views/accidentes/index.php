<?php if (isset($data) && is_array($data)) extract($data); include __DIR__ . '/../header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <!-- Incluir sidebar -->
        <?php include __DIR__ . '/../sidebar.php'; ?>
        
        <!-- Contenido principal -->
        <main class="col-md-10 ms-sm-auto offset-md-2 px-4 main-content">
            <style>
                .accidentes-card {
                    border-radius: 1.2rem;
                    box-shadow: 0 2px 12px rgba(30,40,90,0.10);
                    background: #fff;
                    border: none;
                    padding: 2rem;
                    margin-top: 2rem;
                }
                .accidentes-title {
                    color: #b71c1c;
                    font-weight: 700;
                    border-bottom: 3px solid #ffd600;
                    margin-bottom: 2rem;
                    padding-bottom: 0.5rem;
                }
                .btn-accidentes {
                    background: #b71c1c;
                    color: #fff;
                    border-radius: 2rem;
                    font-weight: 600;
                    border: 2px solid #ffd600;
                    transition: background 0.2s, border 0.2s;
                }
                .btn-accidentes:hover {
                    background: #ffd600;
                    color: #b71c1c;
                    border: 2px solid #b71c1c;
                }
                .btn-accidentes-outline {
                    border: 2px solid #b71c1c;
                    color: #b71c1c;
                    background: #fff;
                    border-radius: 2rem;
                    font-weight: 600;
                    transition: background 0.2s, color 0.2s;
                }
                .btn-accidentes-outline:hover {
                    background: #b71c1c;
                    color: #fff;
                    border: 2px solid #ffd600;
                }
            </style>

            <div class="accidentes-card">
                <h2 class="accidentes-title text-center"><i class="bi bi-activity me-2"></i>Gestión de Accidentes</h2>
                
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
                
                <div class="row mb-3">
                    <div class="col-md-8">
                        <form method="get" action="" class="row g-2">
                            <input type="hidden" name="controller" value="accidentes">
                            <input type="hidden" name="action" value="index">
                            <div class="col-md-3">
                                <input type="number" class="form-control" name="filtro_id" placeholder="ID" value="<?= isset($_GET['filtro_id']) ? htmlspecialchars($_GET['filtro_id']) : '' ?>">
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="filtro_tipo" placeholder="Tipo" value="<?= isset($_GET['filtro_tipo']) ? htmlspecialchars($_GET['filtro_tipo']) : '' ?>">
                            </div>
                            <div class="col-md-3">
                                <input type="date" class="form-control" name="filtro_fecha" value="<?= isset($_GET['filtro_fecha']) ? htmlspecialchars($_GET['filtro_fecha']) : '' ?>">
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="filtro_lugar" placeholder="Lugar" value="<?= isset($_GET['filtro_lugar']) ? htmlspecialchars($_GET['filtro_lugar']) : '' ?>">
                            </div>
                            <div class="col-md-3">
                                <select class="form-select" name="filtro_area">
                                    <option value="">Todas las áreas</option>
                                    <?php if (isset($areas)): ?>
                                        <?php foreach ($areas as $area): ?>
                                            <option value="<?= $area['id_area'] ?>" <?= (isset($filtro_area) && $filtro_area == $area['id_area']) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($area['nombre']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <select class="form-select" name="filtro_orden">
                                    <option value="id_asc" <?= (isset($filtro_orden) && $filtro_orden == 'id_asc') ? 'selected' : '' ?>>ID (Asc)</option>
                                    <option value="id_desc" <?= (isset($filtro_orden) && $filtro_orden == 'id_desc') ? 'selected' : '' ?>>ID (Desc)</option>
                                    <option value="tipo_asc" <?= (isset($filtro_orden) && $filtro_orden == 'tipo_asc') ? 'selected' : '' ?>>Tipo (A-Z)</option>
                                    <option value="tipo_desc" <?= (isset($filtro_orden) && $filtro_orden == 'tipo_desc') ? 'selected' : '' ?>>Tipo (Z-A)</option>
                                    <option value="area_asc" <?= (isset($filtro_orden) && $filtro_orden == 'area_asc') ? 'selected' : '' ?>>Área (A-Z)</option>
                                    <option value="area_desc" <?= (isset($filtro_orden) && $filtro_orden == 'area_desc') ? 'selected' : '' ?>>Área (Z-A)</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-accidentes-outline"><i class="bi bi-funnel"></i> Filtrar</button>
                                    <a href="?controller=accidentes&action=index" class="btn btn-secondary"><i class="bi bi-x-circle"></i> Limpiar</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-4 text-end">
                        <?php if (!$isTrabajador): ?>
                            <a href="?controller=accidentes&action=create" class="btn btn-accidentes"><i class="bi bi-plus-circle me-1"></i>Nuevo Accidente</a>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="table-responsive">
                    <?php if (!empty($accidentes)): ?>
                        <?php foreach ($accidentes as $acc): ?>
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="row g-2">
                                        <div class="col-md-6"><strong>ID:</strong></div><div class="col-md-6"><?= htmlspecialchars($acc['id_accidente']) ?></div>
                                        <div class="col-md-6"><strong>Tipo:</strong></div><div class="col-md-6"><?= htmlspecialchars($acc['tipo']) ?></div>
                                        <div class="col-md-6"><strong>Área:</strong></div><div class="col-md-6"><?= htmlspecialchars($acc['nombre_area']) ?></div>
                                        <div class="col-md-6"><strong>Descripción:</strong></div><div class="col-md-6"><?= htmlspecialchars($acc['descripcion']) ?></div>
                                        <div class="col-md-6"><strong>Clasificación:</strong></div><div class="col-md-6"><?= htmlspecialchars($acc['clasificacion']) ?></div>
                                        <div class="col-md-6"><strong>Estado:</strong></div><div class="col-md-6"><?= htmlspecialchars($acc['estado']) ?></div>
                                        <div class="col-md-6"><strong>Fecha y Hora:</strong></div><div class="col-md-6"><?= htmlspecialchars($acc['fecha_hora']) ?></div>
                                        <div class="col-md-6"><strong>Lugar:</strong></div><div class="col-md-6"><?= htmlspecialchars($acc['lugar']) ?></div>
                                        <div class="col-md-6"><strong>Tipo Vinculación Laboral:</strong></div><div class="col-md-6"><?= htmlspecialchars($acc['tipo_vinc_lab_']) ?></div>
                                        <div class="col-md-6"><strong>Jornada Laboral:</strong></div><div class="col-md-6"><?= htmlspecialchars($acc['jornada_laboral']) ?></div>
                                        <div class="col-md-6"><strong>Turno Momento Accidente:</strong></div><div class="col-md-6"><?= htmlspecialchars($acc['turno_mom_acc']) ?></div>
                                        <div class="col-md-6"><strong>Uso EPP:</strong></div><div class="col-md-6"><?= htmlspecialchars($acc['uso_epp']) ?></div>
                                        <div class="col-md-6"><strong>Consecuencias:</strong></div><div class="col-md-6"><?= htmlspecialchars($acc['consecuencias']) ?></div>
                                        <div class="col-md-6"><strong>Gravedad:</strong></div><div class="col-md-6"><?= htmlspecialchars($acc['gravedad']) ?></div>
                                        <div class="col-md-6"><strong>Tipo Lesión:</strong></div><div class="col-md-6"><?= htmlspecialchars($acc['tipo_lesion']) ?></div>
                                        <div class="col-md-6"><strong>Parte Cuerpo Afectada:</strong></div><div class="col-md-6"><?= htmlspecialchars($acc['parte_cuerpo_afect']) ?></div>
                                        <div class="col-md-6"><strong>Incapacidad Laboral:</strong></div><div class="col-md-6"><?= htmlspecialchars($acc['incapacidad_lab']) ?></div>
                                        <div class="col-md-6"><strong>Atención Médica Recibida:</strong></div><div class="col-md-6"><?= htmlspecialchars($acc['aten_med_recibida']) ?></div>
                                        <div class="col-md-6"><strong>Persona que Informó:</strong></div><div class="col-md-6"><?= htmlspecialchars($acc['persona_informo']) ?></div>
                                    </div>
                                    <div class="mt-3 text-end">
                                        <?php if (!$isTrabajador): ?>
                                            <a href="?controller=accidentes&action=edit&id=<?= $acc['id_accidente'] ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i> Editar</a>
                                        <?php endif; ?>
                                        <?php if (!$isCoordinador && !$isSupervisor && !$isTrabajador): ?>
                                            <a href="?controller=accidentes&action=delete&id=<?= $acc['id_accidente'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro de eliminar?')"><i class="bi bi-trash"></i> Eliminar</a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="alert alert-info text-center">No hay accidentes registrados.</div>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include __DIR__ . '/../footer.php'; ?>
