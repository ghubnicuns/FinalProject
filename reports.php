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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="home-container">
    <aside class="sidebar">
        <h2>PROJECT STOREMAI</h2>
        <nav>
            <a href="homepage.php"><i class="fas fa-home"></i> Dashboard</a>
            <a href="inventory.php"><i class="fas fa-boxes-stacked"></i> Inventory</a>
            <a href="users.php"><i class="fas fa-users"></i> Users</a>
            <a href="reports.php"><i class="fas fa-chart-line"></i> Reports</a>
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

<!-- Embed PHP data for use in JS -->
<script>
    const productNames = <?= json_encode($productNames) ?>;
    const productQuantities = <?= json_encode($productQuantities) ?>;
    const lowStockNames = <?= json_encode($lowStockNames) ?>;
    const lowStockQuantities = <?= json_encode($lowStockQuantities) ?>;
</script>

<!-- External JavaScript file -->
<script src="charts.js"></script>
</body>
</html>
