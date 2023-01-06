<?php

session_start();
if (!isset($_SESSION['log-errors'])) {
  $_SESSION['log-errors'] = [];
}

unset($_SESSION['reg-errors']);

function set($arr, $key)
{
  if (isset($_SESSION[$arr][$key])) {
    return $_SESSION[$arr][$key];
  }
}

if (isset($_SESSION['user'])) {
  header('Location: index.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mini Blog | Login</title>
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
    <form action="process/form-process.php" method="post" class="container">
      <input type="hidden" name="login" value="login">
      <h1>Login</h1>
      <p class="message"><?= set('message', 'login') ?></p>
      <p class="error"><?= set('log-errors', 'message') ?></p>
      <div class="form-input">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" placeholder="Enter email">
        <p><?= set('log-errors', 'email') ?></p>
      </div>
      <div class="form-input">
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" placeholder="Enter password">
        <p><?= set('log-errors', 'password') ?></p>
      </div>
      <div class="form-actions">
        <button type="submit">Login</button>
        <a href="register.php">Register</a>
      </div>
    </form>
  </div>
  <?php
  $_SESSION['log-errors'] = array();
  unset($_SESSION['message']);
  ?>
</body>

</html>