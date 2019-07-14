<?php
  session_start();
  include_once('dbconnect.php');

  if (!isset($_SESSION['user'])) {
    header('location:login.php');
  }

  //ユーザーIDからユーザー名を取り出す
  $query = "SELECT * FROM users WHERE user_id=".$_SESSION['user']."";
  $result = $mysqli->query($query);
  if (!$result) {
    print('クエリーが失敗しました'.$mysqli->error);
    $mysqli->close();
    exit();
  }
  //ユーザー情報の取り出し
  while ($row = $result->fetch_assoc()) {
    $username = $row['username'];
    $email = $row['email'];
    $password = $row['password'];
    $photo = $row['photo'];
  }

  //プロフィールの変更ボタンを押したときの処理
  if (isset($_POST['update'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password = password_hash($password, PASSWORD_DEFAULT);

    $photo = "uploads/".$_FILES['image']['name'];

    $query = "UPDATE users SET username=?, email=?, password=?, photo=? WHERE user_id=".$_SESSION['user']."";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ssss", $username, $email, $password, $photo);
    $stmt->execute();
    move_uploaded_file($_FILES['image']['tmp_name'], $photo);
    //アラートでお知らせ
    if ($mysqli->prepare($query)) { ?>
      <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
        変更しました。
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

  //データベースの切断
  $result->close();
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

    <!-- Profile-wrapper -->
    <div class="profile-wrapper py-5">
      <div class="container">
        <div class="row">
          <div class="col-md-6 offset-md-3 text-center">
            <form method="post" enctype="multipart/form-data">
              <h2 class="mb-5 p_title">プロフィール</h2>
              <div class="form-group">
                <img src="<?php echo $photo; ?>" class="form-group rounded-circle" width="120px" height="120px">
              </div>
              <div class="form-group">
                <label class="col-form-label">プロフィール画像 <span class="bg-danger text-white p-1" >必須</span></label>
                <input type="file" class="form-control mb-3" name="image" required />
              </div>
              <div class="form-group">
                <label class="col-form-label">ユーザー名 <span class="bg-danger text-white p-1" >必須</span></label>
                <input type="name" class="form-control mb-3" name="username" value="<?php echo $username; ?>" required />
              </div>
              <div class="form-group">
                <label class="col-form-label">メールアドレス <span class="bg-danger text-white p-1" >必須</span></label>
                <input type="email" class="form-control mb-3" name="email" value="<?php echo $email; ?>" required />
              </div>
              <div class="form-group">
                <label class="col-form-label">パスワード（※入力したパスワードに変更されます） <span class="bg-danger text-white p-1" >必須</span></label>
                <input type="password" class="form-control mb-3" name="password" placeholder="変更しない場合は元のパスワードを入力" required />
              </div>
              <button type="submit" class="btn btn-lg btn-info mt-4" name="update">変更する</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- End Profile-wrapper -->


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
  </body>
</html>
