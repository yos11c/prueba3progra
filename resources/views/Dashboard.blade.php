<!DOCTYPE html>
<html>
<head>
    <title>Dashboard de datos de automóviles</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<canvas id="salesChart" width="200" height="100"></canvas>
<canvas id="mileageChart" width="400" height="200"></canvas>

<?php
// Datos de ejemplo
$carBrands = ['Toyota', 'Honda', 'Ford', 'Chevrolet'];
$salesData = [120, 90, 80, 60];
$mileageData = [30, 28, 25, 22];
?>

<script>
    // Obtener el contexto del lienzo del gráfico de ventas
    var salesCtx = document.getElementById('salesChart').getContext('2d');

    // Crear el gráfico de ventas
    var salesChart = new Chart(salesCtx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($carBrands); ?>,
            datasets: [{
                label: 'VENTAS DE MOTORES ',
                data: <?php echo json_encode($salesData); ?>,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
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
</body>
</html>
