<?php
require_once "modelo/RiesgoModelo.php";
$riesgoModelo = new RiesgoModelo();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($_SESSION["rol"] === "Trabajador") {
        header("Location: acceso_denegado.php");
        exit();
    }

    if (isset($_POST["crear"])) {
        $riesgoModelo->crearRiesgo($_POST["descripcion"], $_POST["nivel"], $_POST["id_area"], $_POST["id_categoria"]);
    }
    if (isset($_POST["actualizar"])) {
        $riesgoModelo->actualizarRiesgo($_POST["id"], $_POST["descripcion"], $_POST["nivel"], $_POST["id_area"], $_POST["id_categoria"]);
    }
    if (isset($_POST["eliminar"]) && $_SESSION["rol"] === "Administrador") {
        $riesgoModelo->eliminarRiesgo($_POST["id"]);
    }
    header("Location: index.php?modulo=riesgo");
    exit();
}

$riesgos = $riesgoModelo->obtenerRiesgos();
$areas = $riesgoModelo->obtenerAreas();
$categorias = $riesgoModelo->obtenerCategorias();
?>
