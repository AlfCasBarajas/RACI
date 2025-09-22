<?php
require_once "modelo/AccidenteModelo.php";
$accidenteModelo = new AccidenteModelo();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($_SESSION["rol"] === "Trabajador") {
        header("Location: acceso_denegado.php");
        exit();
    }

    if (isset($_POST["crear"])) {
        $accidenteModelo->crearAccidente($_POST["fecha"], $_POST["descripcion"], $_POST["id_empleado"], $_POST["id_area"]);
    }
    if (isset($_POST["actualizar"])) {
        $accidenteModelo->actualizarAccidente($_POST["id"], $_POST["fecha"], $_POST["descripcion"], $_POST["id_empleado"], $_POST["id_area"]);
    }
    if (isset($_POST["eliminar"]) && $_SESSION["rol"] === "Administrador") {
        $accidenteModelo->eliminarAccidente($_POST["id"]);
    }
    header("Location: index.php?modulo=accidente");
    exit();
}

$accidentes = $accidenteModelo->obtenerAccidentes();
$empleados = $accidenteModelo->obtenerEmpleados();
$areas = $accidenteModelo->obtenerAreas();
?>
