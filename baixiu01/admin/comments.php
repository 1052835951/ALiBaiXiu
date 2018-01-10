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
  <title>Comments &laquo; Admin</title>
  <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
  <style>
    .hover-ele {
      color:red !important;
    }
    .nouse-ele{
      color:#ccc !important;
      background-color: #666 !important;
    }
  </style>
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
        <h1>所有评论</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <div class="btn-batch" style="display: none">
          <button class="btn btn-info btn-sm btn-prev-all">批量批准</button>
          <button class="btn btn-warning btn-sm btn-rej-all">批量拒绝</button>
          <button class="btn btn-danger btn-sm btn-del-all">批量删除</button>
        </div>
        <ul class="pagination pagination-sm pull-right">
         
        </ul>
      </div>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th class="text-center" width="40"><input class="th-chk" type="checkbox"></th>
            <th>作者</th>
            <th>评论</th>
            <th>评论在</th>
            <th>提交于</th>
            <th>状态</th>
            <th class="text-center" width="100">操作</th>
          </tr>
        </thead>
        <tbody>
         
        </tbody>
      </table>
    </div>
  </div>
  <?php $page = 'comments' ?>

  <!-- 侧边栏 -->
  <?php  include './inc/aside.php' ?>

  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script src="../assets/vendors/complate/template-web.js"></script>
  <script>NProgress.done()</script>
  <script>
    var obj = {
      held:'待审核',
      approved:'已批准',
      rejected:'已驳回',
      trashed:'回收站'
    }
    function render(page,pageNum){
      var page = page || 1;
      var pageNum = pageNum || 10;
      $.ajax({
        type:'post',
        url:'./comments/comAdd.php',
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
            $('tbody').html(template('tmp_table',info));
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

    render(1);

    $('tbody').on('click','.btn-del',function(){
      // alert(111);
      var id = $(this).parent().attr('data-id');
      $.ajax({
        type:'post',
        url:'comments/com_del.php',
        data:{
          id:id
        },
        dataType:'json',
        success:function(info){
          console.log(info);
          if(info['status']==200){
            render();
          }
        }
      })
    })
    $('tbody').on('click','.btn-accp',function(){
      var id = $(this).parent().attr('data-id');
      $.ajax({
        type:'post',
        url:'./comments/com_accp.php',
        data:{id:id},
        dataType: 'json',
        success:function(info){
          if(info['status']==200){
            render();
          }
        }
      })
    })

    //实现显示群组操作按钮
    $('tbody').on('change','input',function(){
      var flag = true;
      var leng = 0;
      $('tbody input').each(function(index,ele){
        if(ele.checked == true){
          leng++;
          flag=false;
          $('.btn-batch').show();
        }
      })
      if(flag){
        $('.btn-batch').hide();
      }
      if($('tbody input').length == leng){
        $('.th-chk').prop('checked',true);
      }else{
        $('.th-chk').prop('checked',false);
      }
    })
    //全部删除按钮功能实现
    $('.btn-del-all').click(function(){
      var arr = [];
      $('tbody input').each(function(index,ele){
        if(ele.checked == true){
          arr.push($(ele).parent().siblings('.text-right').attr('data-id'))
        }
      })
      $.ajax({
        type:'post',
        url:'comments/del_all.php',
        data:{
          data:arr
        },
        success:function(info){
          render(window.con_page);
          $('.btn-batch').hide();

          $('.th-chk').prop('checked',false);
        }
      })
    })
    //批量拒绝按钮功能实现
    $('.btn-rej-all').click(function(){
      var arr = [];
      $('tbody input').each(function(index,ele){
        if(ele.checked == true){
          arr.push($(ele).parent().siblings('.text-right').attr('data-id'))
        }
      })
      $.ajax({
        type:'post',
        url:'comments/rej-all.php',
        data:{
          data:arr
        },
        success:function(info){
          render(window.con_page);
          $('.btn-batch').hide();

          $('.th-chk').prop('checked',false);
        }
      })
    })
    //批量批准按钮功能实现
    $('.btn-prev-all').click(function(){
      var arr = [];
      $('tbody input').each(function(index,ele){
        if(ele.checked == true){
          arr.push($(ele).parent().siblings('.text-right').attr('data-id'))
        }
      })
      $.ajax({
        type:'post',
        url:'comments/prev_all.php',
        data:{
          data:arr
        },
        success:function(info){
          render(window.con_page);
          $('.btn-batch').hide();
            $('.th-chk').prop('checked',false);
        }
      })
    })
    //全选按钮功能实现
    $('.th-chk').change(function(){
      if($(this).prop('checked')){
        $('tbody input').each(function(index,ele){
          $(ele).prop('checked',true);
          $(ele).trigger('change');
        })
      }else{
        $('tbody input').each(function(index,ele){
          $(ele).prop('checked',false);
          $(ele).trigger('change');
        })
      }

    })

  </script>
  <script type="text/complate" id="tmp_table">
    {{ each list $v }}
      <tr>
          <td class="text-center"><input type="checkbox"></td>
          <td>{{ $v.author }}</td>
          <td>{{ $v.content.substr(0,20) }}</td>
          <td>《{{ $v.title }}》</td>
          <td>{{ $v.created }}</td>
          <td>{{ obj[$v.status] }}</td>
          <td class="text-right" data-id="{{ $v.id }}">
            {{ if $v.status=='held' }}
            <a href="javascript:;" class="btn btn-info btn-xs btn-accp">批准</a>
            {{ /if }}
            <a href="javascript:;" class="btn btn-danger btn-xs btn-del">删除</a>
          </td>
        </tr>
    {{ /each }}
</script>
<script type="text/template" id="tmp_page">
    
      <li class="prev-page"><a href="#">上一页</a></li>
      <% for(var i = 0; i < total; i++){ %>
          <li data_page="<%= i+1 %>" class="pages"><a href="#"><%= i+1 %></a></li>
           <% } %>
      <li class="next-page"><a href="#">下一页</a></li>
   
</script>
</body>
</html>
