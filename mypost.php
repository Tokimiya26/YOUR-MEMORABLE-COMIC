<?php
  session_start();
  include_once('dbconnect.php');
  require_once('pagination.php');

  if (!isset($_SESSION['user'])) {
    header('location:login.php');
  }

  //ログイン中ユーザーのusersテーブルとpostsテーブルをリレーションさせる
  $query = "SELECT * FROM posts LEFT JOIN users ON posts.post_id = users.user_id WHERE user_id=".$_SESSION['user']." ORDER BY id DESC";
  $result = $mysqli->query($query);
  // 結果を受け取る変数を配列にする
  $posteds = [];
  while ($row = $result->fetch_assoc()) {
      // 配列に取り出した一行分の結果を足していく
      $posteds[] = $row;
  }


 ?>

<!doctype html>
<html lang="ja">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap-Theme CSS -->
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <!-- CSS -->
    <link rel="stylesheet" href="./css/style.css">
    <!-- favicon設定 -->
    <link rel="shortcut icon" href="./img/favicon.ico">
    <!-- Font Awesome -->
    <script defer src="https://use.fontawesome.com/releases/v5.8.2/js/all.js" integrity="sha384-DJ25uNYET2XCl5ZF++U8eNxPWqcKohUUBUpKGlNLMchM7q4Wjg2CUpjHLaL8yYPH" crossorigin="anonymous"></script>

    <title>YOUR MEMORABLE COMIC</title>
  </head>
  <body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
      <a class="navbar-brand" href="home.php">Your memorable COMIC</a>
      <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="navbar-collapse collapse" id="navbarColor01" style="">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item my-3 mx-2">
            <a class="btn btn-info" href="profile.php"><span><i class="fas fa-user-edit"></i></span> プロフィール</a>
          </li>
          <li class="nav-item my-3 mx-2">
            <a class="btn btn-danger" href="mypost.php"><span><i class="fas fa-book"></i> My投稿一覧</a>
          </li>
          <li class="nav-item my-3 mx-2">
            <a class="btn btn-warning" href="logout.php?logout"><span><i class="fas fa-sign-out-alt"></i></span> ログアウト</a>
          </li>
        </ul>
      </div>
    </nav>
    <!-- End Navigation -->

    <!-- post-wrapper -->
    <div class="post-wrapper py-5 mb-5">
      <div class="container">
        <h2 class="text-center mb-5 p_title">My投稿一覧</h2>
        <div class="row">
          <!-- 投稿を繰り返し表示 -->
          <?php foreach ($posteds as $posted): ?>
          <div class="col-md-4 text-center mb-3">
            <img src="<?php echo $posted['post_image']; ?>" width="200px" height="300px">
          </div>
          <div class="col-md-8 mb-3 manga_data">
            <h3><?php echo $posted['post_name']; ?></h3>
            <p><?php echo $posted['post_author']; ?></p>
            <p><?php echo nl2br(htmlspecialchars($posted['post_introduction'])); ?></p>
          </div>
          <div class="col-md-4 text-center mb-3">
            <img src="<?php echo $posted['photo']; ?>" width="120px" height="120px" class="rounded-circle">
            <p>紹介者 : <?php echo $posted['username']; ?>さん</p>
          </div>
          <div class="col-md-8 mb-5 text-center">
            <form action="edit.php" method="post" class="mb-5 mr-4 d-inline">
              <input type="submit" class="btn btn-lg btn-success" value="編集">
              <input type="hidden" name="id" value="<?php echo $posted['id']; ?>">
            </form>
            <form action="delete.php" method="post" class="mb-5 ml-4 d-inline">
              <input type="submit" name="delete" class="btn btn-lg btn-primary" value="削除" onclick="return confirm('本当に削除しますか？')">
              <input type="hidden" name="id" value="<?php echo $posted['id']; ?>">
            </form>
          </div>
          <div class="col-12">
            <hr style="background-color:#EB6964" class="mb-5" >
          </div>
        <?php endforeach; ?>
        <!-- ここまで繰り返し -->
        </div>
      </div>
    </div>
    <!-- End post-wrapper -->

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
  </body>
</html>
