<?php
header('content-type:text/html;charset=utf-8');
include_once '../config.php';
  include '../fn.php';

  if(isset($_POST['email'])){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $res = my_query("select *  from users where email='$email'");
    if($email == $res[0]['email'] && $password == $res[0]['password']){
      session_start();
      $_SESSION['id']= $res[0]['id'];
      header('location: ./index1.php');
      die();
    }else{
      $msg = "账号或密码错误！";
    }

  }
 

  

?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Sign in &laquo; Admin</title>
  <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
  <div class="login">
    <form class="login-wrap" action="" method="post">
      <img class="avatar" src="../assets/img/default.png">
      <!-- 有错误信息时展示 -->
      <?php if(isset($msg)){ ?>
      <div class="alert alert-danger">
        <strong>错误！</strong> 用户名或密码错误！
      </div>
      <?php } ?>
      <div class="form-group">
        <label for="email" class="sr-only">邮箱</label>
        <input id="email" type="email" name="email" class="form-control" placeholder="邮箱" autofocus>
      </div>
      <div class="form-group">
        <label for="password" class="sr-only">密码</label>
        <input id="password" type="password" name="password" class="form-control" placeholder="密码">
      </div>
      <!-- <a class="btn btn-primary btn-block" href="index.html">登 录</a> -->
      <input type="submit" value="登录" class="btn btn-primary btn-block" >
    </form>
  </div>
</body>
</html>
