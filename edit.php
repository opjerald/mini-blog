<?php
session_start();

if (!isset($_SESSION['errors'])) {
  $_SESSION['errors'] = [];
}

if (!isset($_SESSION['user'])) {
  header('Refresh: 0, url = /exam/login.php');
}

if (!isset($_SESSION['post'])) {
  $_SESSION['message']['index'] = 'You need to select a post first before proceeding to edit.';
  header('Refresh: 0, url = /exam/index.php');
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
      <input type="hidden" name="crud" value="update">
      <input type="hidden" name="post_id" value="<?= set('post', 'id') ?>">
      <Big>Edit Post - <?= set('post', 'title') ?></Big>
      <div class="form-input">
        <input type="text" name="title" placeholder="Enter title" value="<?= set('post', 'title') ?>">
        <p><?= set('errors', 'title') ?></p>
      </div>
      <div class="form-input">
        <textarea name="content" placeholder="Enter content"><?= set('post', 'content') ?></textarea>
        <p><?= set('errors', 'content') ?></p>
      </div>
      <button type="submit">Update</button>
    </form>
  </main>
  <?php $_SESSION['errors'] = []; ?>
</body>

</html>