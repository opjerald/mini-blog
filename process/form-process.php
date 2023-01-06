<?php

session_start();
require_once('connection.php');

$dir = explode('\\', dirname(__DIR__));
$folder = end($dir);

$_SESSION['message']['login'] = "";

if (isset($_POST['register'])) {

  if (isset($_POST['username']) && empty($_POST['username'])) {
    $_SESSION['reg-errors']['username'] = "*Username is a required field";
  } else if (strlen($_POST['username']) < 2) {
    $_SESSION['reg-errors']['username'] = "*Username must have 2 characters or more.";
  }

  if (isset($_POST['email']) && empty($_POST['email'])) {
    $_SESSION['reg-errors']['email'] = "*Email is a required field";
  } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $_SESSION['reg-errors']['email'] = "*Email is invalid.";
  }

  if (isset($_POST['password']) && empty($_POST['password'])) {
    $_SESSION['reg-errors']['password'] = "*Password is a required field";
  } else if (strlen($_POST['password']) < 8) {
    $_SESSION['reg-errors']['password'] = "*Password must have 8 characters or more.";
  }

  if (isset($_POST['password_confirm']) && empty($_POST['password_confirm'])) {
    $_SESSION['reg-errors']['password_confirm'] = "*Password Confirmation is a required field";
  } else if ($_POST['password_confirm'] != $_POST['password']) {
    $_SESSION['reg-errors']['password_confirm'] = "*Password not matched!";
  }

  if (count($_SESSION['reg-errors']) == 0) {
    $username = escape_this_string($_POST['username']);
    $email = escape_this_string($_POST['email']);
    $password = md5(escape_this_string($_POST['password_confirm']));
    $add_account = "INSERT INTO users(username, email, password, created_at, updated_at)
                    VALUES ('$username', '$email', '$password', NOW(), NOW())";
    run_mysql_query($add_account);
    $_SESSION['message']['login'] = "Account successully registered!";
    header("Refresh: 0, url = /$folder/login.php");
    die();
  }

  header("Refresh: 0, url = /$folder/register.php");
} else if (isset($_POST['login'])) {
  if (isset($_POST['email']) && empty($_POST['email'])) {
    $_SESSION['log-errors']['email'] = "*Email is a required field";
  }
  if (isset($_POST['password']) && empty($_POST['password'])) {
    $_SESSION['log-errors']['password'] = "*Password is a required field";
  }

  if (count($_SESSION['log-errors']) == 0) {
    $email = escape_this_string($_POST['email']);
    $query = "SELECT * FROM users WHERE email = '$email'";
    $user = fetch_record($query);
    if (!empty($user)) {
      $password = md5($_POST['password']);
      if ($user['password'] == $password) {
        $_SESSION['user'] = [
          'id' => $user['id'],
          'username' => $user['username'],
        ];
        header("Refresh: 0, url = /$folder/index.php");
        die();
      } else {
        $_SESSION['log-errors']['message'] = "Invalid Username or Password!";
      }
    } else {
      $_SESSION['log-errors']['message'] = "Invalid Username or Password!";
    }
  }

  header("Refresh: 0, url = /$folder/login.php");
} else if (isset($_POST['logout'])) {
  unset($_SESSION['user']);
  header("Refresh: 0, url = /$folder/login.php");
}
