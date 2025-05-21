<?php
session_start();
include("db_conn.php");

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

$products = mysqli_query($conn, "SELECT * FROM products");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <div class="sidebar">
      <h2>Dashboard</h2>
      <nav>
        <a href="dashboard.php">Inventory</a>
        <a href="users.php">Users</a>
        <a href="logout.php">Logout</a>
      </nav>
    </div>
    <div class="main">
      <div class="white-box">
        <h1>Product Inventory</h1>
        <table>
          <tr>
            <th>Name</th>
            <th>Quantity</th>
            <th>Actions</th>
          </tr>
          <?php while ($row = mysqli_fetch_assoc($products)) : ?>
          <tr>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['quantity']) ?></td>
            <td>
              <button class="edit-button">Edit</button>
              <button class="delete-button">Delete</button>
            </td>
          </tr>
          <?php endwhile; ?>
        </table>
      </div>
    </div>
  </div>
</body>
</html>