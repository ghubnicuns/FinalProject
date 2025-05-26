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

// Register new user
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $fname = $_POST['fname'];
    $uname = $_POST['uname'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    // Check for duplicate username
    $check = $conn->prepare("SELECT id FROM users WHERE uname = ?");
    $check->bind_param("s", $uname);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $check->close();
        echo "<script>alert('Username already exists. Please choose another one.'); window.history.back();</script>";
        exit();
    }
    $check->close();

    // Proceed with insertion
    $stmt = $conn->prepare("INSERT INTO users (fname, uname, pword, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $fname, $uname, $password, $role);
    $stmt->execute();
    $stmt->close();
    header("Location: users.php");
    exit();
}

// Edit existing user
if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
    $edit_id = intval($_GET['edit']);
    $stmt = $conn->prepare("SELECT id, fname, uname, role FROM users WHERE id = ?");
    $stmt->bind_param("i", $edit_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();
}

// Update user details
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $update_id = $_POST['id'];
    $fname = $_POST['fname'];
    $uname = $_POST['uname'];
    $role = $_POST['role'];

    // Check if another user already has this username
    $check = $conn->prepare("SELECT id FROM users WHERE uname = ? AND id != ?");
    $check->bind_param("si", $uname, $update_id);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $check->close();
        echo "<script>alert('Username already exists. Please choose another one.'); window.history.back();</script>";
        exit();
    }
    $check->close();

    // Proceed with update
    $stmt = $conn->prepare("UPDATE users SET fname = ?, uname = ?, role = ? WHERE id = ?");
    $stmt->bind_param("sssi", $fname, $uname, $role, $update_id);
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
        <section class="usermgmt-container">
            <?php if (isset($user)): ?>
                <a href="users.php" class="back-button-g">Back</a>
            <?php endif; ?>
            <h3><?= isset($user) ? 'Edit User' : 'Register New User' ?></h3>
            <form class="white-box-regis" method="POST" action="users.php">
                <input type="hidden" name="id" value="<?= isset($user) ? htmlspecialchars($user['id']) : '' ?>">
                <label for="fname">Full Name:</label>
                <input type="text" name="fname" id="fname" required value="<?= isset($user) ? htmlspecialchars($user['fname']) : '' ?>">
                <label for="uname">Username:</label>
                <input type="text" name="uname" id="uname" required value="<?= isset($user) ? htmlspecialchars($user['uname']) : '' ?>">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" <?= isset($user) ? 'placeholder="Leave blank to keep current password"' : 'required' ?>>
                <label for="role">Role:</label>
                <select name="role" id="role" required>
                    <option value="user" <?= isset($user) && $user['role'] === 'user' ? 'selected' : '' ?>>User </option>
                    <option value="admin" <?= isset($user) && $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                </select>
                <button type="submit" name="<?= isset($user) ? 'update' : 'register' ?>"><?= isset($user) ? 'Update User' : 'Register User' ?></button>
            </form>
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
                                    <a href="users.php?edit=<?= $row['id'] ?>">Edit</a>
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
