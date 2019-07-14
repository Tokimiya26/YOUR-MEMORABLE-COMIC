<?php
  //ページネーションが押されたとき
  if (isset($_GET['page'])) {
    $page = $_GET['page'];
  }else {
    $page = 1;
  }

  if ($page == '' || $page == 1) {
    $page1 = 0;
  }else {
    $page1 = ($page*10)-10;
  }

  //usersテーブルとpostsテーブルをリレーションさせる
  $query = "SELECT * FROM posts LEFT JOIN users ON posts.post_id = users.user_id ORDER BY id DESC LIMIT $page1, 10";
  $result = $mysqli->query($query);
  // 結果を受け取る変数を配列にする
  $posteds = [];
  while ($row = $result->fetch_assoc()) {
      // 配列に取り出した一行分の結果を足していく
      $posteds[] = $row;
  }

  //ページネーション
  $sql = "SELECT * FROM posts LEFT JOIN users ON posts.post_id = users.user_id";
  $data = $mysqli->query($sql);
  $records = $data->num_rows;
  $records_pages = $records/10;
  $records_pages = ceil($records_pages);
  $prev = $page-1;
  $next = $page+1;
