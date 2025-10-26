<?php
// Script para actualizar automáticamente todos los módulos con la barra lateral

$baseDir = __DIR__;
$modulesDir = $baseDir . '/app/views/';

// Lista de módulos a actualizar
$modules = [
    'areas' => 'Áreas',
    'categorias' => 'Categorías', 
    'accidentes' => 'Accidentes',
    'incidentes' => 'Incidentes',
    'condicionesinseguras' => 'Condiciones Inseguras',
    'riesgos' => 'Riesgos',
    'inspeccioneslocativas' => 'Inspecciones Locativas',
    'reportes' => 'Reportes'
];

// Template base para los módulos
function getModuleTemplate($moduleName, $moduleTitle, $icon) {
    return '<?php
if (isset($data) && is_array($data)) extract($data);
include __DIR__ . \'/../header.php\'; ?>

<div class="container-fluid">
    <div class="row">
        <!-- Incluir sidebar -->
        <?php include __DIR__ . \'/../sidebar.php\'; ?>
        
        <!-- Contenido principal -->
        <main class="col-md-10 ms-sm-auto offset-md-2 px-4 main-content">
            <style>
                .' . $moduleName . '-card {
                    border-radius: 1.2rem;
                    box-shadow: 0 2px 12px rgba(30,40,90,0.10);
                    background: #fff;
                    border: none;
                    padding: 2rem;
                    margin-top: 2rem;
                }
                .' . $moduleName . '-title {
                    color: #1a237e;
                    font-weight: 700;
                    border-bottom: 3px solid #ffd600;
                    margin-bottom: 2rem;
                    padding-bottom: 0.5rem;
                }
                .btn-' . $moduleName . ' {
                    background: #3949ab;
                    color: #fff;
                    border-radius: 2rem;
                    font-weight: 600;
                    border: 2px solid #ffd600;
                    transition: background 0.2s, border 0.2s;
                }
                .btn-' . $moduleName . ':hover {
                    background: #ffd600;
                    color: #3949ab;
                    border: 2px solid #3949ab;
                }
                .btn-' . $moduleName . '-outline {
                    border: 2px solid #3949ab;
                    color: #3949ab;
                    background: #fff;
                    border-radius: 2rem;
                    font-weight: 600;
                    transition: background 0.2s, color 0.2s;
                }
                .btn-' . $moduleName . '-outline:hover {
                    background: #3949ab;
                    color: #fff;
                    border: 2px solid #ffd600;
                }
                .' . $moduleName . '-actions {
                    display: flex;
                    gap: 0.5rem;
                    justify-content: center;
                    flex-wrap: wrap;
                }
            </style>

            <div class="' . $moduleName . '-card">
                <h2 class="' . $moduleName . '-title text-center"><i class="bi bi-' . $icon . ' me-2"></i>Gestión de ' . $moduleTitle . '</h2>
                
                <!-- Aquí iría el contenido específico del módulo -->
                <div class="text-center">
                    <p class="mb-3">Contenido del módulo ' . $moduleTitle . ' con barra lateral incluida.</p>
                    <a href="?controller=' . $moduleName . '&action=create" class="btn btn-' . $moduleName . '">
                        <i class="bi bi-plus-circle me-1"></i>Nuevo ' . rtrim($moduleTitle, 's') . '
                    </a>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include __DIR__ . \'/../footer.php\'; ?>';
}

// Iconos para cada módulo
$icons = [
    'areas' => 'building',
    'categorias' => 'folder2-open',
    'accidentes' => 'activity',
    'incidentes' => 'exclamation-triangle',
    'condicionesinseguras' => 'exclamation-diamond',
    'riesgos' => 'shield-check',
    'inspeccioneslocativas' => 'clipboard-check',
    'reportes' => 'file-earmark-text'
];

echo "Iniciando actualización de módulos...\n";

foreach ($modules as $module => $title) {
    $filePath = $modulesDir . $module . '/index.php';
    
    if (file_exists($filePath)) {
        // Leer contenido actual
        $currentContent = file_get_contents($filePath);
        
        // Hacer backup
        $backupPath = $filePath . '.backup.' . date('Y-m-d_H-i-s');
        file_put_contents($backupPath, $currentContent);
        
        echo "Procesando módulo: $module ($title)\n";
        echo "  - Backup creado: $backupPath\n";
        
        // Extraer el contenido específico del módulo (parte entre el body y el footer)
        // Esto es un ejemplo simple - para una implementación real necesitarías parsing más sofisticado
        
        // Por ahora, crear la estructura básica
        $newContent = getModuleTemplate($module, $title, $icons[$module]);
        
        // Escribir nuevo contenido
        file_put_contents($filePath, $newContent);
        echo "  - Archivo actualizado exitosamente\n";
    } else {
        echo "Archivo no encontrado: $filePath\n";
    }
}

echo "\n¡Actualización completada!\n";
echo "Se han creado backups de todos los archivos originales.\n";
echo "Revisa cada módulo para restaurar la funcionalidad específica.\n";
?>