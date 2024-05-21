<?php
session_start();

use IharKarpliuk\AmoPointThirdTest\Authentication;
use IharKarpliuk\AmoPointThirdTest\Request;
use IharKarpliuk\AmoPointThirdTest\Storage;

define('ROOT_PATH', dirname(__DIR__));
require ROOT_PATH . '/vendor/autoload.php';

$authentication = new Authentication();
if (!$authentication->checkAuth()) {
    Request::redirect('/login.php');
}

$storage = new Storage(ROOT_PATH . '/storage/app.db');
$storage->createTableIfNotExist();

$hourlyVisits = $storage->getHourlyVisits();
$cityVisits = $storage->getCityVisits();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Visiting</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment-timezone@0.5.34"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-moment@1.0.0"></script>
</head>
<body>
<div>
    <a href="/logout.php">Logout</a>
</div>
<h2>Visits by hour</h2>
<canvas id="hourlyVisitsChart"></canvas>

<h2>Visits by city</h2>
<canvas id="cityVisitsChart"></canvas>

<script>
    let hourlyVisitsCtx = document.getElementById('hourlyVisitsChart').getContext('2d');
    let hourlyVisitsData = {
        labels: <?php echo json_encode(array_column($hourlyVisits, 'hour')); ?>,
        datasets: [{
            label: 'Посещения по часам',
            data: <?php echo json_encode(array_column($hourlyVisits, 'visits')); ?>,
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1,
            fill: false
        }]
    };

    let hourlyVisitsChart = new Chart(hourlyVisitsCtx, {
        type: 'line',
        data: hourlyVisitsData,
        options: {
            scales: {
                x: {
                    type: 'time',
                    time: {
                        unit: 'hour',
                        tooltipFormat: 'YYYY-MM-DD HH:mm',
                        displayFormats: {
                            hour: 'YYYY-MM-DD HH:mm'
                        }
                    }
                },
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    let cityVisitsCtx = document.getElementById('cityVisitsChart').getContext('2d');
    let cityVisitsData = {
        labels: <?php echo json_encode(array_column($cityVisits, 'city')); ?>,
        datasets: [{
            label: 'Посещения по городам',
            data: <?php echo json_encode(array_column($cityVisits, 'visits')); ?>,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    };

    let cityVisitsChart = new Chart(cityVisitsCtx, {
        type: 'pie',
        data: cityVisitsData
    });
</script>
</body>
</html>
