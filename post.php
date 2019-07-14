<?php
  session_start();
  include_once('dbconnect.php');

  if (!isset($_SESSION['user'])) {
    header('location:login.php');
  }

  //投稿ボタンを押したときの処理
  if (isset($_POST['posting'])) {
    $post_name = $_POST['post_name'];
    $post_author = $_POST['post_author'];
    $post_introduction = $_POST['post_introduction'];
    $post_image = "bookimage/".$_FILES['post_image']['name'];
    //uses_idをpost_idに代入
    $query2 = "SELECT user_id FROM users WHERE user_id=".$_SESSION['user']."";
    $result = $mysqli->query($query2);
    while ($row = $result->fetch_assoc()) {
      $post_id = $row['user_id'];
    }
    //POSTされた情報をDBへ格納する
    $query = "INSERT INTO posts SET post_name=?, post_author=?, post_introduction=?, post_image=?, post_id=?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ssssi", $post_name, $post_author, $post_introduction, $post_image, $post_id);
    $stmt->execute();
    move_uploaded_file($_FILES['post_image']['tmp_name'], $post_image);
    //アラートでお知らせ
    if ($mysqli->prepare($query)) { ?>
      <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
        投稿しました。
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <?php } else { ?>
      <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
        エラーが発生しました。
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <?php
    }
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

    <!-- Posting-wrapper -->
    <div class="posting-wrapper py-5">
      <div class="container">
        <div class="row">
          <div class="col-md-6 offset-md-3 text-center">
            <h2 class="mb-5 p_title">漫画を投稿する</h2>
            <form method="post" enctype="multipart/form-data">
              <label class="col-form-label">漫画のタイトル <span class="bg-danger text-white p-1" >必須</span></label>
              <input type="text" name="post_name" class="form-control mb-3" placeholder="例) ちはやふる"  required/>
              <label class="col-form-label">漫画の作者 <span class="bg-danger text-white p-1" >必須</span></label>
              <input type="text" name="post_author" class="form-control mb-3" placeholder="例) 末次由紀"  required/>
              <label class="col-form-label">漫画の画像 <span class="bg-danger text-white p-1" >必須</span></label>
              <input type="file" name="post_image" class="form-control mb-3"  required/>
              <label for="exampleTextarea">紹介文</label>
              <textarea name="post_introduction" class="form-control mb-3" placeholder="例) 最高に面白いです！" rows="8" cols="80"></textarea>
              <div class="text-center">
                <input type="submit" name="posting" class="btn btn-lg btn-success mt-4" value="投稿する">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- End Posting-wrapper -->


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>

  </body>
</html>
