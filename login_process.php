<?php
session_start();

// Database connection parameters
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
 * Check if user is registered and credentials are valid
 * @param string $uname - Username input
 * @param string $pword - Password input
 * @param mysqli $conn - Database connection
 * @return array - [bool success, string message]
 */
function checkUserCredentials($uname, $pword, $conn) {
    // Prepare SQL statement to select user by username
    $stmt = $conn->prepare("SELECT id, fname, uname, pword FROM user WHERE uname = ?");
    if ($stmt === false) {
        return [false, "Database error: " . $conn->error];
    }
    $stmt->bind_param("s", $uname);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        // Username does not exist
        return [false, "User not registered"];
    }

    $user = $result->fetch_assoc();
    // Verify password
    if (password_verify($pword, $user['pword'])) {
        // Password correct
        return [true, $user];
    } else {
        return [false, "Incorrect password"];
    }
}

// Process the login form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['uname']) && isset($_POST['pword'])) {
        $uname = trim($_POST['uname']);
        $pword = $_POST['pword'];

        list($success, $data) = checkUserCredentials($uname, $pword, $conn);

        if ($success) {
            // Set session variables
            $_SESSION['user_id'] = $data['id'];
            $_SESSION['user_name'] = $data['fname'];
            $_SESSION['logged_in'] = true;

            // Redirect to dashboard or home page
            header("Location: homepage.php");
            exit();
        } else {
            // Authentication failed; set message and redirect back to login page
            $_SESSION['msg'] = $data; // error message like "User not registered" or "Incorrect password"
            header("Location: login.php");
            exit();
        }
    } else {
        $_SESSION['msg'] = "Please enter username and password";
        header("Location: login.php");
        exit();
    }
} else {
    // If not POST, redirect to login form
    header("Location: login.php");
    exit();
}
?>
