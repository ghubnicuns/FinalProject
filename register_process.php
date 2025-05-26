<?php
session_start();

if (!isset($_POST['submit'])) {
    header("Location: register.php");
    exit();
}

// Get form data and sanitize
$fname = trim($_POST['fname']);
$uname = trim($_POST['uname']);
$pword = $_POST['pword'];

// Server-side validation: username must not contain spaces
if (preg_match('/\s/', $uname)) {
    $_SESSION['msg'] = "Username must not contain spaces.";
    header("Location: register.php");
    exit();
}

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$database = "ims";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ====== USERNAME EXISTENCE CHECK ======
// Prepare statement to check if username exists
$stmt_check = $conn->prepare("SELECT id FROM users WHERE uname = ?");
$stmt_check->bind_param("s", $uname);
$stmt_check->execute();
$stmt_check->store_result();

if ($stmt_check->num_rows > 0) {
    // Username exists already
    $_SESSION['msg'] = "Username already taken. Please choose another.";
    $stmt_check->close();
    $conn->close();
    header("Location: register.php");
    exit();
}
$stmt_check->close();

// Hash the password
$hashed_password = password_hash($pword, PASSWORD_DEFAULT);

// Prepare and bind to insert new user
$stmt = $conn->prepare("INSERT INTO users (fname, uname, pword) VALUES (?, ?, ?)");
if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("sss", $fname, $uname, $hashed_password);

if ($stmt->execute()) {
    $_SESSION['msg'] = "Registration successful! You can now log in.";
    header("Location: login.php");
    exit();
} else {
    $_SESSION['msg'] = "Error: " . $stmt->error;
    header("Location: register.php");
    exit();
}

$stmt->close();
$conn->close();
?>
