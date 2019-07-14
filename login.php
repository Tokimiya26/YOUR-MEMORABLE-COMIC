<?php
  ob_start();
  session_start();

  if (isset($_SESSION['user']) != "") {
    header('location:home.php');
  }
  //DBとの接続
  include_once('dbconnect.php');

  //ログインするボタンを押したときの処理
  if (isset($_POST['login'])) {
    $email = $mysqli->real_escape_string($_POST{'email'});
    $password = $mysqli->real_escape_string($_POST{'password'});

    //クエリーの実行
    $query = "SELECT * FROM users WHERE email='$email'";
    $result = $mysqli->query($query);
    if (!$result) {
      print('クエリーが失敗しました'.$mysqli->error);
      $mysqli->close();
      exit();
    }

    //パスワード(暗号化済み)とユーザーIDの取り出し
    while ($row = $result->fetch_assoc()) {
      $db_hashed_pwd = $row['password'];
      $user_id = $row['user_id'];
    }

    //データベースの切断
    $result->close();

    //ハッシュ化されたパスワードがマッチするかの確認
    if (password_verify($password, $db_hashed_pwd)) {
      $_SESSION['user'] = $user_id;
      header('location:home.php');
      exit;
    }else { ?>
      <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
        メールアドレスとパスワードが一致しません。
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <?php }
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
       <a class="navbar-brand" href="index.php">Your memorable COMIC</a>
       <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
         <span class="navbar-toggler-icon"></span>
       </button>

       <div class="navbar-collapse collapse" id="navbarColor01" style="">
         <ul class="navbar-nav ml-auto">
           <li class="nav-item my-3 mx-2">
             <a class="btn btn-secondary" href="register.php"><span><i class="far fa-address-book"></i></span> 会員登録</a>
           </li>
           <li class="nav-item my-3 mx-2">
             <a class="btn btn-warning" href="login.php"><span><i class="fas fa-sign-in-alt"></i></span> ログイン</a>
           </li>
         </ul>
       </div>
     </nav>
     <!-- End Navigation -->

     <!-- Login-wrapper -->
     <div class="login-wrapper py-5">
       <div class="container">
         <div class="row">
           <div class="col-md-6 offset-md-3 text-center">
             <form method="post">
               <h2 class="mb-5 p_title">ログイン</h2>
               <div class="form-group">
                 <label class="col-form-label">メールアドレス <span class="bg-danger text-white p-1" >必須</span></label>
                 <input type="email" class="form-control" name="email" placeholder="E-mail" required />
                 <p>テスト用 : test@email.com</p>
               </div>
               <div class="form-group mb-5">
                 <label class="col-form-label">パスワード <span class="bg-danger text-white p-1" >必須</span></label>
                 <input type="password" class="form-control" name="password" placeholder="Password" required />
                 <p>テスト用 : test</p>
               </div>
               <button type="submit" class="btn btn-warning" name="login">ログインする</button>
               <a href="register.php" class="ml-3">会員登録はこちら</a>
             </form>
           </div>
         </div>
       </div>
     </div>
     <!-- End Login-wrapper -->

     <!-- Optional JavaScript -->
     <!-- jQuery first, then Popper.js, then Bootstrap JS -->
     <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
     <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
   </body>
 </html>
