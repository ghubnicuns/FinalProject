<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// Enforce admin-only access
if ($_SESSION['user_role'] !== 'admin') {
    echo "<p style='padding:20px; font-family:sans-serif;'>Access denied. Only admins can manage users. Redirecting...</p>";
    echo "<script>setTimeout(() => { window.location.href = 'homepage.php'; }, 3000);</script>";
    exit();
}

// Database connection
$conn = new mysqli("localhost", "root", "", "ims");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Delete user if requested
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->close();
    header("Location: users.php");
    exit();
}

// Fetch users and their last login time directly from users table
$sql = "SELECT id, fname, uname, last_login FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Users - Project Storemai</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<div class="home-container">
    <aside class="sidebar">
        <h2>PROJECT STOREMAI</h2>
        <nav>
                <a href="homepage.php"><i class="fas fa-home"></i> Dashboard</a>
                <a href="inventory.php"><i class="fas fa-boxes-stacked"></i> Inventory</a>
                <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
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
        <section class="usermgmt-container">
            <h3>User Monitoring</h3>
            <table class="usermgmt-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Username</th>
                        <th>Last Login</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['id']) ?></td>
                                <td><?= htmlspecialchars($row['fname']) ?></td>
                                <td><?= htmlspecialchars($row['uname']) ?></td>
                                <td>
                                    <?= $row['last_login']
                                        ? htmlspecialchars($row['last_login'])
                                        : '<span class="usermgmt-no-login">Not yet logged in</span>' ?>
                                </td>
                                <td class="usermgmt-action-buttons">
                                    <a href="users.php?delete=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">No users found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
    </main>
</div>
</body>
</html>

<?php
$conn->close();
?>