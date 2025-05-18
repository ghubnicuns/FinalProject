<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// Database connection
$host = 'localhost';
$dbname = 'ims';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die("Could not connect to the database: " . $e->getMessage());
}

$product_name = $product_price = $pdescript = "";
$success_message = $error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_name = trim($_POST['product_name'] ?? '');
    $product_price = trim($_POST['product_price'] ?? '');
    $pdescript = trim($_POST['pdescript'] ?? '');

    // Basic validation
    if ($product_name == "" || $product_price == "" || !is_numeric($product_price)) {
        $error_message = "Please fill all fields correctly. Price must be a number.";
    } else {
        // Insert into database
        $stmt = $pdo->prepare("INSERT INTO products (product_name, product_price, pdescript) VALUES (?, ?, ?)");
        if ($stmt->execute([$product_name, $product_price, $pdescript])) {
            $success_message = "Product added successfully!";
            // Clear fields after success
            $product_name = $product_price = $pdescript = "";
        } else {
            $error_message = "Failed to add product. Please try again.";
        }
    }
}

// Fetch all products
try {
    $products_stmt = $pdo->query("SELECT * FROM products ORDER BY product_id DESC");
    $products = $products_stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $error_message = "Could not retrieve products: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Add Product - Project Storemai</title>
  <link rel="stylesheet" href="styles.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body>
  <div class="home-container">
    <!-- Sidebar -->
    <aside class="sidebar">
      <h2>PROJECT STOREMAI</h2>
      <nav>
        <a href="homepage.php"><i class="fas fa-home"></i> Dashboard</a>
        <a href="inventory.php"><i class="fas fa-boxes-stacked"></i> Inventory</a>
        <a href="users.php"><i class="fas fa-users"></i> Users</a>
        <a href="reports.php"><i class="fas fa-chart-line"></i> Reports</a>
        <a href="#" class="active"><i class="fas fa-tags"></i>Products</a>
      </nav>
      <div class="logout-container">
        <a href="logout.php" class="logout-button"><i class="fas fa-sign-out-alt"></i> Logout</a>
      </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
      <section class="content">
        <div class="white-box" style="max-width:500px; margin: auto 0 40px;">
          <h1>Add New Product</h1>

          <?php if ($success_message): ?>
            <p class="message"><?php echo htmlspecialchars($success_message); ?></p>
          <?php endif; ?>
          <?php if ($error_message): ?>
            <p class="message error"><?php echo htmlspecialchars($error_message); ?></p>
          <?php endif; ?>

          <form method="POST" action="add_product.php" class="add-product-form">
            <label for="product_name">Product Name</label>
            <input 
              id="product_name"
              type="text" 
              name="product_name" 
              placeholder="Product Name" 
              value="<?php echo htmlspecialchars($product_name); ?>" 
              required
            />

            <label for="product_price">Product Price</label>
            <input 
              id="product_price"
              type="text" 
              name="product_price" 
              placeholder="Product Price" 
              value="<?php echo htmlspecialchars($product_price); ?>" 
              required
            />

            <label for="pdescript">Product Description</label>
            <input 
              id="pdescript"
              type="text" 
              name="pdescript" 
              placeholder="Product Description" 
              value="<?php echo htmlspecialchars($pdescript); ?>" 
              required
            />

            <button type="submit">Add Product</button>
          </form>
        </div>

        <!-- Product List -->
        <div class="product-table">
          <h2>Existing Products</h2>
          <?php if (!empty($products)): ?>
          <table>
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Price (₱)</th>
                <th>Description</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($products as $product): ?>
                <tr>
                  <td><?php echo htmlspecialchars($product['product_id']); ?></td>
                  <td><?php echo htmlspecialchars($product['product_name']); ?></td>
                  <td><?php echo number_format($product['product_price'], 2); ?></td>
                  <td><?php echo htmlspecialchars($product['pdescript']); ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
          <?php else: ?>
            <p>No products added yet.</p>
          <?php endif; ?>
        </div>
      </section>
    </main>
  </div>
</body>
</html>
