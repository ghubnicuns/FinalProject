<?php 
session_start();

// Auth check
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// Enforce admin-only access using 'role' from your SQL schema
if ($_SESSION['user_role'] !== 'admin') {
    echo "<p style='padding:20px; font-family:sans-serif;'>Access denied. Only admins can manage users. Redirecting...</p>";
    echo "<script>setTimeout(() => { window.location.href = 'homepage.php'; }, 3000);</script>";
    exit();
}

// DB connection
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

// Fetch product names and quantities for inventory overview
$chartDataStmt = $pdo->query("SELECT product_name, product_quantity FROM products");
$chartData = $chartDataStmt->fetchAll(PDO::FETCH_ASSOC);

$productNames = [];
$productQuantities = [];
$lowStockNames = [];
$lowStockQuantities = [];

foreach ($chartData as $row) {
    $productNames[] = $row['product_name'];
    $productQuantities[] = (int)$row['product_quantity'];

    if ($row['product_quantity'] <= 20) {
        $lowStockNames[] = $row['product_name'];
        $lowStockQuantities[] = (int)$row['product_quantity'];
    }
}

// Monthly Sales Data (last 6 months)
// We'll get last 6 months from current date, including months with zero sales

// Prepare date range for last 6 months
$months = [];
for ($i = 5; $i >= 0; $i--) {
    $months[] = date('Y-m', strtotime("-$i month"));
}

// Fetch sales totals grouped by month
$salesStmt = $pdo->prepare("
    SELECT DATE_FORMAT(sale_date, '%Y-%m') AS month, SUM(total_price) AS total_sales
    FROM sales
    WHERE sale_date >= :start_date
    GROUP BY month
");
$startDate = date('Y-m-01', strtotime("-5 months")); // first day of month 5 months ago
$salesStmt->execute(['start_date' => $startDate]);
$salesData = $salesStmt->fetchAll(PDO::FETCH_ASSOC);

// Map sales data to array keyed by month for easy lookup
$salesMap = [];
foreach ($salesData as $row) {
    $salesMap[$row['month']] = (float)$row['total_sales'];
}

// Fill salesTotals for all months (0 if no data)
$salesMonths = $months;
$salesTotals = [];
foreach ($months as $m) {
    $salesTotals[] = $salesMap[$m] ?? 0;
}

// Inventory Movement History (Recent Logs)
$inventoryHistoryStmt = $pdo->query("
    SELECT h.stock_date, p.product_name, h.product_quantity
    FROM product_stock_history h
    JOIN products p ON h.product_id = p.product_id
    ORDER BY h.stock_date DESC
    LIMIT 10
");
$inventoryLogs = $inventoryHistoryStmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Reports - Project Storemai</title>
    <link rel="stylesheet" href="styles.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="home-container">
        <aside class="sidebar">
            <h2>PROJECT STOREMAI</h2>
            <nav>
                <a href="homepage.php"><i class="fas fa-home"></i> Dashboard</a>
                <a href="inventory.php"><i class="fas fa-boxes-stacked"></i> Inventory</a>
                <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                    <a href="users.php"><i class="fas fa-users"></i> Users</a>
                    <a href="reports.php"><i class="fas fa-chart-line"></i> Reports</a>
                <?php endif; ?>
                <a href="products.php"><i class="fas fa-tags"></i> Products</a>
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

            <section class="chart-container">
                <h3>Monthly Sales Report (Last 6 Months)</h3>
                <canvas id="salesChart"></canvas>
            </section>

            <section class="chart-container">
                <h3>Recent Inventory Movement Logs</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Product</th>
                            <th>Quantity Changed</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($inventoryLogs): ?>
                            <?php foreach ($inventoryLogs as $log): ?>
                                <tr>
                                    <td><?= htmlspecialchars($log['stock_date']) ?></td>
                                    <td><?= htmlspecialchars($log['product_name']) ?></td>
                                    <td><?= htmlspecialchars($log['product_quantity']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="3">No inventory movement logs found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>

    <!-- Embed PHP data for JS -->
    <script>
        const productNames = <?= json_encode($productNames) ?>;
        const productQuantities = <?= json_encode($productQuantities) ?>;
        const lowStockNames = <?= json_encode($lowStockNames) ?>;
        const lowStockQuantities = <?= json_encode($lowStockQuantities) ?>;
        const salesMonths = <?= json_encode($salesMonths) ?>;
        const salesTotals = <?= json_encode($salesTotals) ?>;

        // Debugging (remove in production)
        console.log('Product Names:', productNames);
        console.log('Product Quantities:', productQuantities);
        console.log('Low Stock Names:', lowStockNames);
        console.log('Low Stock Quantities:', lowStockQuantities);
        console.log('Sales Months:', salesMonths);
        console.log('Sales Totals:', salesTotals);
    </script>

    <script src="charts.js"></script>
    <script src="salesChart.js"></script>
</body>
</html>
