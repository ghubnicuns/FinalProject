<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit();
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
    <!-- Sidebar -->
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


    <!-- Main Content -->
    <main class="main-content">
      <!-- Dashboard Metrics -->
      <header class="top-bar">
        <div class="metrics">
          <div class="card">
            <i class="fas fa-box"></i>
            <p>Total Stock</p>
            <h3>3,500</h3>
          </div>
          <div class="card">
            <i class="fas fa-arrow-down"></i>
            <p>Low Stock</p>
            <h3>60</h3>
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

      <!-- Inventory + Right Column -->
      <section class="content">
        <!-- Inventory Table -->
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
              <tr>
                <td>Product A</td>
                <td>ITEM001</td>
                <td>125</td>
                <td class="in-stock">IN STOCK</td>
              </tr>
              <tr>
                <td>Product B</td>
                <td>ITEM002</td>
                <td>32</td>
                <td class="low-stock">LOW STOCK</td>
              </tr>
              <tr>
                <td>Product C</td>
                <td>ITEM003</td>
                <td>115</td>
                <td class="in-stock">IN STOCK</td>
              </tr>
              <tr>
                <td>Product D</td>
                <td>ITEM004</td>
                <td>50</td>
                <td class="low-stock">LOW STOCK</td>
              </tr>
              <tr>
                <td>Product E</td>
                <td>ITEM005</td>
                <td>11</td>
                <td class="out-of-stock">OUT OF STOCK</td>
              </tr>
              <tr>
                <td>Product F</td>
                <td>ITEM006</td>
                <td>130</td>
                <td class="in-stock">IN STOCK</td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Right Column -->
        <div class="right-column">
          <!-- Recent Activity -->
          <div class="recent-activity">
            <h2>Recent Activity</h2>
            <p>Order #1234 was placed – 30 minutes ago</p>
            <p>Item 'Product B' marked as low stock – 1 hour ago</p>
            <p>Inventory count updated for 'Product A' – 1 hour ago</p>
          </div>

          <!-- Low Stock Alerts -->
          <div class="low-stock-alerts">
            <h2>Low Stock Alerts</h2>
            <ul>
              <li>Product B – 32</li>
              <li>Product D – 50</li>
              <li>Product E – 11</li>
            </ul>
          </div>
        </div>
      </section>
    </main>
  </div>
</body>
</html>