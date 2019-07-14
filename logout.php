<?php
  session_start();

  //ログアウトボタンを押したときの処理
  if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['user']);
    header('location:index.php');
  }else {
    header('location:index.php');
  }
