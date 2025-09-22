<!-- Barra de navegación horizontal -->
<nav class="navbar navbar-expand-lg navbar-dark" style="background: #1a237e;">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Logo" class="me-2" style="height:40px;">
            RACI SST
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="#servicios">Servicios</a></li>
                <li class="nav-item"><a class="nav-link" href="#contacto">Contacto</a></li>
                <li class="nav-item"><a class="nav-link" href="/RACI/?controller=roles&action=index">Roles</a></li>
                <li class="nav-item"><a class="nav-link" href="../../index.php">Cerrar sesión</a></li>
            </ul>
        </div>
    </div>
</nav>
<?php
session_start();
if (!isset($_SESSION['user'])) {
                header('Location: ../../index.php');
                exit;
}
$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
                <meta charset="UTF-8">
                <title>Dashboard RACI</title>
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
                <style>
                                body { background: #f8f9fa; }
                                .navbar {
                                                background: #1a237e;
                                }
                                .navbar-brand img {
                                                height: 40px;
                                }
                                .service-card {
                                                border: none;
                                                border-radius: 1rem;
                                                box-shadow: 0 2px 8px rgba(30,40,90,0.08);
                                                transition: transform 0.2s;
                                }
                                .service-card:hover {
                                                transform: translateY(-5px) scale(1.03);
                                                box-shadow: 0 4px 16px rgba(30,40,90,0.15);
                                }
                                .service-icon {
                                                font-size: 2.5rem;
                                                color: #1a237e;
                                }
                                .footer {
                                                background: #232f3e;
                                                color: #fff;
                                                padding: 30px 0 10px 0;
                                }
                                .footer a { color: #90caf9; text-decoration: none; }
                                .footer a:hover { text-decoration: underline; }
                </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- Barra lateral -->
        <nav class="col-md-2 d-none d-md-block bg-light sidebar vh-100 position-fixed" style="z-index: 100;">
            <div class="sidebar-sticky pt-4">
                <ul class="nav flex-column">
                    <li class="nav-item mb-2"><a class="nav-link text-dark" href="/RACI/?controller=inspeccionlocativa&action=index"><i class="bi bi-clipboard-check me-2"></i>Inspección Locativa</a></li>
                    <li class="nav-item mb-2"><a class="nav-link text-dark" href="/RACI/?controller=categorias&action=index"><i class="bi bi-folder2-open me-2"></i>Categorías</a></li>
                    <li class="nav-item mb-2"><a class="nav-link text-dark" href="/RACI/?controller=incidentes&action=index"><i class="bi bi-exclamation-triangle me-2"></i>Incidente</a></li>
                    <li class="nav-item mb-2"><a class="nav-link text-dark" href="/RACI/?controller=accidentes&action=index"><i class="bi bi-activity me-2"></i>Accidente</a></li>
                    <li class="nav-item mb-2"><a class="nav-link text-dark" href="/RACI/?controller=riesgos&action=index"><i class="bi bi-shield-check me-2"></i>Riesgo</a></li>
                    <li class="nav-item mb-2"><a class="nav-link text-dark" href="/RACI/?controller=roles&action=index"><i class="bi bi-person-badge me-2"></i>Roles</a></li>
                    <li class="nav-item mb-2"><a class="nav-link text-dark" href="/RACI/?controller=users&action=index"><i class="bi bi-people me-2"></i>Usuarios</a></li>
                    <li class="nav-item mb-2"><a class="nav-link text-dark" href="/RACI/?controller=areas&action=index"><i class="bi bi-building me-2"></i>Áreas</a></li>
                    <li class="nav-item mb-2"><a class="nav-link text-dark" href="/RACI/?controller=empleados&action=index"><i class="bi bi-person-lines-fill me-2"></i>Empleados</a></li>
                    <li class="nav-item mb-2"><a class="nav-link text-dark" href="/RACI/?controller=condicionesinseguras&action=index"><i class="bi bi-exclamation-diamond me-2"></i>Condición Insegura</a></li>
                    <li class="nav-item mb-2"><a class="nav-link text-dark" href="/RACI/?controller=reportes&action=index"><i class="bi bi-file-earmark-text me-2"></i>Reporte</a></li>
                    <li class="nav-item mb-2"><a class="nav-link text-danger" href="../../index.php"><i class="bi bi-box-arrow-right me-2"></i>Cerrar sesión</a></li>
                </ul>
            </div>
        </nav>
        <!-- Contenido principal -->
        <main class="col-md-10 ms-sm-auto offset-md-2 px-4">
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user'])) {
    header('Location: ../../index.php');
    exit;
}
$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
        <meta charset="UTF-8">
        <title>Dashboard RACI</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
        <style>
                body { background: #f8f9fa; }
                .navbar {
                        background: #1a237e;
                }
                .navbar-brand img {
                        height: 40px;
                }
                .service-card {
                        border: none;
                        border-radius: 1rem;
                        box-shadow: 0 2px 8px rgba(30,40,90,0.08);
                        transition: transform 0.2s;
                }
                .service-card:hover {
                        transform: translateY(-5px) scale(1.03);
                        box-shadow: 0 4px 16px rgba(30,40,90,0.15);
                }
                .service-icon {
                        font-size: 2.5rem;
                        color: #1a237e;
                }
                .footer {
                        background: #232f3e;
                        color: #fff;
                        padding: 30px 0 10px 0;
                }
                .footer a { color: #90caf9; text-decoration: none; }
                .footer a:hover { text-decoration: underline; }
        </style>
</head>
<body>


<!-- Sección principal -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="row align-items-center mb-5">
            <div class="col-md-7">
                <h1 class="display-5 fw-bold text-primary mb-3">Bienvenido, <?php echo htmlspecialchars($user['nombres']); ?>!</h1>
                <p class="lead text-secondary">Somos expertos en Seguridad y Salud en el Trabajo. Protegemos a tu empresa y a tus colaboradores con soluciones integrales, asesoría y cumplimiento normativo.</p>
            </div>
            <div class="col-md-5 text-center">
                <img src="https://cdn-icons-png.flaticon.com/512/2920/2920061.png" alt="SST" class="img-fluid" style="max-height: 180px;">
            </div>
        </div>
            <h2 class="text-center mb-4" id="servicios">Gestiones</h2>
            <div class="row justify-content-center g-3">
                <div class="col-6 col-md-2">
                    <a href="#" class="btn btn-light border w-100 py-3 shadow-sm d-flex flex-column align-items-center">
                        <i class="bi bi-clipboard-check fs-2 mb-1 text-primary"></i>
                        <span>Inspección Locativa</span>
                    </a>
                </div>
                <div class="col-6 col-md-2">
                    <a href="#" class="btn btn-light border w-100 py-3 shadow-sm d-flex flex-column align-items-center">
                        <i class="bi bi-folder2-open fs-2 mb-1 text-primary"></i>
                        <span>Categoría</span>
                    </a>
                </div>
                <div class="col-6 col-md-2">
                    <a href="#" class="btn btn-light border w-100 py-3 shadow-sm d-flex flex-column align-items-center">
                        <i class="bi bi-exclamation-triangle fs-2 mb-1 text-primary"></i>
                        <span>Incidente</span>
                    </a>
                </div>
                <div class="col-6 col-md-2">
                    <a href="#" class="btn btn-light border w-100 py-3 shadow-sm d-flex flex-column align-items-center">
                        <i class="bi bi-activity fs-2 mb-1 text-primary"></i>
                        <span>Accidente</span>
                    </a>
                </div>
                <div class="col-6 col-md-2">
                    <a href="#" class="btn btn-light border w-100 py-3 shadow-sm d-flex flex-column align-items-center">
                        <i class="bi bi-shield-check fs-2 mb-1 text-primary"></i>
                        <span>Riesgo</span>
                    </a>
                </div>
                <div class="col-6 col-md-2">
                    <a href="/RACI/?controller=roles&action=index" class="btn btn-light border w-100 py-3 shadow-sm d-flex flex-column align-items-center">
                        <i class="bi bi-person-badge fs-2 mb-1 text-primary"></i>
                        <span>Roles</span>
                    </a>
                </div>
                <div class="col-6 col-md-2">
                    <a href="#" class="btn btn-light border w-100 py-3 shadow-sm d-flex flex-column align-items-center">
                        <i class="bi bi-people fs-2 mb-1 text-primary"></i>
                        <span>Usuarios</span>
                    </a>
                </div>
                <div class="col-6 col-md-2">
                    <a href="#" class="btn btn-light border w-100 py-3 shadow-sm d-flex flex-column align-items-center">
                        <i class="bi bi-building fs-2 mb-1 text-primary"></i>
                        <span>Área</span>
                    </a>
                </div>
                <div class="col-6 col-md-2">
                    <a href="#" class="btn btn-light border w-100 py-3 shadow-sm d-flex flex-column align-items-center">
                        <i class="bi bi-person-lines-fill fs-2 mb-1 text-primary"></i>
                        <span>Empleado</span>
                    </a>
                </div>
                <div class="col-6 col-md-2">
                    <a href="#" class="btn btn-light border w-100 py-3 shadow-sm d-flex flex-column align-items-center">
                        <i class="bi bi-exclamation-diamond fs-2 mb-1 text-primary"></i>
                        <span>Condición Insegura</span>
                    </a>
                </div>
                <div class="col-6 col-md-2">
                    
                </div>
            </div>
    </div>
</section>

<!-- Pie de página -->
<footer class="footer mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mb-3 mb-md-0">
                <h5>Contacto</h5>
                <p class="mb-1">Tel: <a href="tel:+573001234567">+57 300 123 4567</a></p>
                <p class="mb-1">Email: <a href="mailto:info@raci-sst.com">info@raci-sst.com</a></p>
                <p>Dirección: Calle 123 #45-67, Bogotá, Colombia</p>
            </div>
            <div class="col-md-6 text-md-end">
                <h5>Síguenos</h5>
                <a href="#" class="me-3"><i class="bi bi-facebook fs-4"></i></a>
                <a href="#" class="me-3"><i class="bi bi-twitter fs-4"></i></a>
                <a href="#" class="me-3"><i class="bi bi-linkedin fs-4"></i></a>
                <a href="#"><i class="bi bi-instagram fs-4"></i></a>
            </div>
        </div>
        <div class="text-center mt-3">
            <small>&copy; <?php echo date('Y'); ?> RACI SST. Todos los derechos reservados.</small>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
