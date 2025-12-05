<?php
if (isset($data) && is_array($data)) extract($data);
include __DIR__ . '/../header.php';
?>

<div class="container-fluid">
    <div class="row">
        <?php include __DIR__ . '/../sidebar.php'; ?>
        <main class="col-md-10 ms-sm-auto offset-md-2 px-4 main-content">
            <div class="container py-5">
                <h2 class="mb-4 text-center" style="color: #1a237e; font-weight: 700; border-bottom: 3px solid #ffd600; padding-bottom: 0.5rem;">
                    <i class="bi bi-bar-chart me-2"></i>Módulo de Reportes
                </h2>
                
                <div class="row g-4 justify-content-center">
                    <!-- Reporte de Roles -->
                    <div class="col-md-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body text-center">
                                <i class="bi bi-person-badge display-4" style="color: #6f42c1;"></i>
                                <h5 class="card-title mt-2">Roles</h5>
                                <p class="card-text">Consulta y descarga el reporte de todos los roles del sistema</p>
                                <a href="?controller=reportes&action=roles" class="btn btn-primary w-100">Ver Reporte</a>
                            </div>
                        </div>
                    </div>

                    <!-- Reporte de Usuarios -->
                    <div class="col-md-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body text-center">
                                <i class="bi bi-people display-4 text-dark"></i>
                                <h5 class="card-title mt-2">Usuarios</h5>
                                <p class="card-text">Consulta y descarga el reporte de todos los usuarios registrados</p>
                                <a href="?controller=reportes&action=usuarios" class="btn btn-primary w-100">Ver Reporte</a>
                            </div>
                        </div>
                    </div>

                    <!-- Reporte de Empleados -->
                    <div class="col-md-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body text-center">
                                <i class="bi bi-person-lines-fill display-4 text-primary"></i>
                                <h5 class="card-title mt-2">Empleados</h5>
                                <p class="card-text">Consulta y descarga el reporte de todos los empleados registrados</p>
                                <a href="?controller=reportes&action=empleados" class="btn btn-primary w-100">Ver Reporte</a>
                            </div>
                        </div>
                    </div>

                    <!-- Reporte de Áreas -->
                    <div class="col-md-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body text-center">
                                <i class="bi bi-building display-4 text-info"></i>
                                <h5 class="card-title mt-2">Áreas</h5>
                                <p class="card-text">Consulta y descarga el reporte de todas las áreas registradas</p>
                                <a href="?controller=reportes&action=areas" class="btn btn-primary w-100">Ver Reporte</a>
                            </div>
                        </div>
                    </div>

                    <!-- Reporte de Categorías -->
                    <div class="col-md-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body text-center">
                                <i class="bi bi-folder2-open display-4 text-success"></i>
                                <h5 class="card-title mt-2">Categorías</h5>
                                <p class="card-text">Consulta y descarga el reporte de todas las categorías registradas</p>
                                <a href="?controller=reportes&action=categorias" class="btn btn-primary w-100">Ver Reporte</a>
                            </div>
                        </div>
                    </div>

                    <!-- Reporte de Incidentes -->
                    <div class="col-md-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body text-center">
                                <i class="bi bi-exclamation-triangle display-4 text-warning"></i>
                                <h5 class="card-title mt-2">Incidentes</h5>
                                <p class="card-text">Consulta y descarga el reporte de todos los incidentes registrados</p>
                                <a href="?controller=reportes&action=incidentes" class="btn btn-primary w-100">Ver Reporte</a>
                            </div>
                        </div>
                    </div>

                    <!-- Reporte de Accidentes -->
                    <div class="col-md-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body text-center">
                                <i class="bi bi-activity display-4 text-danger"></i>
                                <h5 class="card-title mt-2">Accidentes</h5>
                                <p class="card-text">Consulta y descarga el reporte de todos los accidentes registrados</p>
                                <a href="?controller=reportes&action=accidentes" class="btn btn-primary w-100">Ver Reporte</a>
                            </div>
                        </div>
                    </div>

                    <!-- Reporte de Condiciones Inseguras -->
                    <div class="col-md-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body text-center">
                                <i class="bi bi-exclamation-diamond display-4 text-warning"></i>
                                <h5 class="card-title mt-2">Condiciones Inseguras</h5>
                                <p class="card-text">Consulta y descarga el reporte de condiciones inseguras identificadas</p>
                                <a href="?controller=reportes&action=condicionesinseguras" class="btn btn-primary w-100">Ver Reporte</a>
                            </div>
                        </div>
                    </div>

                    <!-- Reporte de Riesgos -->
                    <div class="col-md-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body text-center">
                                <i class="bi bi-shield-check display-4 text-secondary"></i>
                                <h5 class="card-title mt-2">Riesgos</h5>
                                <p class="card-text">Consulta y descarga el reporte de todos los riesgos identificados</p>
                                <a href="?controller=reportes&action=riesgos" class="btn btn-primary w-100">Ver Reporte</a>
                            </div>
                        </div>
                    </div>

                    <!-- Reporte de Inspecciones Locativas -->
                    <div class="col-md-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body text-center">
                                <i class="bi bi-clipboard-check display-4 text-primary"></i>
                                <h5 class="card-title mt-2">Inspecciones Locativas</h5>
                                <p class="card-text">Consulta y descarga el reporte de todas las inspecciones locativas</p>
                                <a href="?controller=reportes&action=inspecciones" class="btn btn-primary w-100">Ver Reporte</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-5">
                    <a href="/RACI/app/views/dashboard.php" class="btn btn-dark">
                        <i class="bi bi-arrow-left me-2"></i>Volver al Inicio
                    </a>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include __DIR__ . '/../footer.php'; ?>
