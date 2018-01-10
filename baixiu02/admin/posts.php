<?php 
 include_once '../config.php';
  include_once '../fn.php';
  //判断登录
  checkLogin();

?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Posts &laquo; Admin</title>
  <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
  <link rel="stylesheet" href="../assets/vendors/pagination/pagination.css">
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
        <h1>所有文章</h1>
        <a href="post-add.html" class="btn btn-primary btn-xs">写文章</a>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <a class="btn btn-danger btn-sm" href="javascript:;" style="display: none">批量删除</a>
        <form class="form-inline">
          <select name="" class="form-control input-sm cate-select">
            <!-- 模板插入分类 -->
          </select>
          <select name="" class="form-control input-sm state-select">
            <!-- 模板插入状态 -->
          </select>
        </form>
        <ul class="pagination pagination-sm pull-right">
          <li><a href="#">上一页</a></li>
          <li><a href="#">1</a></li>
          <li><a href="#">2</a></li>
          <li><a href="#">3</a></li>
          <li><a href="#">下一页</a></li>
        </ul>
      </div>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th class="text-center" width="40"><input type="checkbox"></th>
            <th>标题</th>
            <th>作者</th>
            <th>分类</th>
            <th class="text-center">发表时间</th>
            <th class="text-center">状态</th>
            <th class="text-center" width="100">操作</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="text-center"><input type="checkbox"></td>
            <td>随便一个名称</td>
            <td>小小</td>
            <td>潮科技</td>
            <td class="text-center">2016/10/07</td>
            <td class="text-center">已发布</td>
            <td class="text-center">
              <a href="javascript:;" class="btn btn-default btn-xs">编辑</a>
              <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <?php $page = 'posts' ?>
  <!-- 侧边栏 -->
  <?php  include './inc/aside.php' ?>

  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script src="../assets/vendors/complate/template-web.js"></script>
  <script src="../assets/vendors/pagination/jquery.pagination.js"></script>
  <script>NProgress.done()</script>
  <script>
    $(function(){
        var state = {
          drafted:'草稿',
          published:'已发布',
          trashed:'回收站'
        }
      function render(page,pageNum){
        var status = $('.state-select').val();
        console.log($('.state-select'));
        var cateid = $('.cate-select').val();
        console.log($('.cate-select'));
        $.ajax({
          type:'get',
          url:'./post/postAdd.php',
          data:{
            page:page||1,
            pageNum:pageNum||10,
            status:status || 'all',
            cateid:cateid|| '0'
          },
          dataType:'json',
          success:function(info){
          $('tbody').html( template('tmp-post',{list:info,state:state}));
          }
        })
      }
      render();
      page_render();
    function page_render(page,pageNum){
        var status = $('.state-select').val();
        console.log($('.state-select'));
        var cateid = $('.cate-select').val();
        console.log($('.cate-select'));
        $.ajax({
          type:'get',
          url:'./post/getTotal.php',
          data:{
            page:page||1,
            pageNum:pageNum||10,
            status:status || 'all',
            cateid:cateid|| '0'
          },
          dataType:'json',
          success:function(info){
            console.log(info['total'])
            $('.pagination').pagination(info['total'],{
              prev_text:'上一页',
              next_text:'下一页',
              items_per_page:10,
              load_first_page:false,
              callback:function(index){
                render(index + 1);
                $('.th-chk').prop('checked',false);
                ids = [];
                console.log(ids)
                window.con_page = index + 1;
              }

            });
          }

        })
    }
      $.ajax({
        type:'get',
        url:'post/cateGet.php',
        data:{},
        dataType:'json',
        success:function(info){
          $('.cate-select').html(template('tmp-cate',{list:info}));
        }
      })

      $('.state-select').html(template('tmp-state',{list:state}));

      //下拉列表change触发事件
      $('.cate-select,.state-select').change(function(){
        render();
        page_render();
      })

    })
    </script>

    <!-- 模板 -->
    <script type="text/template" id="tmp-post">
      {{ each list $v }}
        <tr>
            <td class="text-center"><input type="checkbox"></td>
            <td>{{ $v.title}}</td>
            <td>{{ $v.nickname}}</td>
            <td>{{ $v.name }}</td>
            <td class="text-center">{{ $v.created}}</td>
            <td class="text-center">{{ state[$v.status] }}</td>
            <td class="text-center">
              <a href="./post-add.php?id={{ $v.id }}" class="btn btn-default btn-xs">编辑</a>
              <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr>
      {{  /each }}
    
  </script>
  <script type="text/template" id="tmp-cate">
    <option value="0" selected >所有分类</option>
    {{ each list $v}}
    <option value="{{ $v.id }}">{{ $v.name }}</option>
    {{ /each }}
  </script>
  <script type="text/template" id="tmp-state">
    <option value="all" selected >所有状态</option>
    {{ each list $v $i}}
      <option value="{{ $i }}">{{ $v }}</option>
    {{ /each }}
  </script>
</body>
</html>
