<?php
session_start();
// Simple auth check (adjust as needed)
if (!isset($_SESSION['valid'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Inventory Dashboard</title>
  <style>
    /* Basic reset and styling */
    body, html {
      margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f5f6fa;
      height: 100vh;
    }
    .sidebar {
      background-color: #2f3640;
      width: 180px;
      height: 100vh;
      padding: 1rem;
      color: #f5f6fa;
      box-sizing: border-box;
      display: flex;
      flex-direction: column;
      align-items: start;
    }
    .sidebar h3 {
      margin-bottom: 2rem;
      font-weight: 700;
      font-size: 1.4rem;
      user-select: none;
    }
    .sidebar a {
      width: 100%;
      margin-bottom: 10px;
    }
    .sidebar button {
      width: 100%;
      padding: 10px 0;
      font-size: 1rem;
      background-color: #353b48;
      border: none;
      color: #f5f6fa;
      border-radius: 5px;
      cursor: pointer;
      font-weight: 600;
      transition: background-color 0.3s;
    }
    .sidebar button:hover,
    .sidebar button.active {
      background-color: #00a8ff;
      color: #fff;
    }
    .main {
      margin-left: 180px;
      padding: 2rem;
      box-sizing: border-box;
      min-height: 100vh;
      background-color: #fff;
    }
    .top-bar {
      display: flex;
      justify-content: flex-start;
      margin-bottom: 1rem;
    }
    .stats {
      display: flex;
      gap: 1rem;
      flex-wrap: wrap;
    }
    .card {
      background-color: #00a8ff;
      color: #fff;
      padding: 1rem 2rem;
      border-radius: 8px;
      flex: 1 1 150px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      user-select: none;
    }
    .card h4 {
      margin: 0 0 0.5rem;
      font-weight: 600;
    }
    .card p {
      margin: 0;
      font-size: 1.4rem;
      font-weight: 700;
    }
    .two-cols {
      display: flex;
      gap: 2rem;
      flex-wrap: wrap;
      margin-top: 2rem;
    }
    .half {
      flex: 1 1 45%;
      background: #f0f2f5;
      padding: 1rem 1.5rem;
      border-radius: 8px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      max-height: 600px;
      overflow-y: auto;
    }
    .half h4 {
      margin-top: 0;
      margin-bottom: 1rem;
      font-weight: 600;
      color: #2f3640;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      user-select: none;
    }
    thead tr {
      background-color: #00a8ff;
      color: #fff;
    }
    th, td {
      padding: 0.8rem 1rem;
      border: 1px solid #dcdde1;
      text-align: left;
      font-size: 0.9rem;
    }
    tbody tr:hover {
      background-color: #dcdde1;
      cursor: default;
    }
    .status-in {
      color: #44bd32;
      font-weight: 700;
    }
    .status-low {
      color: #fbc531;
      font-weight: 700;
    }
    .status-out {
      color: #e84118;
      font-weight: 700;
    }
    ul {
      padding-left: 1.2rem;
      margin-top: 0;
      user-select: none;
    }
    ul li {
      margin-bottom: 0.6rem;
      font-size: 0.95rem;
      color: #353b48;
    }
    /* Make sidebar buttons links accessible and styled */
    .sidebar a button {
      all: unset;
      display: block;
      width: 100%;
      padding: 10px 0;
      text-align: center;
      font-weight: 600;
      cursor: pointer;
      border-radius: 5px;
      transition: background-color 0.3s;
      color: inherit;
      background-color: transparent;
    }
    .sidebar a button:hover,
    .sidebar a button.active {
      background-color: #00a8ff;
      color: #fff;
    }
    @media (max-width: 768px) {
      .container {
        flex-direction: column;
      }
      .sidebar {
        position: fixed;
        width: 100%;
        height: auto;
        display: flex;
        flex-direction: row;
        justify-content: space-around;
        padding: 10px 0;
        box-sizing: border-box;
        z-index: 10;
      }
      .sidebar h3 {
        display: none;
      }
      .sidebar a button {
        padding: 10px 6px;
        font-size: 0.9rem;
      }
      .main {
        margin-left: 0;
        margin-top: 70px;
        padding: 1rem;
      }
      .two-cols {
        flex-direction: column;
      }
      .half {
        max-height: none;
      }
    }
  </style>
</head>
<body>
  <div class="sidebar">
    <h3>PROJECT STOREMAI</h3>
    <a href="dashboard.php"><button>DASHBOARD</button></a>
    <a href="inventory_dashboard.php"><button class="active">INVENTORY</button></a>
    <a href="user.php"><button>USER</button></a>
    <a href="reports.php"><button>REPORTS</button></a>
    <a href="products.php"><button>PRODUCTS</button></a>
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

