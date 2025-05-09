<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Inventory Table</title>
  <link rel="stylesheet" href="stylesheetinbintury.css">
</head>
<body>

<div class="sidebar">
    <h2>PROJECT STOREMAI</h2>
    <div class="menu-item">DASHBOARD</div>
    <div class="menu-item active">INVENTORY</div>
    <div class="menu-item">USER</div>
    <div class="menu-item">REPORTS</div>
    <div class="menu-item">PRODUCTS</div>
</div>

<div class="table-container">
    <H1 class="H1">INVENTORY OVERVIEW</H1>
    <table class="table">
      <thead>
        <tr class="table-thead">
          <th>ITEM NAME</th>
          <th>CATEGORY</th>
          <th>STOCK</th>
          <th>STATUS</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>PRODUCT A</td>
          <td>ITEMS</td>
          <td>122</td>
          <td><span class="status in-stock">IN STOCK</span></td>
        </tr>
        <tr>
          <td>PRODUCT B</td>
          <td>ITEMS</td>
          <td>32</td>
          <td><span class="status low-stock">LOW STOCK</span></td>
        </tr>
        <tr>
          <td>PRODUCT C</td>
          <td>ITEMS</td>
          <td>111</td>
          <td><span class="status in-stock">IN STOCK</span></td>
        </tr>
        <tr>
          <td>PRODUCT D</td>
          <td>ITEMS</td>
          <td>52</td>
          <td><span class="status low-stock">LOW STOCK</span></td>
        </tr>
        <tr>
          <td>PRODUCT E</td>
          <td>ITEMS</td>
          <td>10</td>
          <td><span class="status out-stock">OUT OF STOCK</span></td>
        </tr>
        <tr>
          <td>PRODUCT F</td>
          <td>ITEMS</td>
          <td>122</td>
          <td><span class="status in-stock">IN STOCK</span></td>
        </tr>
      </tbody>
    </table>
</div>

</body>
</html>
