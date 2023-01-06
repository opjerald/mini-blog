<?php

session_start();
require_once('process/connection.php');

unset($_SESSION['post']);
unset($_SESSION['log-errors']);
unset($_SESSION['errors']);

if (!isset($_SESSION['user'])) {
  header('Refresh: 0, url = /exam/login.php');
}

$query = "SELECT id, user_id, title, content, DATE_FORMAT(created_at, \"%M %D %Y %I:%i%p\") as created_at
          FROM posts
          ORDER BY created_at DESC";

$posts = fectch_all($query);

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
        <form action="process/form-process.php" method="post">
          <input type="hidden" name="logout" value="logout">
          <button type="submit">Logout</button>
        </form>
      </div>
    </header>
  </nav>

  <main>
    <p class="message"> <?= set('message', 'index') ?></p>
    <div class="posts">
      <?php foreach ($posts as $post) { ?>
        <div class="post">
          <big><?= $post['title'] ?></big>
          <p><?= $post['content'] ?></p>
          <p>Date: <?= $post['created_at'] ?></p>

          <?php if (set('user', 'id') == $post['user_id']) { ?>
            <div class="actions">
              <form action="process/posts-process.php" method="post">
                <input type="hidden" name="crud" value="delete">
                <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                <button type="submit">Delete</button>
              </form>
              <form action="process/posts-process.php" method="post">
                <input type="hidden" name="crud" value="edit">
                <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                <button type="submit" class="edit">Edit</button>
              </form>
            </div>
          <?php } ?>
        </div>
      <?php } ?>
    </div>
    <div class="create"><a href="new.php">Create new post</a></div>
  </main>
  <?php unset($_SESSION['message']); ?>
</body>

</html>