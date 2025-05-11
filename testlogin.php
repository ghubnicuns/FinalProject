<?php
   ob_start();
   session_start();
   $msg = '';

   $users = [
      'root' => 'admin',
      'cuns' => 'cunan',
      'guest' => 'abc123'
   ];

   if (isset($_POST['login']) && !empty($_POST['username']) && !empty($_POST['password'])) {
      $user = $_POST['username'];
      if (array_key_exists($user, $users)) {
         if ($users[$user] == $_POST['password']) {
            $_SESSION['valid'] = true;
            $_SESSION['timeout'] = time();
            $_SESSION['username'] = $user;
            $msg = "Login success!";
         } else {
            $msg = "You have entered wrong Password";
         }
      } else {
         $msg = "You have entered wrong user name";
      }
   }
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login page</title>
   <link rel="stylesheet" href="styles.css">
   <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
</head>
<body>
   <div class="container">
      <form class="register-box" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
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
        <h4><?php echo $msg; ?></h4>
        <p><a href="logout.php" title="Logout">Click here to clean Session.</a></p>
      </div>
   </div>
</body>
</html>