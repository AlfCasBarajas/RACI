<?php
session_start();
require_once "conexion.php";

$num_doc = $_POST["num_doc"];
$contrasena = $_POST["contrasena"];

$db = Conexion::conectar();
$stmt = $db->prepare("SELECT u.*, r.nombre AS rol_nombre 
                      FROM user u 
                      JOIN rol r ON u.rol = r.id_Rol
                      WHERE u.num_doc = ?");
$stmt->execute([$num_doc]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if ($usuario && password_verify($contrasena, $usuario["contrasena"])) {
    $_SESSION["usuario"] = $usuario["nombres"] . " " . $usuario["apellidos"];
    $_SESSION["rol"] = $usuario["rol_nombre"];
    $_SESSION["rol_id"] = $usuario["rol"];
    header("Location: index.php");
} else {
    echo "<h3>❌ Documento o contraseña incorrectos</h3>";
    echo "<a href='login.php'>Volver</a>";
}
?>
