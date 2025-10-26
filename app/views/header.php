<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RACI - Gestiones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', Arial, sans-serif;
            background: #f4f6fb;
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
        .main-content {
            margin-left: 16.66667%; /* Equivalente a col-md-2 offset */
            min-height: 100vh;
        }
        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
            }
            .sidebar {
                display: none !important;
            }
        }
    </style>
</head>
<body>
<!-- Barra de navegación horizontal -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="/RACI/app/Imagenes/Logo_RACI.png" alt="Logo" class="me-2">
            RACI SST
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="/RACI/app/views/dashboard.php">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="/RACI/index.php">Cerrar sesión</a></li>
            </ul>
        </div>
    </div>
</nav>
