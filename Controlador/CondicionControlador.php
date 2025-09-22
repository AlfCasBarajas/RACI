<?php
require_once "modelo/CondicionModelo.php";
$condicionModelo = new CondicionModelo();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($_SESSION["rol"] === "Trabajador") {
        header("Location: acceso_denegado.php");
        exit();
    }

    if (isset($_POST["crear"])) {
        $condicionModelo->crearCondicion($_POST["nombre"], $_POST["descripcion"]);
    }
    if (isset($_POST["actualizar"])) {
        $condicionModelo->actualizarCondicion($_POST["id"], $_POST["fecha"], $_POST["descripcion"], $_POST["id_area"]);
    }
    if (isset($_POST["eliminar"]) && $_SESSION["rol"] === "Administrador") {
        $condicionModelo->eliminarCondicion($_POST["id"]);
    }
    header("Location: index.php?modulo=condicion");
    exit();
}

$condiciones = $condicionModelo->obtenerCondiciones();
$areas = $condicionModelo->obtenerAreas();
?>
