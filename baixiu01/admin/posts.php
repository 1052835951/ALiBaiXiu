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
  <title>Posts &laquo; Admin</title>
  <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
  <script src="../assets/vendors/nprogress/nprogress.js"></script>
  <style>
    .hover-ele {
      color:red !important;
    }
    .nouse-ele{
      color:#ccc !important;
      background-color: #666 !important;
    }
  </style>
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
          <select name="" class="form-control input-sm cate_sele">
          </select>
          <select name="" class="form-control input-sm state-sele">
          </select>
          <button class="btn btn-default btn-sm btn-filtrate">筛选</button>
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
  <script>NProgress.done()</script>
  <script src="../assets/vendors/complate/template-web.js"></script>
  <script>

    var obj = {
      drafted:'草稿',
      published:'已发布',
      trashed:'回收站'
    }
    function render(page,pageNum){
      var page = page || 1;
      var pageNum = pageNum || 10;
      $.ajax({
        type:'post',
        url:'./post/postAdd.php',
        data:{
          page:page,
          pageNum:pageNum
        },
        dataType:'json',
        success:function(info){
          if(info == 'false'){
            $('tbody').html('');
          }else{
            info['obj']=obj;
            $('tbody').html(template('tmp-table',info));
          }
          //动态生成页码
          var page1 = Math.ceil(info.total/pageNum);
          $('.pagination').html(template('tmp_page',{total:page1}));
          //上一页，下一页页码属性设置
          var prev_page = +page-1;
          var next_page = +page + 1;
          prev_page = prev_page < 1? 1 : prev_page;
          next_page = next_page > +page1 ? page1 : next_page;
          $('.prev-page').attr('data_page',prev_page);
          $('.next-page').attr('data_page',next_page);


          //当前页页码高亮显示
          for(var i =0; i<$('.pages').length;i++){
            if(page == $($('.pages')[i]).attr('data_page')){
              $($('.pages')[i]).children().addClass('hover-ele');
            }
          }
          
          if(page ==1 ){
            $('.prev-page').children().addClass('nouse-ele');
          }
          if(page ==page1 ){
            $('.next-page').children().addClass('nouse-ele');
          }
          $('.pagination li').click(function(){
            if($(this).children().hasClass('nouse-ele')){
              return false;
            }
            var page = $(this).attr('data_page');
            render(page);
            window.con_page = page;
            $('.th-chk').prop('checked',false);
            $('.btn-batch').hide();
          })
          
        }
      })
    }
    render();
    $.ajax({
      type:'get',
      url:'./post/cateAdd.php',
      dataType:'json',
      success:function(info){
        $('.cate_sele').html(template('tmp-cate',{list:info}));
      },
      complete:function(){
        
      }
    })
    $(function(){
       $('.state-sele').html(template('tmp-state',{list:obj}));
    })
  </script>
  <script type="text/template" id="tmp-table">
  {{ each list $v}}
    <tr>
      <td class="text-center"><input type="checkbox"></td>
      <td>{{ $v.title }}</td>
      <td>{{ $v.nickname }}</td>
      <td>{{ $v.name }}</td>
      <td class="text-center">{{ $v.created }}</td>
      <td class="text-center">{{ obj[$v.status] }}</td>
      <td class="text-center">
        <a href="javascript:;" class="btn btn-default btn-xs">编辑</a>
        <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
      </td>
    </tr>
    {{ /each }}
  </script>
  <script type="text/template" id="tmp_page">
    
      <li class="prev-page"><a href="#">上一页</a></li>
      <% for(var i = 0; i < 7; i++){ %>
          <li data_page="<%= i+1 %>" class="pages"><a href="#"><%= i+1 %></a></li>
           <% } %>
      <li class="next-page"><a href="#">下一页</a></li>
   
</script>
<script type="text/template" id="tmp-cate">
  <option value="0" selected>所有分类</option>
  {{ each list $v}}
  <option value="{{ $v.id }}">{{ $v.name }}</option>
  {{ /each }}

</script>
<script type="text/template" id="tmp-state">
  <option value="all" selected>所有状态</option>
  {{ each list $v $i}}
  <option value="{{ $i }}">{{ $v }}</option>
  {{ /each }}


</script>
</body>
</html>
