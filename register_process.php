<?php

// Get form data
$fname = $_POST['fname'];
$uname = $_POST['uname'];
$pword = $_POST['pword'];

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

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO user (fname, uname, pword) VALUES (?, ?, ?)");
if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

// Hash the password
$hashed_password = password_hash($pword, PASSWORD_DEFAULT);

// Bind parameters
$stmt->bind_param("sss", $fname, $uname, $hashed_password);

// Execute the statement
if ($stmt->execute()) {
    echo "New record created successfully";
    // Redirect to a success page or login page
    header("Location: success.php");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
