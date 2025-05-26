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
   <title>Login Page</title>
   <link rel="stylesheet" href="styles.css">
   <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
</head>
<body>
   <div class="container">
      <form class="white-box" action="login_process.php" method="post">
         <h1>LOGIN</h1>
         <input type="text" placeholder="Username" name="uname" id="uname" required aria-label="Username">
         <input type="password" placeholder="Password" name="pword" id="pword" required aria-label="Password">
         <button type="submit" name="login">Login</button>
         <p class="login-link">Don't have an account? <a href="register.php">Register</a></p>
      </form>
      <div class="message-box">
         <h4><?php echo htmlspecialchars($msg); ?></h4>
      </div>
   </div>
</body>
</html>
