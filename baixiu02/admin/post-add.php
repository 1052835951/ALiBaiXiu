<?php 
 include_once '../config.php';
  include '../fn.php';
  //判断登录
  checkLogin();
    $has=isset($_GET['id']);
  if(isset($_GET['id'])){
    $id = $_GET['id'];
    
      $sql = "select * from posts where id = $id";
      $data = my_query($sql)[0];
      if(isset($data['feature'])){
        $url = '../'.$data['feature'];
      }
  }
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
      <form class="row" action="./post/postAddA.php" method="post" enctype="multipart/form-data">
        <div class="col-md-9">
          <div class="form-group">
            <label for="title">标题</label>
            <input id="title" class="form-control input-lg" name="title" type="text" placeholder="文章标题" 
            value="<?php echo $has ? $data['title']:'' ?>">
          </div>
          <div class="form-group">
            <label for="content">内容</label>
            <div id="content-box"></div>
            <textarea id="content" class="form-control input-lg" style="display:none" name="content" cols="30" 
            rows="10" placeholder="内容"><?php echo $has ? $data['content']:''  ?></textarea>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="slug">别名</label>
            <input id="slug" class="form-control" name="slug" type="text" placeholder="slug" 
            value="<?php echo $has ? $data['slug']:''  ?>">
            <p class="help-block">https://zce.me/post/<strong class="text-strong"><?php echo $has ? $data['slug']:'slug'  ?></strong></p>
          </div>
          <div class="form-group">
            <label for="feature">特色图像</label>
            <!-- show when image chose -->
            <img class="help-block thumbnail " style="display: <?php echo $has ? ( isset($url)? 'block':'none') :'none'  ?>;height:100px;width:auto" 
            src="<?php echo $has ? ( isset($url)? $url:''):''  ?>">
            <input id="feature" class="form-control upload-file" name="feature" type="file">
          </div>
          <div class="form-group">
            <label for="category">所属分类</label>
            <select id="category" class="form-control" name="category" data-id="<?php echo $has ? $data['category_id']:''  ?>">
              <option value="1">未分类</option>
              <option value="2">潮生活</option>
            </select>
          </div>
          <div class="form-group">
            <label for="created">发布时间</label>
            <input id="created" class="form-control" name="created" type="datetime-local" data-time="<?php echo $has ? $data['created']:''  ?>">
          </div>
          <div class="form-group">
            <label for="status">状态</label>
            <select id="status" class="form-control" name="status" data-state="<?php echo $has ? $data['status']:''  ?>">
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
  <script src="../assets/vendors/moment/moment-with-locales.js"></script>
  <script>NProgress.done()</script>
  <script>

    $(function(){

      var state = {
              drafted:'草稿',
              published:'已发布',
              trashed:'回收站'
            }
      // 动态生成分类下拉列表
      $.ajax({
        type:'get',
        url:'post/cateGet.php',
        data:{},
        dataType:'json',
        success:function(info){
          $('#category').html(template('tmp-cate',{list:info}));
                
          var cateid = $('#category').attr('data-id');
          $('#category option[value="'+ cateid +'"]').prop('selected',true);
        }
      })
      // 动态生成状态下拉列表
      $('#status').html(template('tmp-state',{list:state}));

      var statuss = $('#status').attr('data-state');
      $('#status option[value='+ statuss +']').prop('selected',true);
      // input标签改变事件
      $('#slug').on('input',function(){
        $('.text-strong').text($(this).val())
      })

      //编辑器插件的使用
      
      var E = window.wangEditor
        var editor = new E('#content-box')
        //onchange 需要在create之前绑定
        editor.customConfig.onchange = function (html) {
            // 监控变化，同步更新到 textarea
           $('#content').val(html);
        }

        editor.create();//生成富文本编辑器
        //当编辑器内容改变后，会调用
        //html  编辑器中内容

        $('.upload-file').change(function(){
          console.log($(this).files);
          var file = this.files[0];
          var url = URL.createObjectURL(file);
          $('.thumbnail').attr('src',url).show();
        })

        $textarea = $('#content').val();
        editor.txt.html($('#content').val()); 

        

        var t1 = $('#created').attr('data-time');
        if(t1){
          t1 = moment(t1).format('YYYY-MM-DDThh:mm');
        }else{
          t1 = moment().format('YYYY-MM-DDThh:mm');
        }
       $('#created').val(t1);

      
    

    })

  </script>
    <script type="text/template" id="tmp-cate">
    {{ each list $v}}
    <option value="{{ $v.id }}">{{ $v.name }}</option>
    {{ /each }}
  </script>
  <script type="text/template" id="tmp-state">
    {{ each list $v $i}}
      <option value="{{ $i }}">{{ $v }}</option>
    {{ /each }}
  </script>
</body>
</html>
