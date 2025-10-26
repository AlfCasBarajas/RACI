<?php include __DIR__ . '/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <!-- Incluir sidebar -->
        <?php include __DIR__ . '/sidebar.php'; ?>
        
        <!-- Contenido principal -->
        <main class="col-md-10 ms-sm-auto offset-md-2 px-4 main-content">
            <!-- El contenido específico de cada módulo se insertará aquí -->
            <?php if (isset($content)) echo $content; ?>