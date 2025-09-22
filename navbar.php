<nav class="navbar">
    <span>👤 <?= $_SESSION["usuario"] ?? "Invitado" ?> | Rol: <?= $_SESSION["rol"] ?? "Sin rol" ?></span>
    <a href="index.php">🏠 Inicio</a>
    <a href="index.php?modulo=dashboard">📊 Dashboard</a>
    <a href="index.php?modulo=usuario">Usuarios</a>
    <a href="index.php?modulo=empleado">Empleados</a>
    <a href="index.php?modulo=area">Áreas</a>
    <a href="index.php?modulo=categoria">Categorías</a>
    <a href="index.php?modulo=accidente">Accidentes</a>
    <a href="index.php?modulo=incidente">Incidentes</a>
    <a href="index.php?modulo=condicion">Condiciones Inseguras</a>
    <a href="logout.php">🔓 Cerrar sesión</a>
</nav>
