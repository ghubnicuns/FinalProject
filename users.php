<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "ims";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Delete user if requested
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM user WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    header("Location: users.php");
    exit();
}

// Fetch users and their latest login time
$sql = "
    SELECT u.id, u.fname, u.uname, 
           (SELECT MAX(login_time) FROM user_logins ul WHERE ul.user_id = u.id) AS last_login 
    FROM user u
";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Users - Project Storemai</title>
    <link rel="stylesheet" href="styles.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <style>
        .user-table-container {
            margin: 40px auto;
            width: 90%;
            max-width: 1000px;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
        }

        .action-buttons a {
            margin-right: 10px;
            color: #e74c3c;
            text-decoration: none;
        }

        .action-buttons a:hover {
            text-decoration: underline;
        }

        body {
            background-color: #f5f5f5;
            font-family: Arial, sans-serif;
        }

        .main-content {
            padding: 20px;
        }

        .no-login {
            color: gray;
            font-style: italic;
        }
    </style>
</head>
<body>
<div class="home-container">
    <aside class="sidebar">
        <h2>PROJECT STOREMAI</h2>
        <nav>
            <a href="homepage.php"><i class="fas fa-home"></i> Dashboard</a>
            <a href="inventory.php"><i class="fas fa-boxes-stacked"></i> Inventory</a>
            <a href="users.php" class="active"><i class="fas fa-users"></i> Users</a>
            <a href="reports.php"><i class="fas fa-chart-line"></i> Reports</a>
            <a href="add_product.php"><i class="fas fa-tags"></i> Products</a>
        </nav>
        <div class="logout-container">
            <a href="logout.php" class="logout-button"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </aside>

    <main class="main-content">
        <section class="user-table-container">
            <h3>User Monitoring</h3>
            <table>
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
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['id']) ?></td>
                                <td><?= htmlspecialchars($row['fname']) ?></td>
                                <td><?= htmlspecialchars($row['uname']) ?></td>
                                <td>
                                    <?= $row['last_login']
                                        ? htmlspecialchars($row['last_login'])
                                        : '<span class="no-login">Not yet logged in</span>' ?>
                                </td>
                                <td class="action-buttons">
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
