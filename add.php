<?php
ob_start();
session_start();
$msg = '';

// Redirect if not logged in
if (!isset($_SESSION['valid'])) {
    header('Location: login.php');
    exit();
}

// Database connection
$host = 'localhost';
$dbname = 'ims';
$dbuser = 'root';
$dbpass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $dbuser, $dbpass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Handle product addition
if (isset($_POST['add_product'])) {
    $pname = trim($_POST['product_name']);
    $price = floatval($_POST['price']);
    $desc = trim($_POST['description']);

    if (!empty($pname) && $price > 0) {
        $stmt = $pdo->prepare("INSERT INTO products (product_name, product_price, pdescript) VALUES (:product_name, :product_price, :pdescript)");
        $stmt->execute([
            'product_name' => $pname,
            'product_price' => $price,
            'pdescript' => $desc,
        ]);
        $msg = "Product added successfully!";
    } else {
        $msg = "Please enter valid product details.";
    }
}

// Handle product editing
if (isset($_POST['edit_product'])) {
    $product_id = $_POST['product_id'];
    $pname = trim($_POST['product_name']);
    $price = floatval($_POST['price']);
    $desc = trim($_POST['description']);

    if (!empty($pname) && $price > 0) {
        $stmt = $pdo->prepare("UPDATE products SET product_name = :product_name, product_price = :product_price, pdescript = :pdescript WHERE product_id = :product_id");
        $stmt->execute([
            'product_name' => $pname,
            'product_price' => $price,
            'pdescript' => $desc,
            'product_id' => $product_id,
        ]);
        $msg = "Product updated successfully!";
    } else {
        $msg = "Please enter valid product details.";
    }
}

// Handle product deletion
if (isset($_POST['delete_product'])) {
    $product_id = $_POST['product_id'];
    $stmt = $pdo->prepare("DELETE FROM products WHERE product_id = :product_id");
    $stmt->execute(['product_id' => $product_id]);
    header("Location: add.php"); // Redirect back to the same page to avoid form resubmission
    exit();
}

// Fetch products
$productStmt = $pdo->query("SELECT * FROM products ORDER BY product_id DESC");
$products = $productStmt->fetchAll(PDO::FETCH_ASSOC);
?>

  <script>
    function toggleEditor() {
      const section = document.getElementById('editor-section');
      if (section.style.display === 'none' || section.style.display === '') {
        section.style.display = 'block';
      } else {
        section.style.display = 'none';
        // Close all open edit forms when hiding editor
        document.querySelectorAll('.edit-product-form').forEach(form => {
          form.classList.remove('active');
        });
      }
    }

    function toggleEditForm(productId) {
      const form = document.getElementById('edit-form-' + productId);
      if (form.classList.contains('active')) {
        form.classList.remove('active');
      } else {
        // Close any other open edit forms
        document.querySelectorAll('.edit-product-form').forEach(f => f.classList.remove('active'));
        form.classList.add('active');
      }
    }
  </script>
  
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Product Management</title>
  <link rel="stylesheet" href="what.css" />
</head>
<body>
  <div class="container">
    <aside class="sidebar">
      <div class="menu-item">🏠 DASHBOARD</div>
      <div class="menu-item">📦 INVENTORY</div>
      <div class="menu-item">👤 USER</div>
      <div class="menu-item">📊 REPORTS</div>
      <div class="menu-item">📝 PRODUCTS</div>
    </aside>

    <main class="main-content">
      <header class="topbar">
        <h1>PRODUCT MANAGEMENT</h1>
        <div class="sidebar-icons">
          <input type="text" placeholder="Search..." />
          <button>🔍</button>
          <button>🔔</button>
          <button>👤</button>
        </div>
      </header>

      <?php if (!empty($msg)): ?>
        <p class="message"><?= htmlspecialchars($msg) ?></p>
      <?php endif; ?>

      <button class="edit-button" onclick="toggleEditor()">EDIT PRODUCTS</button>

      <section id="editor-section">

        <!-- Add Product Form -->
        <form id="add-product-form" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
          <h2>Add Product</h2>
          <input type="text" name="product_name" placeholder="Product Name" required />
          <input type="number" step="0.01" name="price" placeholder="Price" required />
          <textarea name="description" placeholder="Description"></textarea>
          <button type="submit" name="add_product">Add Product</button>
        </form>

        <!-- Existing Products with Edit and Delete -->
        <?php if (!empty($products)): ?>
          <h2 style="margin-top: 30px;">Existing Products</h2>
          <?php foreach ($products as $product): ?>
            <div class="product-card">
              <div class="product-info">
                <h3><?= htmlspecialchars($product['product_name']) ?></h3>
                <p><strong>Price:</strong> $<?= number_format($product['product_price'], 2) ?></p>
                <details>
                  <summary>Description</summary>
                  <p><?= htmlspecialchars($product['pdescript']) ?></p>
                </details>
              </div>
              <div class="actions">
                <button class="edit-toggle-btn" type="button" onclick="toggleEditForm(<?= $product['product_id'] ?>)">Edit</button>
                <form method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" onsubmit="return confirm('Are you sure you want to delete this product?');" style="display:inline;">
                  <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                  <button type="submit" name="delete_product" class="delete-button">Delete</button>
                </form>
              </div>

              <!-- Edit Form -->
              <form class="edit-product-form" id="edit-form-<?= $product['product_id'] ?>" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
                <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                <input type="text" name="product_name" value="<?= htmlspecialchars($product['product_name']) ?>" required />
                <input type="number" step="0.01" name="price" value="<?= htmlspecialchars($product['product_price']) ?>" required />
                <textarea name="description"><?= htmlspecialchars($product['pdescript']) ?></textarea>
                <button type="submit" name="edit_product">Save Changes</button>
              </form>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p>No products found.</p>
        <?php endif; ?>
      </section>
    </main>
  </div>
</body>
</html>

