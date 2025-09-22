<?php
require_once "modelo/InspeccionModelo.php";
$inspeccionModelo = new InspeccionModelo();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($_SESSION["rol"] === "Trabajador") {
        header("Location: acceso_denegado.php");
        exit();
    }

    if (isset($_POST["crear"])) {
        $inspeccionModelo->crearInspeccion($_POST["fecha"], $_POST["observacion"], $_POST["id_area"]);
    }
    if (isset($_POST["actualizar"])) {
        $inspeccionModelo->actualizarInspeccion($_POST["id"], $_POST["fecha"], $_POST["observacion"], $_POST["id_area"]);
    }
    if (isset($_POST["eliminar"]) && $_SESSION["rol"] === "Administrador") {
        $inspeccionModelo->eliminarInspeccion($_POST["id"]);
    }
    header("Location: index.php?modulo=inspeccion");
    exit();
}

$inspecciones = $inspeccionModelo->obtenerInspecciones();
$areas = $inspeccionModelo->obtenerAreas();
?>
