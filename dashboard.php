<?php
include_once 'conexion.php';
if ($_SESSION["rol"] === "Trabajador") {
    echo "<h2>👋 Bienvenido al sistema RACI</h2>";
    echo "<p>Gracias por reportar condiciones, incidentes o accidentes. Tu participación mejora la seguridad.</p>";
    return;
}
?>

<h2 class="text-center mb-4"><i class="fas fa-chart-bar"></i> 📊 Panel de Estadísticas</h2>

<div class="container">
    <div class="row">
        <!-- Card 1: Total de Accidentes -->
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="card-title"><i class="fas fa-accusoft"></i> Total de Accidentes</h3>
                    <?php
                    $db = Conexion::conectar();
                    $totalAccidentes = $db->query("SELECT COUNT(*) FROM accidente")->fetchColumn();
                    ?>
                    <p class="card-text"><?= $totalAccidentes ?> registrados</p>
                    <canvas id="accidentesChart"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Card 2: Total de Incidentes -->
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="card-title"><i class="fas fa-exclamation-triangle"></i> Total de Incidentes</h3>
                    <?php
                    $totalIncidentes = $db->query("SELECT COUNT(*) FROM incidente")->fetchColumn();
                    ?>
                    <p class="card-text"><?= $totalIncidentes ?> registrados</p>
                    <canvas id="incidentesChart"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Card 3: Condiciones Inseguras -->
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="card-title"><i class="fas fa-exclamation-circle"></i> Condiciones Inseguras</h3>
                    <?php
                    $totalCondiciones = $db->query("SELECT COUNT(*) FROM condicion_insegura")->fetchColumn();
                    ?>
                    <p class="card-text"><?= $totalCondiciones ?> reportadas</p>
                    <canvas id="condicionesChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script para Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Datos para el gráfico de Accidentes
    var accidentesData = {
        labels: ['Accidentes'],
        datasets: [{
            label: 'Total de Accidentes',
            data: [<?php echo $totalAccidentes; ?>],
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1
        }]
    };

    var incidentesData = {
        labels: ['Incidentes'],
        datasets: [{
            label: 'Total de Incidentes',
            data: [<?php echo $totalIncidentes; ?>],
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    };

    var condicionesData = {
        labels: ['Condiciones Inseguras'],
        datasets: [{
            label: 'Condiciones Inseguras Reportadas',
            data: [<?php echo $totalCondiciones; ?>],
            backgroundColor: 'rgba(255, 159, 64, 0.2)',
            borderColor: 'rgba(255, 159, 64, 1)',
            borderWidth: 1
        }]
    };

    // Configuración de los gráficos
    var ctxAccidentes = document.getElementById('accidentesChart').getContext('2d');
    var ctxIncidentes = document.getElementById('incidentesChart').getContext('2d');
    var ctxCondiciones = document.getElementById('condicionesChart').getContext('2d');

    // Crear gráficos
    new Chart(ctxAccidentes, {
        type: 'bar',
        data: accidentesData,
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    new Chart(ctxIncidentes, {
        type: 'bar',
        data: incidentesData,
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    new Chart(ctxCondiciones, {
        type: 'bar',
        data: condicionesData,
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
