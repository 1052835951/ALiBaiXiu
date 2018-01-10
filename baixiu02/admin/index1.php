<?php 
  include '../config.php';
  include '../fn.php';
  //判断登录
  checkLogin();  
  $sql1 = "select count(*) as total from posts";
  $sql2 = "select count(*) as total  from posts where status='drafted'";
  $sql3 = "select count(*) as total  from categories";
  $sql4 = "select count(*) as total  from comments";
  $sql5 = "select count(*) as total  from comments where status='held'";

  $posttot = my_query($sql1)[0]['total'];
  $dratot = my_query($sql2)[0]['total'];
  $pcattot = my_query($sql3)[0]['total'];
  $comtot = my_query($sql4)[0]['total'];
  $heldtot = my_query($sql5)[0]['total'];
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <img src="" alt="">
  <title>Dashboard &laquo; Admin</title>
  <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
  <script src="../assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <nav class="navbar">
      <button class="btn btn-default navbar-btn fa fa-bars"></button>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="profile.html"><i class="fa fa-user"></i>个人中心</a></li>
        <li><a href="./loginOut.php"><i class="fa fa-sign-out"></i>退出</a></li>
      </ul>
    </nav>
    <div class="container-fluid">
      <div class="jumbotron text-center">
        <h1>One World, One Dream</h1>
        <p>You tell me your story,and I tell you mine!</p>
        <p><a class="btn btn-primary btn-lg" href="post-add.html" role="button">Just Write</a></p>
      </div>
      <div class="row">
        <div class="col-md-4">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">站点内容统计：</h3>
            </div>
            <ul class="list-group">
              <li class="list-group-item"><strong><?php echo $posttot ?></strong>篇文章（<strong><?php echo $dratot ?></strong>篇草稿）</li>
              <li class="list-group-item"><strong><?php echo $pcattot ?></strong>个分类</li>
              <li class="list-group-item"><strong><?php echo $comtot ?></strong>条评论（<strong><?php echo $heldtot ?></strong>条待审核）</li>
            </ul>
          </div>
        </div>
        <div class="col-md-4"></div>
        <div class="col-md-4"></div>
      </div>
    </div>
  </div>

  <?php $page = 'index1' ?>
  <!-- 侧边栏 -->
  <?php  include './inc/aside.php' ?>


  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script>NProgress.done()</script>
</body>
</html>
