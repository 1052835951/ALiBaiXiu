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
  <title>Add new post &laquo; Admin</title>
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
        <h1>写文章</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <form class="row" action=" " method="post" enctype="multipart/form-data">
        <div class="col-md-9">
          <div class="form-group">
            <label for="title">标题</label>
            <input id="title" class="form-control input-lg" name="title" type="text" placeholder="文章标题">
          </div>
          <div class="form-group">
            <label for="content">标题</label>
            <div class="contentbox"></div>
            <textarea id="content" class="form-control input-lg" name="content" cols="30" style="display:none" rows="10" placeholder="内容"></textarea>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="slug">别名</label>
            <input id="slug" class="form-control" name="slug" type="text" placeholder="slug">
            <p class="help-block">https://zce.me/post/<strong class="strongT">slug</strong></p>
          </div>
          <div class="form-group">
            <label for="feature">特色图像</label>
            <!-- show when image chose -->
            <img class="help-block thumbnail" style="display: none">
            <input id="feature" class="form-control" name="feature" type="file">
          </div>
          <div class="form-group">
            <label for="category">所属分类</label>
            <select id="category" class="form-control" name="category">
              <option value="1">未分类</option>
              <option value="2">潮生活</option>
            </select>
          </div>
          <div class="form-group">
            <label for="created">发布时间</label>
            <input id="created" class="form-control" name="created" type="datetime-local">
          </div>
          <div class="form-group">
            <label for="status">状态</label>
            <select id="status" class="form-control" name="status">
              <option value="drafted">草稿</option>
              <option value="published">已发布</option>
            </select>
          </div>
          <div class="form-group">
            <button class="btn btn-primary" type="submit">保存</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <?php $page = 'post-add' ?>
  <!-- 侧边栏 -->
  <?php  include './inc/aside.php' ?>

  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script src="../assets/vendors/complate/template-web.js"></script>
  <script src="../assets/vendors/wangEidtor/wangEditor.min.js"></script>
  <script>
    $(function(){
      var obj = {
        'drafted':'草稿',
        'published':'已发布',
        'trashed':'回收站'
      }
      // 动态生成下拉分类列表
      $.ajax({
        type: 'get',
        url:'./post/cateAdd.php',
        dataType:'json',
        success:function(info){
          console.log(info);
          $('#category').html(template('tmp-cate',{list:info}))
        }
      })
      // 动态生成状态下拉列表
      $('#status').html(template('tmp-state',{obj:obj}))

      //5-显示富文本编辑器
      var E = window.wangEditor
        var editor = new E('.contentbox');    
        //把富文本编辑器中内容及时的同步到textarea   
        editor.customConfig.onchange = function (html) {
            // 监控变化，同步更新到 textarea
           $('#content').val(html);
        }
        editor.create();   

        //将textarea中内容添加给富文本编辑器
        // editor.txt.html($('#content').val()); 

        // 别名同步功能
        $('#slug').on('input',function(){
          $('.strongT').text($(this).val());
        })
    })
  </script>
  <script>NProgress.done()</script>
  <script type="text/template" id="tmp-cate">
    {{ each list $v $k }}
      <option value="{{ $v.id }}">{{ $v.name }}</option>
    {{ /each }}
  </script>
  <script type="text/template" id="tmp-state">
    {{ each obj $v $k }}
      <option value="{{ $k }}">{{ $v }}</option>
    {{ /each }}
  </script>
</body>
</html>
