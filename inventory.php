<?php
session_start();

// Auth check
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
} catch (Exception $e) {
    die("DB connection failed: " . $e->getMessage());
}

$success_message = $error_message = "";

// Handle product deletion
if (isset($_GET['delete'])) {
    $delete_id = (int)$_GET['delete'];

    $stmt = $pdo->prepare("SELECT product_name FROM products WHERE product_id = ?");
    $stmt->execute([$delete_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        $stmt = $pdo->prepare("DELETE FROM products WHERE product_id = ?");
        if ($stmt->execute([$delete_id])) {
            $log = $pdo->prepare("INSERT INTO activity_log (activity) VALUES (?)");
            $log->execute(["Deleted product: " . $product['product_name']]);
            $success_message = "Product deleted successfully.";
        } else {
            $error_message = "Failed to delete product.";
        }
    } else {
        $error_message = "Product not found.";
    }
}

// Handle product update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_product'])) {
    $id = (int)$_POST['product_id'];
    $name = trim($_POST['product_name']);
    $category = trim($_POST['product_category']);
    $price = trim($_POST['product_price']);
    $qty = trim($_POST['product_quantity']);
    $desc = trim($_POST['pdescript']);

    if ($name === '' || $category === '' || !is_numeric($price) || !is_numeric($qty)) {
        $error_message = "Please fill all fields correctly.";
    } else {
        $stmt = $pdo->prepare("UPDATE products SET product_name = ?, product_category = ?, product_price = ?, product_quantity = ?, pdescript = ? WHERE product_id = ?");
        if ($stmt->execute([$name, $category, $price, $qty, $desc, $id])) {
            $log = $pdo->prepare("INSERT INTO activity_log (activity) VALUES (?)");
            $log->execute(["Updated product: $name"]);
            $success_message = "Product updated successfully.";
        } else {
            $error_message = "Failed to update product.";
        }
    }
}

$stmt = $pdo->query("SELECT * FROM products ORDER BY product_id DESC");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
$edit_id = $_GET['edit'] ?? null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Inventory - Project Storemai</title>
  <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<div class="home-container">
  <aside class="sidebar">
    <h2>PROJECT STOREMAI</h2>
    <nav>
        <a href="homepage.php"><i class="fas fa-home"></i> Dashboard</a>
        <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
          <a href="inventory.php"><i class="fas fa-boxes-stacked"></i> Inventory</a>
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
    <section class="content">
      <div class="inventory-box">
        <h1>Inventory Management</h1>

        <?php if ($success_message): ?>
          <p class="message"><?php echo htmlspecialchars($success_message); ?></p>
        <?php elseif ($error_message): ?>
          <p class="message error"><?php echo htmlspecialchars($error_message); ?></p>
        <?php endif; ?>

        <table class="inventory-table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Category</th>
              <th>Price (₱)</th>
              <th>Qty</th>
              <th>Description</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach ($products as $product): ?>
            <?php if ($edit_id == $product['product_id']): ?>
              <form method="POST" action="inventory.php" class="edit-form">
                <tr>
                  <td><?php echo $product['product_id']; ?></td>
                  <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                  <td><input type="text" name="product_name" value="<?php echo htmlspecialchars($product['product_name']); ?>" required></td>
                  <td><input type="text" name="product_category" value="<?php echo htmlspecialchars($product['product_category']); ?>" required></td>
                  <td><input type="text" name="product_price" value="<?php echo htmlspecialchars($product['product_price']); ?>" required></td>
                  <td><input type="text" name="product_quantity" value="<?php echo htmlspecialchars($product['product_quantity']); ?>" required></td>
                  <td><input type="text" name="pdescript" value="<?php echo htmlspecialchars($product['pdescript']); ?>" required></td>
                  <td>
                    <button class="save-button" type="submit" name="update_product">Save</button>
                    <a href="inventory.php" class="cancel-button">Cancel</a>
                  </td>
                </tr>
              </form>
            <?php else: ?>
              <tr>
                <td><?php echo $product['product_id']; ?></td>
                <td><?php echo htmlspecialchars($product['product_name']); ?></td>
                <td><?php echo htmlspecialchars($product['product_category']); ?></td>
                <td><?php echo number_format($product['product_price'], 2); ?></td>
                <td><?php echo htmlspecialchars($product['product_quantity']); ?></td>
                <td><?php echo htmlspecialchars($product['pdescript']); ?></td>
                <td>
                  <a href="inventory.php?edit=<?php echo $product['product_id']; ?>">Edit</a> |
                  <a href="inventory.php?delete=<?php echo $product['product_id']; ?>" onclick="return confirm('Are you sure you want to delete this product?');" class="delete-button">Delete</a>
                </td>
              </tr>
            <?php endif; ?>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </section>
  </main>
</div>
</body>
</html>
