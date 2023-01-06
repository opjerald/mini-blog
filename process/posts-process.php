<?php

session_start();
require_once('connection.php');

if (isset($_POST['crud']) && $_POST['crud'] == 'create') {
  if (isset($_POST['title']) && empty($_POST['title'])) {
    $_SESSION['errors']['title'] = "*Title field is a required field";
  }

  if (isset($_POST['content']) && empty($_POST['content'])) {
    $_SESSION['errors']['content'] = "*Content is a required field";
  }

  if (count($_SESSION['errors']) == 0) {
    $title = escape_this_string($_POST['title']);
    $content = escape_this_string($_POST['content']);

    $query = "INSERT INTO posts(user_id, title, content, created_at, updated_at)
              VALUES ('{$_SESSION['user']['id']}', '$title', '$content', NOW(), NOW())";

    run_mysql_query($query);

    $_SESSION['message']['index'] = "Post successfully created!";

    header('Refresh: 0, url = /exam/index.php');
    die();
  }

  header('Refresh: 0, url = /exam/new.php');
} else if (isset($_POST['crud']) && $_POST['crud'] == 'delete') {

  $post_id = escape_this_string($_POST['post_id']);
  $query = "DELETE FROM posts WHERE id = $post_id";
  run_mysql_query($query);

  $_SESSION['message']['index'] = "Post successfully deleted!";

  header('Refresh: 0, url = /exam/index.php');
} else if (isset($_POST['crud']) && $_POST['crud'] == 'edit') {

  $post_id = escape_this_string($_POST['post_id']);
  $query = "SELECT * FROM posts WHERE id = $post_id";
  $_SESSION['post'] = fetch_record($query);

  header('Refresh: 0, url = /exam/edit.php');
} else if (isset($_POST['crud']) && $_POST['crud'] == 'update') {

  if (isset($_POST['title']) && empty($_POST['title'])) {
    $_SESSION['errors']['title'] = "*Title field is a required field";
  }

  if (isset($_POST['content']) && empty($_POST['content'])) {
    $_SESSION['errors']['content'] = "*Content is a required field";
  }

  if (count($_SESSION['errors']) == 0) {

    $post_id = escape_this_string($_POST['post_id']);
    $title = escape_this_string($_POST['title']);
    $content = escape_this_string($_POST['content']);

    $query = "UPDATE posts SET title='$title', content='$content', updated_at=NOW() WHERE id = $post_id";

    run_mysql_query($query);

    unset($_SESSION['post']);

    $_SESSION['message']['index'] = "Post successfully updated!";

    header('Refresh: 0, url = /exam/index.php');
    die();
  }

  header('Refresh: 0, url = /exam/edit.php');
}
