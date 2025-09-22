<?php
require_once "modelo/UsuarioModelo.php";
$usuarioModelo = new UsuarioModelo();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($_SESSION["rol"] !== "Administrador") {
        header("Location: acceso_denegado.php");
        exit();
    }

    if (isset($_POST["crear"])) {
        $usuarioModelo->crearUsuario($_POST["nombres"], $_POST["apellidos"], $_POST["num_doc"], $_POST["contrasena"], $_POST["rol"]);
    }
    if (isset($_POST["actualizar"])) {
        $usuarioModelo->actualizarUsuario($_POST["id"], $_POST["nombres"], $_POST["apellidos"], $_POST["num_doc"], $_POST["rol"]);
    }
    if (isset($_POST["eliminar"])) {
        $usuarioModelo->eliminarUsuario($_POST["id"]);
    }
    header("Location: index.php?modulo=usuario");
    exit();
}

$usuarios = $usuarioModelo->obtenerUsuarios();
$roles = $usuarioModelo->obtenerRoles();
?>
