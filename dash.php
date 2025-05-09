<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inventory Dashboard</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      display: flex;
    }
    .sidebar {
      background: #d3d3d3;
      width: 220px;
      height: 100vh;
      padding: 20px 10px;
      box-sizing: border-box;
    }
    .sidebar h3 {
      margin-bottom: 30px;
    }
    .sidebar button {
      width: 100%;
      margin: 10px 0;
      padding: 10px;
      background: #aaa;
      border: none;
      font-weight: bold;
      cursor: pointer;
    }
    .sidebar .active {
      border-left: 5px solid #8A2BE2;
      background-color: #c2c2c2;
    }
    .main {
      flex: 1;
      padding: 20px;
      background: #f4f4f4;
    }
    .top-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .stats {
      display: flex;
      gap: 20px;
      margin: 20px 0;
    }
    .card {
      background: white;
      padding: 15px;
      border-radius: 8px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      text-align: center;
      flex: 1;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    table, th, td {
      border: 1px solid #ddd;
    }
    th, td {
      padding: 10px;
      text-align: left;
    }
    .status-in {
      color: green;
      font-weight: bold;
    }
    .status-low {
      color: orange;
      font-weight: bold;
    }
    .status-out {
      color: red;
      font-weight: bold;
    }
    .two-cols {
      display: flex;
      gap: 20px;
    }
    .half {
      flex: 1;
      background: white;
      padding: 10px;
      border-radius: 8px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
  </style>
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
            <tr><th>Item Name</th><th>SKU</th><th>Category</th><th>Status</th></tr>
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
