<?php 
 include_once '../config.php';
  include '../fn.php';
  //判断登录
  checkLogin();

?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Categories &laquo; Admin</title>
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
        <li><a href="login.html"><i class="fa fa-sign-out"></i>退出</a></li>
      </ul>
    </nav>
    <div class="container-fluid">
      <div class="page-title">
        <h1>分类目录</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <div class="alert alert-danger wrong-text" style="display:none">
        <strong>错误！</strong><span></span>
      </div>
      <div class="row">
        <div class="col-md-4">
          <form id="add-form">
            <h2>添加新分类目录</h2>
            <div class="form-group">
              <label for="name">名称</label>
              <input id="name" class="form-control" name="name" type="text" placeholder="分类名称">
            </div>
            <div class="form-group">
              <label for="slug">别名</label>
              <input id="slug" class="form-control" name="slug" type="text" placeholder="slug">
              <p class="help-block">https://zce.me/category/<strong class="strong-text">slug</strong></p>
            </div>
            <div class="form-group">
              <!-- <button class="btn btn-primary" type="submit">添加</button> -->
              <input type="button" class="btn btn-primary btn-add" value="添加" >
              <input type="button" class="btn btn-primary btn-update" style="display:none" value="修改" >
            </div>
          </form>
        </div>
        <div class="col-md-8">
          <div class="page-action">
            <!-- show when multiple checked -->
            <a class="btn btn-danger btn-sm" href="javascript:;" style="display: none">批量删除</a>
          </div>
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th class="text-center" width="40"><input type="checkbox"></th>
                <th>名称</th>
                <th>Slug</th>
                <th class="text-center" width="100">操作</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="text-center"><input type="checkbox"></td>
                <td>未分类</td>
                <td>uncategorized</td>
                <td class="text-center">
                  <a href="javascript:;" class="btn btn-info btn-xs">编辑</a>
                  <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <?php $page = 'categories' ?>
  <!-- 侧边栏 -->
  <?php  include './inc/aside.php' ?>

  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script src="../assets/vendors/complate/template-web.js"></script>
  <script>NProgress.done()</script>
  <script>
    $(function(){
      //给slug绑定input事件
      $('#slug').on('input',function(){
        $('.strong-text').text($(this).val());
      })
      function render(){
        $.ajax({
          type:'get',
          url:'./category/cateGet.php',
          dataType:'json',
          success:function(info){
            $('tbody').html(template('tmp_table',{list:info}));
          }

        })
      }
      render();
    // 添加按钮点击事件
      $('.btn-add').click(function(){
        var data = $('#add-form').serialize();
        $.ajax({
          type:'get',
          url:'./category/cateAdd.php',
          data:data,
          dataType:'json',
          success:function(info){
            render();
            $('#add-form')[0].reset();
            $('.strong-text').text('slug');
            console.log(info);
            if(info['status'] == 100){
              $('.wrong-text').show().children('span').text(info['msg']);
            }
        }
      })
      })

      //删除按钮功能实现

      $('tbody').on('click','.btn-del',function(){
        var id = $(this).parent().attr('data-id');
        $.ajax({
          type:'get',
          url:'./category/cateDel.php',
          data:{id:id},
          success:function(info){
            render();
          }
        })

      })

      //编辑按钮获取数据并填充功能实现
      $('tbody').on('click','.btn-edit',function(){
        // alert(11);
        var id = $(this).parent().attr('data-id');
        $.ajax({
          type:'get',
          url:'category/cateGet.php',
          data:{id:id},
          dataType:'json',
          success:function(info){
            $('form').attr('data-id',info[0]['id']);
            $('#name').val(info[0]['name']);
            $('#slug').val(info[0]['slug']).trigger('input');
            $('.btn-update').show();
            $('.btn-add').hide();
          }
        })
      })

      //编辑完成提交数据
      $('.btn-update').on('click',function(){
        var data = $('#add-form').serialize();
        data = data + '&id=' + $('form').attr('data-id');
        $.ajax({
          type:'get',
          url:'./category/cateAdd.php',
          data:data,
          success:function(info){
            render();
            $('#add-form')[0].reset();
            $('.strong-text').text('slug');
            $('.btn-update').hide();
            $('.btn-add').show();
          }
        })
      })
    })
  </script>

  <!-- 列表模板 -->
  <script type="text/template" id="tmp_table">
  {{ each list $v}}
    <tr>
      <td class="text-center" data-id="{{ $v.id }}"><input type="checkbox"></td>
      <td>{{ $v.name }}</td>
      <td>{{ $v.slug }}</td>
      <td class="text-center" data-id="{{ $v.id }}">
        <a href="javascript:;" class="btn btn-info btn-xs btn-edit">编辑</a>
        <a href="javascript:;" class="btn btn-danger btn-xs btn-del">删除</a>
      </td>
    </tr>
    {{ /each }}
  </script>
</body>
</html>
