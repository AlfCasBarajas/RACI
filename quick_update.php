<?php
// Script para actualizar los módulos restantes rápidamente

$modules = [
    'condicionesinseguras' => [
        'title' => 'Condiciones Inseguras',
        'icon' => 'exclamation-diamond',
        'color' => '#ff5722'
    ],
    'riesgos' => [
        'title' => 'Riesgos',
        'icon' => 'shield-check',
        'color' => '#4caf50'
    ],
    'inspeccioneslocativas' => [
        'title' => 'Inspecciones Locativas',
        'icon' => 'clipboard-check',
        'color' => '#2196f3'
    ],
    'reportes' => [
        'title' => 'Reportes',
        'icon' => 'file-earmark-text',
        'color' => '#9c27b0'
    ]
];

foreach ($modules as $module => $config) {
    $filePath = __DIR__ . "/app/views/{$module}/index.php";
    
    if (file_exists($filePath)) {
        $content = file_get_contents($filePath);
        
        // Crear backup
        $backupPath = $filePath . '.backup.' . date('Y-m-d_H-i-s');
        file_put_contents($backupPath, $content);
        
        echo "Actualizando {$module}...\n";
        
        // Reemplazar el inicio del archivo
        $newStart = '<?php if (isset($data) && is_array($data)) extract($data); include __DIR__ . \'/../header.php\'; ?>

<div class="container-fluid">
    <div class="row">
        <!-- Incluir sidebar -->
        <?php include __DIR__ . \'/../sidebar.php\'; ?>
        
        <!-- Contenido principal -->
        <main class="col-md-10 ms-sm-auto offset-md-2 px-4 main-content">
            <style>
                .' . $module . '-card {
                    border-radius: 1.2rem;
                    box-shadow: 0 2px 12px rgba(30,40,90,0.10);
                    background: #fff;
                    border: none;
                    padding: 2rem;
                    margin-top: 2rem;
                }
                .' . $module . '-title {
                    color: #1a237e;
                    font-weight: 700;
                    border-bottom: 3px solid #ffd600;
                    margin-bottom: 2rem;
                    padding-bottom: 0.5rem;
                }
                .btn-' . $module . ' {
                    background: #3949ab;
                    color: #fff;
                    border-radius: 2rem;
                    font-weight: 600;
                    border: 2px solid #ffd600;
                    transition: background 0.2s, border 0.2s;
                }
                .btn-' . $module . ':hover {
                    background: #ffd600;
                    color: #3949ab;
                    border: 2px solid #3949ab;
                }
                .btn-' . $module . '-outline {
                    border: 2px solid #3949ab;
                    color: #3949ab;
                    background: #fff;
                    border-radius: 2rem;
                    font-weight: 600;
                    transition: background 0.2s, color 0.2s;
                }
                .btn-' . $module . '-outline:hover {
                    background: #3949ab;
                    color: #fff;
                    border: 2px solid #ffd600;
                }
            </style>

            <div class="' . $module . '-card">
                <h2 class="' . $module . '-title text-center"><i class="bi bi-' . $config['icon'] . ' me-2"></i>Gestión de ' . $config['title'] . '</h2>
                
                <!-- Contenido del módulo -->';
        
        // Buscar donde termina el header y comenzar a reemplazar
        $pattern = '/^.*?<style>.*?<\/style>\s*<div[^>]*?class="[^"]*-bg"[^>]*?>.*?<div[^>]*?class="w-100 text-center mb-3"[^>]*?>.*?<h2[^>]*?>[^<]*?<\/h2>\s*<\/div>/s';
        
        $updated = preg_replace($pattern, $newStart, $content);
        
        // Reemplazar el final
        $endPattern = '/\s*<\/div>\s*<\/div>\s*<\/div>\s*<\/div>\s*<\/div>\s*<\/div>\s*<\?php include __DIR__.*?\?>.*?$/s';
        $newEnd = '
            </div>
        </main>
    </div>
</div>

<?php include __DIR__ . \'/../footer.php\'; ?>';
        
        $updated = preg_replace($endPattern, $newEnd, $updated);
        
        if ($updated && $updated !== $content) {
            file_put_contents($filePath, $updated);
            echo "✓ {$module} actualizado exitosamente\n";
        } else {
            echo "✗ Error actualizando {$module}\n";
        }
    } else {
        echo "✗ Archivo no encontrado: {$filePath}\n";
    }
}

echo "\n¡Actualización completada!\n";
?>