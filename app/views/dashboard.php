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
    <style>
        body { background: #f8f9fa; }
        .sidebar { height: 100vh; background: #343a40; color: #fff; padding-top: 30px; }
        .sidebar a { color: #fff; display: block; padding: 10px 20px; text-decoration: none; }
        .sidebar a:hover { background: #495057; }
        .quick-access { margin-top: 40px; }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 sidebar">
            <h4 class="text-center">Menú</h4>
            <a href="#">Inspección Locativa</a>
            <a href="#">Categoría</a>
            <a href="#">Incidente</a>
            <a href="#">Accidente</a>
            <a href="#">Riesgo</a>
            <a href="#">Reporte</a>
            <a href="#">Área</a>
            <a href="#">Empleado</a>
            <a href="#">Condición Insegura</a>
            <a href="#">Usuarios</a>
            <a href="#">Roles</a>
            <a href="../../index.php">Cerrar sesión</a>
        </nav>
        <main class="col-md-10">
            <div class="quick-access text-center">
                <h2>Bienvenido, <?php echo $user['nombres']; ?>!</h2>
                <p>Accesos rápidos a las gestiones:</p>
                <div class="row justify-content-center">
                    <div class="col-md-2"><a href="#" class="btn btn-outline-primary w-100 mb-2">Inspección Locativa</a></div>
                    <div class="col-md-2"><a href="#" class="btn btn-outline-primary w-100 mb-2">Categoría</a></div>
                    <div class="col-md-2"><a href="#" class="btn btn-outline-primary w-100 mb-2">Incidente</a></div>
                    <div class="col-md-2"><a href="#" class="btn btn-outline-primary w-100 mb-2">Accidente</a></div>
                    <div class="col-md-2"><a href="#" class="btn btn-outline-primary w-100 mb-2">Riesgo</a></div>
                </div>
            </div>
        </main>
    </div>
</div>
</body>
</html>
