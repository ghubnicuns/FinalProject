<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Project Storemail</title>
  <link rel="stylesheet" href="inventory.css">
</head>
<body>
  <div class="container">
    <!-- Sidebar -->
    <aside class="sidebar">
      <h2 class="logo">PROJECT STOREmail</h2>
      <nav class="menu">
        <a href="dash.php" class="menu-item">Dashboard</a>
        <a href="#" class="menu-item">Inventory</a>
        <a href="users.php" class="menu-item">User</a>
        <a href="#reports.php" class="menu-item">Reports</a>
        <a href="add.php" class="menu-item">Products</a>
      </nav>
    </aside>

    <!-- Main content -->
    <main class="main-content">
      <header class="top-bar">
        <input type="text" placeholder="Search..." class="search-box">
        <div class="icons">
          <span class="icon">🔔</span>
          <span class="icon">👤</span>
        </div>
      </header>

      <section class="inventory-overview">
        <h2>Inventory Overview</h2>
        <table>
          <thead>
            <tr>
              <th>Item Name</th>
              <th>Category</th>
              <th>Stock</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Product A</td>
              <td>Items</td>
              <td>122</td>
              <td><span class="status in-stock">In Stock</span></td>
            </tr>
            <tr>
              <td>Product B</td>
              <td>Items</td>
              <td>32</td>
              <td><span class="status low-stock">Low Stock</span></td>
            </tr>
            <tr>
              <td>Product C</td>
              <td>Items</td>
              <td>111</td>
              <td><span class="status in-stock">In Stock</span></td>
            </tr>
            <tr>
              <td>Product D</td>
              <td>Items</td>
              <td>52</td>
              <td><span class="status low-stock">Low Stock</span></td>
            </tr>
            <tr>
              <td>Product E</td>
              <td>Items</td>
              <td>10</td>
              <td><span class="status out-stock">Out of Stock</span></td>
            </tr>
            <tr>
              <td>Product F</td>
              <td>Items</td>
              <td>122</td>
              <td><span class="status in-stock">In Stock</span></td>
            </tr>
          </tbody>
        </table>
      </section>
    </main>
  </div>
</body>
</html>
