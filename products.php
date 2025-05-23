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

$product_name = $product_category = $product_price = $product_quantity = $pdescript = "";
$success_message = $error_message = "";

// Handle Add Product
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_product'])) {
    $product_name = trim($_POST['product_name'] ?? '');
    $product_category = trim($_POST['product_category'] ?? '');
    $product_price = trim($_POST['product_price'] ?? '');
    $product_quantity = trim($_POST['product_quantity'] ?? '');
    $pdescript = trim($_POST['pdescript'] ?? '');

    if (
        $product_name === "" || $product_category === "" || $product_price === "" || $product_quantity === "" ||
        !is_numeric($product_price) || !is_numeric($product_quantity)
    ) {
        $error_message = "Please fill all fields correctly. Price and quantity must be numbers.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO products (product_name, product_category, product_price, product_quantity, pdescript) VALUES (?, ?, ?, ?, ?)");
        if ($stmt->execute([$product_name, $product_category, $product_price, $product_quantity, $pdescript])) {
            $log = $pdo->prepare("INSERT INTO activity_log (activity) VALUES (?)");
            $log->execute(["Added product: $product_name (Qty: $product_quantity, Category: $product_category)"]);

            header("Location: products.php?success=1");
            exit();
        } else {
            $error_message = "Failed to add product. Please try again.";
        }
    }
}

// Handle Sale
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['record_sale'])) {
    $sale_product_id = $_POST['sale_product_id'] ?? '';
    $quantity_sold = $_POST['quantity_sold'] ?? '';

    if (!is_numeric($sale_product_id) || !is_numeric($quantity_sold) || $quantity_sold <= 0) {
        $error_message = "Invalid sale data. Please enter valid numbers.";
    } else {
        $productStmt = $pdo->prepare("SELECT product_price, product_quantity, product_name FROM products WHERE product_id = ?");
        $productStmt->execute([$sale_product_id]);
        $product = $productStmt->fetch(PDO::FETCH_ASSOC);

        if (!$product) {
            $error_message = "Product not found.";
        } elseif ($product['product_quantity'] < $quantity_sold) {
            $error_message = "Not enough stock available.";
        } else {
            $total_price = $product['product_price'] * $quantity_sold;

            $saleStmt = $pdo->prepare("INSERT INTO sales (sale_date, product_id, quantity_sold, total_price) VALUES (CURDATE(), ?, ?, ?)");
            $saleLogged = $saleStmt->execute([$sale_product_id, $quantity_sold, $total_price]);

            if ($saleLogged) {
                $updateStmt = $pdo->prepare("UPDATE products SET product_quantity = product_quantity - ? WHERE product_id = ?");
                $updateStmt->execute([$quantity_sold, $sale_product_id]);

                $log = $pdo->prepare("INSERT INTO activity_log (activity) VALUES (?)");
                $log->execute(["Sale recorded: $quantity_sold unit(s) of {$product['product_name']}"]);

                $success_message = "Sale recorded successfully.";
            } else {
                $error_message = "Failed to record sale.";
            }
        }
    }
}

if (isset($_GET['success']) && $_GET['success'] == 1) {
    $success_message = "Product added successfully!";
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
        <div class="white-box-product">
          <h2>Add New Product</h2>
          <?php if ($success_message): ?>
            <p class="message"><?php echo htmlspecialchars($success_message); ?></p>
          <?php endif; ?>
          <?php if ($error_message): ?>
            <p class="message error"><?php echo htmlspecialchars($error_message); ?></p>
          <?php endif; ?>
          <form method="POST" action="products.php" class="add-product-form">
            <input type="hidden" name="add_product" value="1" />
            <label for="product_name">Product Name</label>
            <input type="text" name="product_name" id="product_name" required value="<?php echo htmlspecialchars($product_name); ?>" />

            <label for="product_category">Product Category</label>
            <input type="text" name="product_category" id="product_category" required value="<?php echo htmlspecialchars($product_category); ?>" />

            <label for="product_price">Product Price</label>
            <input type="text" name="product_price" id="product_price" required value="<?php echo htmlspecialchars($product_price); ?>" />

            <label for="product_quantity">Product Quantity</label>
            <input type="text" name="product_quantity" id="product_quantity" required value="<?php echo htmlspecialchars($product_quantity); ?>" />

            <label for="pdescript">Product Description</label>
            <input type="text" name="pdescript" id="pdescript" required value="<?php echo htmlspecialchars($pdescript); ?>" />

            <button type="submit">Add Product</button>
          </form>
        </div>

        <div class="product-table">
          <h2>Existing Products</h2>
          <?php if (!empty($products)): ?>
          <table>
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Category</th>
                <th>Price (₱)</th>
                <th>Quantity</th>
                <th>Description</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($products as $product): ?>
                <tr>
                  <td><?php echo htmlspecialchars($product['product_id']); ?></td>
                  <td><?php echo htmlspecialchars($product['product_name']); ?></td>
                  <td><?php echo htmlspecialchars($product['product_category']); ?></td>
                  <td><?php echo number_format($product['product_price'], 2); ?></td>
                  <td><?php echo htmlspecialchars($product['product_quantity']); ?></td>
                  <td><?php echo htmlspecialchars($product['pdescript']); ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
          <?php else: ?>
            <p>No products added yet.</p>
          <?php endif; ?>
        </div>

        <!-- Sales Recording Section -->
        <div class="white-box-product">
          <h2>Record a Sale</h2>
          <form method="POST" action="products.php" class="add-product-form">
            <input type="hidden" name="record_sale" value="1" />

            <label for="sale_product_id">Select Product</label>
            <select name="sale_product_id" id="sale_product_id" required>
              <option value="">-- Select Product --</option>
              <?php foreach ($products as $product): ?>
                <option value="<?php echo $product['product_id']; ?>">
                  <?php echo htmlspecialchars($product['product_name']); ?> (Stock: <?php echo $product['product_quantity']; ?>)
                </option>
              <?php endforeach; ?>
            </select>

            <label for="quantity_sold">Quantity Sold</label>
            <input type="number" name="quantity_sold" id="quantity_sold" required min="1" />

            <button type="submit">Record Sale</button>
          </form>
        </div>
      </section>
    </main>
  </div>
</body>
</html>
