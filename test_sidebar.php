<?php
// Script de prueba para verificar que todo funciona correctamente

echo "<h3>🔍 Verificando archivos del sistema RACI...</h3>";

$files_to_check = [
    'app/views/header.php',
    'app/views/sidebar.php', 
    'app/views/footer.php',
    'app/views/roles/index.php',
    'app/views/users/index.php'
];

foreach ($files_to_check as $file) {
    $path = __DIR__ . '/' . $file;
    if (file_exists($path)) {
        echo "✅ $file - EXISTS<br>";
    } else {
        echo "❌ $file - NOT FOUND<br>";
    }
}

echo "<hr>";
echo "<h3>🔧 Información de PHP:</h3>";
echo "PHP Version: " . phpversion() . "<br>";
echo "Session Status: " . session_status() . "<br>";

// Verificar si Bootstrap Icons está cargando
echo "<hr>";
echo "<h3>🎨 Prueba de iconos:</h3>";
echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">';
echo '<i class="bi bi-check-circle" style="font-size: 2rem; color: green;"></i> Si ves este ícono, Bootstrap Icons funciona';

?>