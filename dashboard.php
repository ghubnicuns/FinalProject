<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inventory Dashboard</title>
  <link rel="stylesheet" href="dash.css">
</head>
<body>
  <div class="sidebar">
    <h3>PROJECT STOREMAI</h3>
    <button>DASHBOARD</button>
    <button class="active">INVENTORY</button>
    <button>USER</button>
    <button>REPORTS</button>
    <button>PRODUCTS</button>
  </div>

  <div class="main">
    <div class="top-bar">
      <div class="stats">
        <div class="card">
          <h4>Total Stock</h4>
          <p>3,500</p>
        </div>
        <div class="card">
          <h4>Low Stock</h4>
          <p>60</p>
        </div>
        <div class="card">
          <h4>Total Suppliers</h4>
          <p>15</p>
        </div>
        <div class="card">
          <h4>Orders This Month</h4>
          <p>125</p>
        </div>
      </div>
    </div>

    <div class="two-cols">
      <div class="half">
        <h4>Inventory Overview</h4>
        <table>
          <thead>
            <tr>
              <th>Item Name</th>
              <th>SKU</th>
              <th>Category</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <tr><td>Product A</td><td>ITEMS</td><td>125</td><td class="status-in">IN STOCK</td></tr>
            <tr><td>Product B</td><td>ITEMS</td><td>32</td><td class="status-low">LOW STOCK</td></tr>
            <tr><td>Product C</td><td>ITEMS</td><td>115</td><td class="status-in">IN STOCK</td></tr>
            <tr><td>Product D</td><td>ITEMS</td><td>50</td><td class="status-low">LOW STOCK</td></tr>
            <tr><td>Product E</td><td>ITEMS</td><td>11</td><td class="status-out">OUT OF STOCK</td></tr>
            <tr><td>Product F</td><td>ITEMS</td><td>130</td><td class="status-in">IN STOCK</td></tr>
          </tbody>
        </table>

        <h4>Recent Activity</h4>
        <ul>
          <li>Order #1234 was placed - 30 minutes ago</li>
          <li>Item 'Product B' marked as low stock - 1 hour ago</li>
          <li>Inventory count updated for 'Product A' - 1 hour ago</li>
        </ul>
      </div>

      <div class="half">
        <h4>Low Stock Alerts</h4>
        <ul>
          <li>Product B - 32</li>
          <li>Product D - 50</li>
          <li>Product E - 11</li>
        </ul>
      </div>
    </div>
  </div>
</body>
</html>
