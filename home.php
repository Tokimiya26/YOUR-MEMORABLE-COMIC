<?php
  session_start();
  include_once('dbconnect.php');
  require_once('pagination.php');

  if (!isset($_SESSION['user'])) {
    header('location:login.php');
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

    <!-- top-wrapper -->
    <div class="top-wrapper text-center text-white">
      <div class="top-character">
        <h1>あなたの記憶に残る一冊</h1>
        <br>
        <h4>Your memorable comic.</h4>
        <a href="post.php" class="btn btn-lg btn-success mt-3"><span><i class="fas fa-book-open"></i></span> 投稿する</a>
      </div>
    </div>
    <div class="wrapper2 text-center">
      <div class="container">
        <h2 class="mt-5">笑ったり泣いたりした思い出の漫画</h2>
        <hr style="background-color:#EB6964" width="250px">
        <p class="mt-4">子供の頃読んでいたけど、大人になって読む機会が減ってしまったあなた。</p>
        <p>漫画を共有して無邪気に読んでいたあの頃を思い出しませんか？</p>
        <p>少年、少女、ギャグ、スポーツ漫画などジャンルは問いません。<br>
          オススメのポイントやあなたのエピソード等を添えて投稿してみてください。</p>
      </div>
    </div>
    <!-- End top-wrapper -->

    <!-- post-wrapper -->
    <div class="post-wrapper pt-5">
      <div class="container">
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
            <a href="https://www.amazon.co.jp/s?k=<?= $posted['post_name']?>&rh=n%3A466280&__mk_ja_JP=%E3%82%AB%E3%82%BF%E3%82%AB%E3%83%8A&ref=nb_sb_noss" target="_blank" class="btn btn-outline-primary btn-lg px-5 m-3"><span><i class="fab fa-amazon"></i></span> 商品を探す</a>
            <a class="btn btn-lg btn-outline-info px-5 m-3" href="https://twitter.com/intent/tweet?text= @toki_work26 YOUR MEMORABLE COMIC: &url=https://toki-life.com/YOUR-MEMORABLE-COMIC/" target="_blank" rel="nofollow"><span><i class="fab fa-twitter"></i></span> シェアする</a>
          </div>
          <div class="col-12">
            <hr style="background-color:#EB6964" class="mb-4" >
          </div>
        <?php endforeach; ?>
        <!-- ここまで繰り返し -->
        <!-- ページネーション -->
        <div class="paginate m-auto pb-4">
          <ul class="page_link">
            <?php if ($prev >= 1): ?>
              <li><a href="?page=<?php echo $prev; ?>"><i class="fas fa-angle-left"></i></a></li><!-- 1ページ前へ -->
            <?php endif; ?>
            <?php if ($records_pages >= 2): ?>
              <?php for ($r=1; $r <= $records_pages; $r++): ?>
                <?php $active = $r == $page ? 'class="active"' : ''; ?><!-- 現在のページ -->
                <li><a href="?page=<?php echo $r; ?>" <?php echo $active; ?>><?php echo $r; ?></a></li><!-- 1ページずつ増える -->
              <?php endfor; ?>
            <?php endif; ?>
            <?php if ($next <= $records_pages && $records_pages >= 2): ?>
              <li><a href="?page=<?php echo $next ?>"><i class="fas fa-angle-right"></i></a></li><!-- 1ページ次へ -->
            <?php endif; ?>
          </ul>
        </div>
        <!-- ここまでページネーション -->
        </div>
      </div>
    </div>
    <!-- End post-wrapper -->

    <!-- under-wrapper -->
    <div class="under-wrapper text-center">
      <div class="under-character">
        <h2>思い出の漫画を投稿してみませんか？</h2>
        <br>
        <h3>Let's Posting Your memorable comic!</h3>
        <a href="post.php" class="btn btn-lg btn-success mt-4 mb-4"><span><i class="fas fa-book-open"></i></span> 投稿する</a>
      </div>
    </div>
    <!-- End under-wrapper -->

    <!-- fotter -->
    <footer class="text-light bg-primary  pt-4 pb-4">
      <div class="text-center" style="font-size: 18px;">
        &copy; 2019 Tokimiya, All Rights Reserved.
      </div>
    </footer>
    <!-- End fotter -->

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
  </body>
</html>
