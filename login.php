<?php
session_start();
$msg = ''; // Initialize message variable

// Display any message if set
if (isset($_SESSION['msg'])) {
    $msg = $_SESSION['msg'];
    unset($_SESSION['msg']); // Clear the message after displaying
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login Page</title>
   <link rel="stylesheet" href="styles.css">
</head>
<body>
   <div class="container">
      <form class="register-box" action="dash.php" method="post"> <!-- Point to the action page -->
         <h1>Log in</h1>
         <input type="text" placeholder="Username" name="username" id="name" required>
         <input type="password" placeholder="Password" name="password" id="password" required>
         <button type="submit" name="login">Login</button>

         <p class="continue-text">Continue with:</p>
         <div class="social-icons">
            <img src="https://img.icons8.com/color/48/facebook.png" alt="Facebook">
            <img src="https://img.icons8.com/color/48/gmail--v1.png" alt="Gmail">
            <img src="https://img.icons8.com/fluency/48/instagram-new.png" alt="Instagram">
            <img src="https://img.icons8.com/ios-filled/48/000000/more.png" alt="More">
         </div>

         <p class="login-link">Don't have an account? <a href="register.php">Register</a></p>
      </form>
      <div class="message-box">
         <h4><?php echo htmlspecialchars($msg); ?></h4>
         <p><a href="logout.php" title="Logout">Click here to clean Session.</a></p>
      </div>
   </div>
</body>
</html>
