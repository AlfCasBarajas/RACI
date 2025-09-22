<?php
require_once "modelo/EmpleadoModelo.php";
$empleadoModelo = new EmpleadoModelo();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($_SESSION["rol"] === "Trabajador") {
        header("Location: acceso_denegado.php");
        exit();
    }

    if (isset($_POST["crear"])) {
        $empleadoModelo->crearEmpleado($_POST["nombre"], $_POST["documento"], $_POST["cargo"], $_POST["id_area"]);
    }
    if (isset($_POST["actualizar"])) {
        $empleadoModelo->actualizarEmpleado($_POST["id"], $_POST["nombre"], $_POST["documento"], $_POST["cargo"], $_POST["id_area"]);
    }
    if (isset($_POST["eliminar"]) && $_SESSION["rol"] === "Administrador") {
        $empleadoModelo->eliminarEmpleado($_POST["id"]);
    }
    header("Location: index.php?modulo=empleado");
    exit();
}

$empleados = $empleadoModelo->obtenerEmpleados();
$areas = $empleadoModelo->obtenerAreas();
?>
