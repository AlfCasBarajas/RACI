<!-- Barra de navegación horizontal -->
<nav class="navbar navbar-expand-lg navbar-dark" style="background: #1a237e;">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="../Imagenes/Logo_RACI.png" alt="Logo" class="me-2" style="height:40px;">
            RACI SST
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="#servicios">Gestiones</a></li>
                <!--<li class="nav-item"><a class="nav-link" href="#contacto">Contacto</a></li>-->
                <!--<li class="nav-item"><a class="nav-link" href="/RACI/?controller=roles&action=index">Roles</a></li>-->
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
                <title>Inicio RACI</title>
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
                <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
                <style>
                    /* --- Inicio SST Moderno --- */
                    body {
                        background: #f4f6fb;
                        font-family: 'Inter', Arial, sans-serif;
                    }
                    .navbar {
                        background: #232f3e;
                        border-radius: 0 0 0.7rem 0.7rem;
                        box-shadow: 0 2px 8px rgba(30,40,90,0.08);
                        padding: 0.5rem 0;
                        border-bottom: 2px solid #3949ab;
                    }
                    .navbar-brand img {
                        height: 44px;
                        border-radius: 50%;
                        background: #fff;
                        box-shadow: 0 2px 8px rgba(30,40,90,0.10);
                        border: 3px solid #ffd600;
                    }
                    .navbar-nav .nav-link {
                        font-weight: 600;
                        transition: color 0.2s, background 0.2s;
                        border-radius: 0.5rem;
                        padding: 0.5rem 1rem;
                        position: relative;
                        color: #fff;
                    }
                    .navbar-nav .nav-link:hover {
                        color: #ffd600 !important;
                        background: #3949ab;
                        box-shadow: none;
                    }
                    .navbar-nav .nav-link::after {
                        content: '';
                        display: block;
                        width: 0;
                        height: 3px;
                        background: #ffd600;
                        transition: width 0.3s;
                        position: absolute;
                        left: 0; bottom: 0;
                    }
                    .navbar-nav .nav-link:hover::after {
                        width: 100%;
                    }
                    .sidebar {
                        background: #232f3e;
                        box-shadow: 2px 0 8px rgba(30,40,90,0.08);
                        border-right: 2px solid #3949ab;
                        height: 100vh;
                        overflow-y: auto;
                        scrollbar-width: thin;
                        scrollbar-color: #3949ab #232f3e;
                    }
                    .sidebar::-webkit-scrollbar {
                        width: 8px;
                        background: #232f3e;
                    }
                    .sidebar::-webkit-scrollbar-thumb {
                        background: #3949ab;
                        border-radius: 4px;
                    }
                    .sidebar .nav-link {
                        font-size: 1.05rem;
                        font-weight: 500;
                        border-radius: 0.5rem;
                        margin-bottom: 0.3rem;
                        transition: background 0.2s, color 0.2s;
                        display: flex;
                        align-items: center;
                        padding: 0.7rem 1rem;
                        background: transparent;
                        color: #fff !important;
                        border: none;
                        box-shadow: none;
                    }
                    .sidebar .nav-link:hover {
                        background: #3949ab;
                        color: #ffd600 !important;
                        border-radius: 0.5rem;
                    }
                    .sidebar .bi {
                        font-size: 1.5rem;
                        margin-right: 0.7rem;
                        color: #ffd600;
                    }
                    .sidebar-avatar {
                        width: 60px;
                        height: 60px;
                        border-radius: 50%;
                        object-fit: cover;
                        box-shadow: 0 2px 8px rgba(30,40,90,0.10);
                        margin-bottom: 1rem;
                        border: 3px solid #ffd600;
                    }
                    .sidebar-user {
                        text-align: center;
                        margin-bottom: 1.5rem;
                        position: relative;
                    }
                    .sidebar-user span {
                        font-weight: 700;
                        color: #fff;
                        font-size: 1.1rem;
                        background: none;
                        padding: 0.2em 0.7em;
                        border-radius: 0.5em;
                        box-shadow: none;
                    }
                    .service-card {
                        border: none;
                        border-radius: 1rem;
                        box-shadow: 0 2px 8px rgba(30,40,90,0.08);
                        background: #fff;
                        transition: transform 0.2s, box-shadow 0.2s;
                        position: relative;
                        overflow: hidden;
                    }
                    .service-card i {
                        font-size: 2.6rem;
                        margin-bottom: 0.5rem;
                        color: #3949ab;
                        transition: color 0.2s;
                    }
                    .service-card:hover {
                        transform: translateY(-7px) scale(1.04);
                        box-shadow: 0 8px 32px rgba(30,40,90,0.18);
                        background: #f4f6fb;
                    }
                    .service-card:hover i {
                        color: #ffd600;
                    }
                    .service-card span {
                        font-weight: 600;
                        color: #232f3e;
                        font-size: 1.08rem;
                    }
                    .footer {
                        background: #232f3e;
                        color: #fff;
                        padding: 32px 0 12px 0;
                        border-radius: 0.7rem 0.7rem 0 0;
                        box-shadow: 0 -2px 8px rgba(30,40,90,0.08);
                        border-top: 2px solid #3949ab;
                        width: 100%;
                        max-width: 1100px;
                        margin: 32px auto 0 auto;
                    }
                    .footer a { color: #ffd600; text-decoration: none; transition: color 0.2s; }
                    .footer a:hover { color: #fff; text-decoration: underline; background: #3949ab; border-radius: 0.3rem; }
                    .footer .bi {
                        transition: color 0.2s, transform 0.2s, background 0.2s;
                        padding: 0.3rem;
                        border-radius: 50%;
                        background: none;
                        color: #ffd600;
                    }
                    .footer .bi:hover {
                        color: #fff;
                        background: none;
                        transform: scale(1.1);
                    }
                    .main-section {
                        background: #fff;
                        border-radius: 1rem;
                        box-shadow: 0 2px 8px rgba(30,40,90,0.08);
                        margin-top: 2rem;
                        margin-bottom: 2rem;
                        padding: 2.5rem 1rem;
                        position: relative;
                        border: none;
                    }
                    .main-section h1, .main-section h2 {
                        color: #232f3e;
                        font-weight: 700;
                    }
                    .main-section .lead {
                        color: #3949ab;
                        font-weight: 500;
                    }
                    @media (max-width: 768px) {
                        .sidebar {
                            position: static !important;
                            height: auto !important;
                            min-height: 0 !important;
                        }
                        .sidebar-user {
                            margin-bottom: 1rem;
                        }
                        .service-card {
                            margin-bottom: 1rem;
                        }
                        .main-section {
                            margin-top: 1rem;
                            margin-bottom: 1rem;
                            padding: 1.2rem 0.5rem;
                            border-radius: 0.7rem;
                        }
                        .navbar {
                            border-radius: 0 0 0.7rem 0.7rem;
                        }
                        .footer {
                            border-radius: 0.7rem 0.7rem 0 0;
                        }
                        .navbar-brand img {
                            height: 36px;
                        }
                    }
                </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
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
                    <li class="nav-item mb-2"><a class="nav-link" href="/RACI/?controller=roles&action=index"><i class="bi bi-person-badge"></i>Roles</a></li>
                    <li class="nav-item mb-2"><a class="nav-link" href="/RACI/?controller=users&action=index"><i class="bi bi-people"></i>Usuarios</a></li>
                    <li class="nav-item mb-2"><a class="nav-link" href="/RACI/?controller=areas&action=index"><i class="bi bi-building"></i>Áreas</a></li>
                    <li class="nav-item mb-2"><a class="nav-link" href="/RACI/?controller=empleados&action=index"><i class="bi bi-person-lines-fill"></i>Empleados</a></li>
                    <li class="nav-item mb-2"><a class="nav-link" href="/RACI/?controller=categorias&action=index"><i class="bi bi-folder2-open"></i>Categorías</a></li>
                    <li class="nav-item mb-2"><a class="nav-link" href="/RACI/?controller=incidentes&action=index"><i class="bi bi-exclamation-triangle"></i>Incidentes</a></li>
                    <li class="nav-item mb-2"><a class="nav-link" href="/RACI/?controller=accidentes&action=index"><i class="bi bi-activity"></i>Accidentes</a></li>
                    <li class="nav-item mb-2"><a class="nav-link" href="/RACI/?controller=condicionesinseguras&action=index"><i class="bi bi-exclamation-diamond"></i>Condiciones Inseguras</a></li>
                    <li class="nav-item mb-2"><a class="nav-link" href="/RACI/?controller=riesgos&action=index"><i class="bi bi-shield-check"></i>Riesgos</a></li>
                    <li class="nav-item mb-2"><a class="nav-link" href="/RACI/?controller=inspeccionlocativa&action=index"><i class="bi bi-clipboard-check"></i>Inspecciones Locativas</a></li>
                    <li class="nav-item mb-2"><a class="nav-link" href="/RACI/?controller=reportes&action=index"><i class="bi bi-file-earmark-text"></i>Reportes</a></li>
                    <li class="nav-item mb-2"><a class="nav-link text-danger" href="../../index.php"><i class="bi bi-box-arrow-right"></i>Cerrar sesión</a></li>
                </ul>
            </div>
        </nav>
        <!-- Main content -->
        <main class="col-md-10 ms-sm-auto offset-md-2 px-4">
            <section class="py-5 main-section position-relative">
                <div class="container">
                    <div class="row align-items-center mb-4">
                        <div class="col-md-7">
                            <h1 class="display-5 fw-bold mb-3">Bienvenido, <?php echo htmlspecialchars($user['usuario']); ?>!</h1>
                            <p class="lead">Facilitamos la gestión de Seguridad y Salud en el Trabajo a través del registro estructurado de información, permitiendo el seguimiento, análisis y mejora continua de los procesos. Nuestro enfoque está en la trazabilidad, organización y eficiencia documental.</p>
                        </div>
                        <div class="col-md-5 text-center">
                            <img src="../Imagenes/Logo_RACI.png" alt="SST" class="img-fluid" style="max-height: 140px;">
                        </div>
                    </div>
                    <h2 class="text-center mb-4" id="servicios">Gestiones</h2>
                    <div class="row g-4">
                        <div class="col-12 col-md-6 col-lg-3">
                            <a href="/RACI/?controller=roles&action=index" class="service-card d-block text-center py-4">
                                <i class="bi bi-person-badge mb-2" style="font-size:2.2rem;"></i>
                                <span>Roles</span>
                            </a>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <a href="/RACI/?controller=users&action=index" class="service-card d-block text-center py-4">
                                <i class="bi bi-people mb-2" style="font-size:2.2rem;"></i>
                                <span>Usuarios</span>
                            </a>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <a href="/RACI/?controller=areas&action=index" class="service-card d-block text-center py-4">
                                <i class="bi bi-building mb-2" style="font-size:2.2rem;"></i>
                                <span>Áreas</span>
                            </a>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <a href="/RACI/?controller=empleados&action=index" class="service-card d-block text-center py-4">
                                <i class="bi bi-person-lines-fill mb-2" style="font-size:2.2rem;"></i>
                                <span>Empleados</span>
                            </a>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <a href="/RACI/?controller=categorias&action=index" class="service-card d-block text-center py-4">
                                <i class="bi bi-folder2-open mb-2" style="font-size:2.2rem;"></i>
                                <span>Categorías</span>
                            </a>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <a href="/RACI/?controller=incidentes&action=index" class="service-card d-block text-center py-4">
                                <i class="bi bi-exclamation-triangle mb-2" style="font-size:2.2rem;"></i>
                                <span>Incidentes</span>
                            </a>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <a href="/RACI/?controller=accidentes&action=index" class="service-card d-block text-center py-4">
                                <i class="bi bi-activity mb-2" style="font-size:2.2rem;"></i>
                                <span>Accidentes</span>
                            </a>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <a href="/RACI/?controller=condicionesinseguras&action=index" class="service-card d-block text-center py-4">
                                <i class="bi bi-exclamation-diamond mb-2" style="font-size:2.2rem;"></i>
                                <span>Condiciones Inseguras</span>
                            </a>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <a href="/RACI/?controller=riesgos&action=index" class="service-card d-block text-center py-4">
                                <i class="bi bi-shield-check mb-2" style="font-size:2.2rem;"></i>
                                <span>Riesgos</span>
                            </a>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <a href="/RACI/?controller=inspeccionlocativa&action=index" class="service-card d-block text-center py-4">
                                <i class="bi bi-clipboard-check mb-2" style="font-size:2.2rem;"></i>
                                <span>Inspecciones Locativas</span>
                            </a>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <a href="/RACI/?controller=reportes&action=index" class="service-card d-block text-center py-4">
                                <i class="bi bi-file-earmark-text mb-2" style="font-size:2.2rem;"></i>
                                <span>Reportes</span>
                            </a>
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
        </main>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Forzar scroll al tope al cargar el inicio
    window.addEventListener('load', function() {
        window.scrollTo(0, 0);
    });
</script>
</body>
</html>
