<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Project Storemai</title>
  <link rel="stylesheet" href="homepage.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <aside class="sidebar">
          <h2>PROJECT STOREMAI</h2>
          <nav>
            <a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
            <a href="inventory.php"><i class="fas fa-boxes-stacked"></i> Inventory</a>
            <a href="user.php"><i class="fas fa-users"></i> User</a>
            <a href="reports.php"><i class="fas fa-chart-line"></i> Reports</a>
            <a href="products.php"><i class="fas fa-tags"></i> Products</a>
          </nav>
        </aside>

        <main class="main-content">
            <header class="top-bar">
              <div class="metrics">
                <div class="card"><i class="fas fa-box"></i><p>Total Stock</p><h3>3,500</h3></div>
                <div class="card"><i class="fas fa-arrow-down"></i><p>Low Stock</p><h3>60</h3></div>
                <div class="card"><i class="fas fa-user-tie"></i><p>Total Suppliers</p><h3>15</h3></div>
                <div class="card"><i class="fas fa-truck-fast"></i><p>Orders This Month</p><h3>125</h3></div>
              </div>
            </header>

            <section class="content">
                <div class="inventory">
                    <h2>Inventory Overview</h2>
                    <table>
                        <tr>
                            <th>Item Name</th>
                            <th>SKU</th>
                            <th>Category</th>
                            <th>Status</th>
                        </tr>
                        <tr><td>Product A</td><td>ITEMS</td><td>125</td><td class="in-stock">IN STOCK</td></tr>
                        <tr><td>Product B</td><td>ITEMS</td><td>32</td><td class="low-stock">LOW STOCK</td></tr>
                        <tr><td>Product C</td><td>ITEMS</td><td>115</td><td class="in-stock">IN STOCK</td></tr>
                        <tr><td>Product D</td><td>ITEMS</td><td>50</td><td class="low-stock">LOW STOCK</td></tr>
                        <tr><td>Product E</td><td>ITEMS</td><td>11</td><td class="out-of-stock">OUT OF STOCK</td></tr>
                        <tr><td>Product F</td><td>ITEMS</td><td>130</td><td class="in-stock">IN STOCK</td></tr>
                    </table>
                </div>

                <div class="right-column">
                    <div class="recent-activity">
                        <h2>Recent Activity</h2>
                        <p>Order #1234 was placed – 30 minutes ago</p>
                        <p>Item 'Product B' marked as low stock – 1 hour ago</p>
                        <p>Inventory count updated for 'Product A' – 1 hour ago</p>
                    </div>

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
