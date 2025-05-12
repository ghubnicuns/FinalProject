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

<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        margin: 0; padding: 0; background-color: #f9f9f9;
    }
    .container {
        display: flex;
        min-height: 100vh;
    }
    .sidebar {
        background-color: #2c3e50;
        width: 200px;
        color: white;
        padding: 20px;
        box-sizing: border-box;
        display: flex;
        flex-direction: column;
        gap: 15px;
        font-weight: bold;
        font-size: 14px;
        user-select: none;
    }
    .sidebar .menu-item {
        padding: 10px;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.3s;
    }
    .sidebar .menu-item:hover {
        background-color: #34495e;
    }
    main.main-content {
        flex: 1;
        display: flex;
        flex-direction: column;
        background-color: white;
        padding: 20px;
        box-sizing: border-box;
        max-width: 100%;
    }
    header.topbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }
    header.topbar h1 {
        margin: 0;
        font-size: 1.8rem;
        color: #34495e;
    }
    .topbar-icons {
        display: flex;
        gap: 10px;
        align-items: center;
    }
    .topbar-icons input[type="text"] {
        padding: 6px 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    .topbar-icons button {
        font-size: 1.2rem;
        background: none;
        border: none;
        cursor: pointer;
        padding: 6px 10px;
        border-radius: 5px;
        transition: background-color 0.2s;
    }
    .topbar-icons button:hover {
        background-color: #ecf0f1;
    }
    .message {
        color: #e74c3c;
        font-weight: 600;
        text-align: center;
        margin-bottom: 15px;
    }
    button.edit-button {
        background-color: #2980b9;
        color: white;
        padding: 10px 20px;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        font-weight: 600;
        margin-bottom: 20px;
        font-size: 16px;
        transition: background-color 0.3s;
    }
    button.edit-button:hover {
        background-color: #1c5980;
    }
    #editor-section {
        display: none;
        background-color: #f1f5f8;
        padding: 20px;
        border-radius: 8px;
        max-width: 600px;
        margin-bottom: 30px;
    }
    #editor-section h2 {
        margin-top: 0;
        margin-bottom: 15px;
        color: #2c3e50;
    }
    form#add-product-form,
    form.edit-product-form {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    input[type="text"], input[type="number"], textarea {
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
        font-size: 14px;
        font-family: inherit;
        resize: vertical;
    }
    textarea {
        min-height: 70px;
    }
    button[type="submit"] {
        background-color: #27ae60;
        border: none;
        padding: 10px;
        color: white;
        font-weight: 600;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.3s;
    }
    button[type="submit"]:hover {
        background-color: #1e8449;
    }
    .product-card {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        margin-bottom: 15px;
        padding: 15px;
        display: flex;
        flex-direction: column;
        gap: 10px;
        max-width: 600px;
    }
    .product-info h3 {
        margin: 0;
        color: #34495e;
        font-size: 1.3rem;
    }
    .product-info p {
        margin: 3px 0;
        font-size: 14px;
        color: #555;
    }
    .product-info details summary {
        cursor: pointer;
        font-weight: 600;
        color: #2980b9;
    }
    .actions {
        display: flex;
        gap: 10px;
    }
    .delete-button,
    .edit-toggle-btn {
        background-color: #e74c3c;
        border: none;
        padding: 7px 14px;
        color: white;
        font-weight: 600;
        font-size: 14px;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.3s;
    }
    .edit-toggle-btn {
        background-color: #2980b9;
    }
    .delete-button:hover {
        background-color: #c0392b;
    }
    .edit-toggle-btn:hover {
        background-color: #1c5980;
    }
    .edit-product-form {
        display: none;
        background-color: #ecf0f1;
        padding: 15px;
        border-radius: 8px;
        margin-top: 10px;
    }
    .edit-product-form.active {
        display: flex;
    }

    /* Mobile responsiveness */
    @media (max-width: 600px) {
        .container {
            flex-direction: column;
        }
        .sidebar {
            width: 100%;
            flex-direction: row;
            overflow-x: auto;
            padding: 10px 5px;
            gap: 10px;
        }
        main.main-content {
            padding: 15px 10px;
            max-width: 100%;
        }
        .product-card {
            max-width: 100%;
        }
        #editor-section {
            max-width: 100%;
        }
    }
  </style>

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
        <div class="topbar-icons">
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

