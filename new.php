<?php
session_start();

if (!isset($_SESSION['errors'])) {
  $_SESSION['errors'] = [];
}

if (!isset($_SESSION['user'])) {
  header('Refresh: 0, url = /exam/login.php');
}

function set($arr, $key)
{
  if (isset($_SESSION[$arr][$key])) {
    return $_SESSION[$arr][$key];
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mini Blog</title>
  <link rel="stylesheet/less" href="./assets/style.less">
  <script src="https://cdn.jsdelivr.net/npm/less"></script>
</head>

<body>
  <nav>
    <header>
      <h1>MiniBlog</h1>
      <div class="actions">
        <p>Hi! <?= $_SESSION['user']['username'] ?></p>
        <a href="index.php">Home</a>
        <form action="form-process.php" method="post">
          <input type="hidden" name="logout" value="logout">
          <button type="submit">Logout</button>
        </form>
      </div>
    </header>
  </nav>

  <main>
    <form action="process/posts-process.php" method="post" class="create-form">
      <input type="hidden" name="crud" value="create">
      <Big>Create a Post</Big>
      <div class="form-input">
        <label for="title">Title:</label>
        <input type="text" name="title" id="title" placeholder="Enter title">
        <p><?= set('errors', 'title') ?></p>
      </div>
      <div class="form-input">
        <label for="content">Content:</label>
        <textarea name="content" id="content" placeholder="Enter content"></textarea>
        <p><?= set('errors', 'content') ?></p>
      </div>
      <button type="submit">Post</button>
    </form>
  </main>
  <?php $_SESSION['errors'] = [];
  unset($_SESSION['message']); ?>
</body>

</html>