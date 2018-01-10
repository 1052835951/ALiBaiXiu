<?php
include_once '../config.php';
  include '../fn.php';
  checkLogin();

  $sql1 = "select count(*) as totle from posts";
  $sql2 = "select count(*) as totle from posts where status='drafted'";
  $sql3 = "select count(*) as totle from categories";
  $sql4 = "select count(*) as totle from comments";
  $sql5 = "select count(*) as totle from comments where status='held'";

  $posts_tot = my_query($sql1)[0]['totle'];
  $dra_tot = my_query($sql2)[0]['totle'];
  $cat_tot = my_query($sql3)[0]['totle'];
  $com_tot = my_query($sql4)[0]['totle'];
  $hel_tot = my_query($sql5)[0]['totle'];

?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
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
    <?php $page='index1.php' ?>
  <!-- 导入导航栏 -->
  <?php include './inc/head.php' ?>


    <div class="container-fluid">
      <div class="jumbotron text-center">
        <h1>One Belt, One Road</h1>
        <p>Thoughts, stories and ideas.</p>
        <p><a class="btn btn-primary btn-lg" href="post-add.html" role="button">写文章</a></p>
      </div>
      <div class="row">
        <div class="col-md-4">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">站点内容统计：</h3>
            </div>
            <ul class="list-group">
              <li class="list-group-item"><strong><?php echo $posts_tot ?></strong>篇文章（<strong><?php echo $dra_tot ?></strong>篇草稿）</li>
              <li class="list-group-item"><strong><?php echo $cat_tot ?></strong>个分类</li>
              <li class="list-group-item"><strong><?php echo $com_tot ?></strong>条评论（<strong><?php echo $hel_tot ?></strong>条待审核）</li>
            </ul>
          </div>
        </div>
        <div class="col-md-4"></div>
        <div class="col-md-4"></div>
      </div>
    </div>
  </div>

  <!-- 导入侧边栏 -->
  <?php include './inc/aside.php' ?>
  
  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script>NProgress.done()</script>
</body>
</html>
