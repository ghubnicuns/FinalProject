<?php
session_start();

// Auth check
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// Database connection
$host = 'localhost';
$dbname = 'ims';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die("DB connection failed: " . $e->getMessage());
}

// Fetch product names and quantities
$chartDataStmt = $pdo->query("SELECT product_name, product_quantity FROM products");
$chartData = $chartDataStmt->fetchAll(PDO::FETCH_ASSOC);

// Prepare data for Chart.js
$productNames = [];
$productQuantities = [];
$lowStockNames = [];
$lowStockQuantities = [];

foreach ($chartData as $row) {
    $productNames[] = $row['product_name'];
    $productQuantities[] = $row['product_quantity'];

    if ($row['product_quantity'] <= 20) { // Low stock threshold is 20
        $lowStockNames[] = $row['product_name'];
        $lowStockQuantities[] = $row['product_quantity'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reports - Project Storemai</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .chart-container {
            width: 90%;
            max-width: 1000px;
            margin: 40px auto;
            padding: 30px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
        }
        canvas {
            max-height: 500px;
        }
        body {
            background-color: #f5f5f5;
            font-family: Arial, sans-serif;
        }
        .main-content {
            padding: 20px;
        }
    </style>
</head>
<body>
<div class="home-container">
    <aside class="sidebar">
        <h2>PROJECT STOREMAI</h2>
        <nav>
            <a href="homepage.php"><i class="fas fa-home"></i> Dashboard</a>
            <a href="inventory.php"><i class="fas fa-boxes-stacked"></i> Inventory</a>
            <a href="users.php"><i class="fas fa-users"></i> Users</a>
            <a href="#" class="active"><i class="fas fa-chart-line"></i> Reports</a>
            <a href="add_product.php"><i class="fas fa-tags"></i> Products</a>
        </nav>
        <div class="logout-container">
            <a href="logout.php" class="logout-button"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </aside>

    <main class="main-content">
        <section class="chart-container">
            <h3>Product Inventory Overview</h3>
            <canvas id="productChart"></canvas>
        </section>

        <section class="chart-container">
            <h3>Low Stock Products (≤ 20 Units)</h3>
            <canvas id="lowStockChart"></canvas>
        </section>
    </main>
</div>

<script>
    const productChartCtx = document.getElementById('productChart').getContext('2d');
    new Chart(productChartCtx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($productNames) ?>,
            datasets: [{
                label: 'Product Quantity',
                data: <?= json_encode($productQuantities) ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `Qty: ${context.raw}`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    const lowStockChartCtx = document.getElementById('lowStockChart').getContext('2d');
    new Chart(lowStockChartCtx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($lowStockNames) ?>,
            datasets: [{
                label: 'Low Stock (≤ 20)',
                data: <?= json_encode($lowStockQuantities) ?>,
                backgroundColor: 'rgba(255, 99, 132, 0.7)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `Qty: ${context.raw}`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
</script>
</body>
</html>
