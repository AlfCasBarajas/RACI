<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit();
}
include "navbar.php";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!-- Estilos personalizados (si es necesario) -->
    <link href="estilos.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <?php
    $modulo = $_GET["modulo"] ?? "dashboard";

    switch ($modulo) {
        case "dashboard":
            include "dashboard.php";
            break;
        case "usuario":
            include "controlador/UsuarioControlador.php";
            include "vista/usuarioVista.php";
            break;
        case "empleado":
            include "controlador/EmpleadoControlador.php";
            include "vista/empleadoVista.php";
            break;
        case "area":
            include "controlador/AreaControlador.php";
            include "vista/areaVista.php";
            break;
        case "categoria":
            include "controlador/CategoriaControlador.php";
            include "vista/categoriaVista.php";
            break;
        case "accidente":
            include "controlador/AccidenteControlador.php";
            include "vista/accidenteVista.php";
            break;
        case "incidente":
            include "controlador/IncidenteControlador.php";
            include "vista/incidenteVista.php";
            break;
        case "condicion":
            include "controlador/CondicionControlador.php";
            include "vista/condicionVista.php";
            break;
        default:
            echo "<h2 class='text-danger'>🔍 Módulo no encontrado</h2>";
    }
    ?>
</div>

<!-- Bootstrap JS (Opcional, para funcionalidades de componentes interactivos) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
