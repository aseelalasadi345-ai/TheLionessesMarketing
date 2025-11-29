<?php
include "../db.php";
session_start();

if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "Admin") {
    header("Location: ../home/home.php");
    exit();
}

$brands = $conn->query("SELECT COUNT(*) AS c FROM brands")->fetch_assoc()['c'];
$projects = $conn->query("SELECT COUNT(*) AS c FROM projects")->fetch_assoc()['c'];
$metrics = $conn->query("SELECT COUNT(*) AS c FROM transformation_metrics")->fetch_assoc()['c'];
$requests = $conn->query("SELECT COUNT(*) AS c FROM service_requests")->fetch_assoc()['c'];

$newReq = $conn->query("SELECT COUNT(*) AS c FROM service_requests WHERE status='Pending'")
               ->fetch_assoc()['c'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="adminPanel.css?v=<?= time() ?>">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<h1 class="title">Admin Control Panel</h1>

<?php if ($newReq > 0): ?>
<div class="notification">
    🔔 لديك <strong><?= $newReq ?></strong> طلبات جديدة!
</div>
<?php endif; ?>

<div class="quick-links">

    <a href="addBrand.html" class="admin-btn">+ Add Brand</a>
    <a href="addProjectmain.php" class="admin-btn">+ Add Project</a>
    <a href="addMetricmain.php" class="admin-btn">+ Add Metric</a>
    <a href="addTransformation.php" class="admin-btn">+ Add Transformation</a>

</div>

<div class="stats-container">

    <div class="stat-card blue">
        <h2><?= $brands ?></h2>
        <p>Brands</p>
    </div>

    <div class="stat-card red">
        <h2><?= $projects ?></h2>
        <p>Projects</p>
    </div>

    <div class="stat-card blue">
        <h2><?= $metrics ?></h2>
        <p>Metrics</p>
    </div>

    <div class="stat-card red">
        <h2><?= $requests ?></h2>
        <p>Requests</p>
    </div>

</div>

<h2 class="chart-title">Overview</h2>
<canvas id="overviewChart"></canvas>

<script>
const ctx = document.getElementById('overviewChart');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Brands','Projects','Metrics','Requests'],
        datasets: [{
            label: 'Count',
            data: [<?= $brands ?>, <?= $projects ?>, <?= $metrics ?>, <?= $requests ?>],
            borderWidth: 2,
            backgroundColor: ['#002395','#ED2939','#002395','#ED2939']
        }]
    },
    options: {
        scales: {
            y: { beginAtZero: true }
        }
    }
});
</script>

</body>
</html>