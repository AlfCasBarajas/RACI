<?php
require_once "modelo/IncidenteModelo.php";
$incidenteModelo = new IncidenteModelo();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($_SESSION["rol"] === "Trabajador") {
        header("Location: acceso_denegado.php");
        exit();
    }

    if (isset($_POST["crear"])) {
        $incidenteModelo->crearIncidente($_POST["fecha"], $_POST["descripcion"], $_POST["id_empleado"], $_POST["id_area"]);
    }
    if (isset($_POST["actualizar"])) {
        $incidenteModelo->actualizarIncidente($_POST["id"], $_POST["fecha"], $_POST["descripcion"], $_POST["id_empleado"], $_POST["id_area"]);
    }
    if (isset($_POST["eliminar"]) && $_SESSION["rol"] === "Administrador") {
        $incidenteModelo->eliminarIncidente($_POST["id"]);
    }
    header("Location: index.php?modulo=incidente");
    exit();
}

$incidentes = $incidenteModelo->obtenerIncidentes();
$empleados = $incidenteModelo->obtenerEmpleados();
$areas = $incidenteModelo->obtenerAreas();
?>
