<?php
session_start();
$msg = '';

// ✅ Redirect to homepage if already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: homepage.php'); // Replace with your actual homepage
    exit();
}

// ✅ Show flash message if exists
if (isset($_SESSION['msg'])) {
    $msg = $_SESSION['msg'];
    unset($_SESSION['msg']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register Form</title>
  <link rel="stylesheet" href="styles.css">
  <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
</head>
<body>
  <div class="container">
    <form class="white-box" action="action_page.php" method='POST'>
      <h1>REGISTER</h1>
      <input type="text" placeholder="Name" name="fname" required>
      <input type="text" placeholder="Username" name="uname" required>
      <input type="password" placeholder="Password" name="pword" required>
      <button type="submit" name="submit">Sign Up</button>

      <p class="continue-text">Continue with:</p>
      <div class="social-icons">
        <img src="https://img.icons8.com/color/48/facebook.png" alt="Facebook">
        <img src="https://img.icons8.com/color/48/gmail--v1.png" alt="Gmail">
        <img src="https://img.icons8.com/fluency/48/instagram-new.png" alt="Instagram">
        <img src="https://img.icons8.com/ios-filled/48/000000/more.png" alt="More">
      </div>
      <p class="login-link">Already have an account? <a href="login.php">Log in</a></p>
    </form>
  </div>
</body>
</html>
