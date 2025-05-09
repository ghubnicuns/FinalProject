<?php
   ob_start();
   session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Project StoreMai Login</title>
  <link rel="stylesheet" href="stylesheet.css">
</head>
<body>
<?php
      $msg = '';
      $users = ['root'=>"admin", "cuns"=>"cunan", "guest"=>"abc123"];

      if (isset($_POST['login']) && !empty($_POST['username']) 
      && !empty($_POST['password'])) {
         $user=$_POST['username'];                  
         if (array_key_exists($user, $users)){
            if ($users[$_POST['username']]==$_POST['password']){
               $_SESSION['valid'] = true;
               $_SESSION['timeout'] = time();
               $_SESSION['username'] = $_POST['username'];
               $msg = "Login success!";
            }
            else {
               $msg = "You have entered wrong Password";
            }
         }
         else {
            $msg = "You have entered wrong user name";
         }
      }
   ?>
<div class="login-box">
  <h1>PROJECT STOREMai</h1>
  <p class="login-title">LOGIN PAGE</p>
  <form class="login-form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
    <div>
       <label for="username">Username:</label>
       <input type="text" name="username" id="name">
    </div>
    <div>
       <label for="password">Password:</label>
       <input type="password" name="password" id="password">
    </div>
    <section>
       <button type="submit" name="login">Login</button>
    </section>
    <div class="social-icons">
      <img src="facebook-logo_1080029-107.png" alt="Facebook">
      <img src="gmail.png" alt="Gmail">
      <img src="inta.png" alt="Instagram">
      <img src="more.png" alt="More">
    </div>
    <p class="register-link">
      Don't have an account? <a href="register.php">Register here</a>
    </p>
  </form>

  <h4 style="color:red;"><?php echo $msg; ?></h4>

  <p style="margin-left: 2rem;"> 
     <a href="logout.php" title="Logout">Click here to clean Session.</a>
  </p>
</div>
</body>
</html>
