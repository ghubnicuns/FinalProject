<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

$host = 'localhost';
$dbname = 'ims';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query("SELECT * FROM products ORDER BY product_id DESC");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $activityStmt = $pdo->query("SELECT * FROM activity_log ORDER BY timestamp DESC LIMIT 5");
    $activities = $activityStmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die("Database error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Project Storemai</title>
  <link rel="stylesheet" href="styles.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body>
  <div class="home-container">
    <aside class="sidebar">
      <h2>PROJECT STOREMAI</h2>
      <nav>
        <a href="#"><i class="fas fa-home"></i> Dashboard</a>
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
      <header class="top-bar">
        <div class="metrics">
          <div class="card">
            <i class="fas fa-box"></i>
            <p>Total Stock</p>
            <h3>
              <?php
              $total = 0;
              foreach ($products as $product) {
                  $total += (int)$product['product_quantity'];
              }
              echo number_format($total);
              ?>
            </h3>
          </div>
          <div class="card">
            <i class="fas fa-arrow-down"></i>
            <p>Low Stock</p>
            <h3>
              <?php
              $lowStock = 0;
              foreach ($products as $product) {
                  if ((int)$product['product_quantity'] <= 50) {
                      $lowStock++;
                  }
              }
              echo $lowStock;
              ?>
            </h3>
          </div>
          <div class="card">
            <i class="fas fa-user-tie"></i>
            <p>Total Suppliers</p>
            <h3>15</h3>
          </div>
          <div class="card">
            <i class="fas fa-truck-fast"></i>
            <p>Orders This Month</p>
            <h3>125</h3>
          </div>
        </div>
      </header>

      <section class="content">
        <div class="inventory">
          <h2>Inventory Overview</h2>
          <table>
            <thead>
              <tr>
                <th>Item Name</th>
                <th>SKU</th>
                <th>Quantity</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($products as $product): ?>
                <tr>
                  <td><?php echo htmlspecialchars($product['product_name']); ?></td>
                  <td><?php echo 'SKU' . str_pad($product['product_id'], 4, '0', STR_PAD_LEFT); ?></td>
                  <td><?php echo (int)$product['product_quantity']; ?></td>
                  <td class="<?php 
                      $qty = (int)$product['product_quantity'];
                      echo $qty == 0 ? 'out-of-stock' : ($qty <= 50 ? 'low-stock' : 'in-stock');
                  ?>">
                    <?php 
                      echo $qty == 0 ? 'OUT OF STOCK' : ($qty <= 50 ? 'LOW STOCK' : 'IN STOCK');
                    ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>

        <div class="right-column">
          <div class="recent-activity">
            <h2>Recent Activity</h2>
            <?php if (!empty($activities)): ?>
              <?php foreach ($activities as $log): ?>
                <p><?php echo htmlspecialchars($log['activity']); ?> – <?php echo date("F j, Y, g:i a", strtotime($log['timestamp'])); ?></p>
              <?php endforeach; ?>
            <?php else: ?>
              <p>No recent activity.</p>
            <?php endif; ?>
          </div>

          <div class="low-stock-alerts">
            <h2>Low Stock Alerts</h2>
            <ul>
              <?php foreach ($products as $product): ?>
                <?php if ((int)$product['product_quantity'] <= 50): ?>
                  <li><?php echo htmlspecialchars($product['product_name']); ?> – <?php echo (int)$product['product_quantity']; ?></li>
                <?php endif; ?>
              <?php endforeach; ?>
            </ul>
          </div>
        </div>
      </section>
    </main>
  </div>
</body>
</html>