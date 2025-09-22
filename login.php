<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ingreso al sistema RACI</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <div class="login-container">
        <h2>🔐 Iniciar sesión</h2>
        <form method="POST" action="validar.php" class="formulario">
            <input type="number" name="num_doc" placeholder="Número de documento" required>
            <input type="password" name="contrasena" placeholder="Contraseña" required>
            <button type="submit">Ingresar</button>
        </form>
    </div>
</body>
</html>
