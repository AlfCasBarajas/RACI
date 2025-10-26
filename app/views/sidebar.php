<?php
// Solo iniciar sesión si no está ya iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user'])) {
    header('Location: ../../index.php');
    exit;
}
$user = $_SESSION['user'];
?>

<!-- Sidebar -->
<nav class="col-md-2 d-none d-md-block sidebar vh-100 position-fixed" style="z-index: 100;">
    <div class="sidebar-sticky pt-4">
        <div class="sidebar-user">
            <div style="position:relative;display:inline-block;">
                <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($user['usuario']); ?>&background=232f3e&color=ffd600&size=128" alt="Avatar" class="sidebar-avatar">
            </div>
            <span><?php echo htmlspecialchars($user['usuario']); ?></span>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item mb-2"><a class="nav-link" href="/RACI/app/views/dashboard.php"><i class="bi bi-house-door"></i>Dashboard</a></li>
            <li class="nav-item mb-2"><a class="nav-link" href="/RACI/?controller=roles&action=index"><i class="bi bi-person-badge"></i>Roles</a></li>
            <li class="nav-item mb-2"><a class="nav-link" href="/RACI/?controller=users&action=index"><i class="bi bi-people"></i>Usuarios</a></li>
            <li class="nav-item mb-2"><a class="nav-link" href="/RACI/?controller=empleados&action=index"><i class="bi bi-person-lines-fill"></i>Empleados</a></li>
            <li class="nav-item mb-2"><a class="nav-link" href="/RACI/?controller=areas&action=index"><i class="bi bi-building"></i>Áreas</a></li>
            <li class="nav-item mb-2"><a class="nav-link" href="/RACI/?controller=categorias&action=index"><i class="bi bi-folder2-open"></i>Categorías</a></li>
            <li class="nav-item mb-2"><a class="nav-link" href="/RACI/?controller=incidentes&action=index"><i class="bi bi-exclamation-triangle"></i>Incidentes</a></li>
            <li class="nav-item mb-2"><a class="nav-link" href="/RACI/?controller=accidentes&action=index"><i class="bi bi-activity"></i>Accidentes</a></li>
            <li class="nav-item mb-2"><a class="nav-link" href="/RACI/?controller=condicionesinseguras&action=index"><i class="bi bi-exclamation-diamond"></i>Condiciones Inseguras</a></li>
            <li class="nav-item mb-2"><a class="nav-link" href="/RACI/?controller=riesgos&action=index"><i class="bi bi-shield-check"></i>Riesgos</a></li>
            <li class="nav-item mb-2"><a class="nav-link" href="/RACI/?controller=inspeccionlocativa&action=index"><i class="bi bi-clipboard-check"></i>Inspecciones Locativas</a></li>
            <li class="nav-item mb-2"><a class="nav-link" href="/RACI/?controller=reportes&action=index"><i class="bi bi-file-earmark-text"></i>Reportes</a></li>
            <li class="nav-item mb-2"><a class="nav-link text-danger" href="/RACI/index.php"><i class="bi bi-box-arrow-right"></i>Cerrar sesión</a></li>
        </ul>
    </div>
</nav>