<?php
session_start();

// DB config
$servername = "localhost";
$username = "root";
$password = "";
$database = "ims";

// Connect to database
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

/**
 * Check if user exists and verify password
 */
function checkUserCredentials($uname, $pword, $conn) {
    $stmt = $conn->prepare("SELECT id, fname, uname, pword, role FROM users WHERE uname = ?");
    if (!$stmt) return [false, "Database error: " . $conn->error];

    $stmt->bind_param("s", $uname);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        return [false, "User not registered"];
    }

    $user = $result->fetch_assoc();
    if (password_verify($pword, $user['pword'])) {
        return [true, $user];
    } else {
        return [false, "Incorrect password"];
    }
}

// Handle login submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!empty($_POST['uname']) && !empty($_POST['pword'])) {
        $uname = trim($_POST['uname']);
        $pword = $_POST['pword'];

        list($success, $data) = checkUserCredentials($uname, $pword, $conn);

        if ($success) {
            // Set session
            $_SESSION['user_id'] = $data['id'];
            $_SESSION['user_name'] = $data['fname'];
            $_SESSION['user_role'] = $data['role'];
            $_SESSION['logged_in'] = true;

            // Update last login
            $update = $conn->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
            $update->bind_param("i", $data['id']);
            $update->execute();
            $update->close();

            // Redirect to homepage (all users)
            header("Location: homepage.php");
            exit();
        } else {
            $_SESSION['msg'] = $data;
            header("Location: login.php");
            exit();
        }
    } else {
        $_SESSION['msg'] = "Please enter username and password";
        header("Location: login.php");
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}
?>
