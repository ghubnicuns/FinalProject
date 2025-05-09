<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add New Product</title>
  <link rel="stylesheet" href="what.css">
</head>
<body>

  <div class="container">
    <!-- Sidebar -->
    <aside class="sidebar">
      <div class="menu-item">🏠 DASHBOARD</div>
      <div class="menu-item">📦 INVENTORY</div>
      <div class="menu-item">👤 USER</div>
      <div class="menu-item">📊 REPORTS</div>
      <div class="menu-item">📝 PRODUCTS</div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
      <header class="topbar">
        <h1>ADD NEW PRODUCT</h1>
        <div class="topbar-icons">
          <input type="text" placeholder="Search...">
          <button>🔍</button>
          <button>🔔</button>
          <button>👤</button>
        </div>
      </header>

      <button class="edit-button">EDIT PRODUCTS</button>

      <!-- Product Cards -->
      <section class="product-list">
        <!-- Product Card -->
        <?php for ($i = 0; $i < 2; $i++): ?>
          <div class="product-card">
            <div class="image-placeholder">🖼</div>
            <div class="product-info">
              <h2>Product Name</h2>
              <p class="price">₱0.00</p>
              <p class="price-tag">Price tag</p>

              <div class="selectors">
                <label>
                  Label
                  <select><option>Value</option></select>
                </label>
                <label>
                  Label
                  <select><option>Value</option></select>
                </label>
              </div>

              <button class="purchase-button">Purchase</button>

              <details>
                <summary>Description</summary>
                <p>Product description goes here.</p>
              </details>
            </div>
          </div>
        <?php endfor; ?>
      </section>
    </main>
  </div>

</body>
</html>
