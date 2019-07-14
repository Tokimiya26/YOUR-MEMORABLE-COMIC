<?php
  session_start();
  include_once('dbconnect.php');
  
  //削除ボタンを押したときの処理
  if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    //画像ファイルをフォルダから削除
    $query2 = "SELECT post_image FROM posts WHERE id='$id'";
    $result2 = $mysqli->query($query2);
    $row = $result2->fetch_assoc();
    $imagepath = $row['post_image'];
    unlink($imagepath);
    //DBからデータ削除
    $query = "DELETE FROM posts WHERE id=?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header('location:mypost.php');

  }
