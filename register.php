<?php

session_start();
if (!isset($_SESSION['reg-errors'])) {
  $_SESSION['reg-errors'] = [];
}

unset($_SESSION['log-errors']);

function set($arr, $key)
{
  if (isset($_SESSION[$arr][$key])) {
    return $_SESSION[$arr][$key];
  }
}

if (isset($_SESSION['user'])) {
  header('Refresh: 0, url = /exam/login.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mini Blog | Register</title>
  <link rel="stylesheet/less" href="./assets/style.less">
  <script src="https://cdn.jsdelivr.net/npm/less"></script>
</head>

<body>
  <nav>
    <header>
      <h1>MiniBlog</h1>
      <a href="login.php">Login</a>
    </header>
  </nav>

  <div class="form">
    <h1>Register</h1>
    <form action="process/form-process.php" method="post" class="container">
      <input type="hidden" name="register" value="register">
      <h1>See Registration Rules</h1>
      <div class="form-input">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" placeholder="Enter username">
        <p><?= set('reg-errors', 'username') ?></p>
      </div>
      <div class="form-input">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" placeholder="Enter email">
        <p><?= set('reg-errors', 'email') ?></p>
      </div>
      <div class="form-input">
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" placeholder="Enter password">
        <p><?= set('reg-errors', 'password') ?></p>
      </div>
      <div class="form-input">
        <label for="password_confirm">Confirm Password:</label>
        <input type="password" name="password_confirm" id="password_confirm" placeholder="Confirm password">
        <p><?= set('reg-errors', 'password_confirm') ?></p>
      </div>

      <div class="form-actions">
        <button type="submit">Register</button>
      </div>
      <p>Return to <a href="login.php" style="color: orange;">Login Page</a></p>
    </form>
  </div>
  <?php $_SESSION['reg-errors'] = array(); ?>
</body>

</html>