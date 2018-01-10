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
  <link rel="stylesheet" href="../assets//vendors/pagination/pagination.css">
  <script src="../assets/vendors/nprogress/nprogress.js"></script>
  <style>
    .pagination{
      float: right;
    }
    .pagination a{
      border-radius: 3px;
      padding: 5px 5px;
    }
    .pagination span{
      border-radius: 3px;
      padding: 5px 5px;
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
        <h1>所有评论</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <div class="btn-batch" style="display: none">
          <button class="btn btn-info btn-sm btn-appr-sel">批量批准</button>
          <!-- <button class="btn btn-warning btn-sm">批量拒绝</button> -->
          <button class="btn btn-danger btn-sm btn-del-sel">批量删除</button>
        </div>
        <div class="pagination">

        </div>
      </div>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th class="text-center" width="40"><input type="checkbox" class="th-chk"></th>
            <th>作者</th>
            <th>评论</th>
            <th>评论在</th>
            <th>提交于</th>
            <th>状态</th>
            <th class="text-center" width="100">操作</th>
          </tr>
        </thead>
        <tbody>
          <tr class="danger">
            <td class="text-center"><input type="checkbox"></td>
            <td>大大</td>
            <td>楼主好人，顶一个</td>
            <td>《Hello world》</td>
            <td>2016/10/07</td>
            <td>未批准</td>
            <td class="text-center">
              <a href="post-add.html" class="btn btn-info btn-xs">批准</a>
              <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr>
          <tr>
            <td class="text-center"><input type="checkbox"></td>
            <td>大大</td>
            <td>楼主好人，顶一个</td>
            <td>《Hello world》</td>
            <td>2016/10/07</td>
            <td>已批准</td>
            <td class="text-center">
              <a href="post-add.html" class="btn btn-warning btn-xs">驳回</a>
              <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr>
          <tr>
            <td class="text-center"><input type="checkbox"></td>
            <td>大大</td>
            <td>楼主好人，顶一个</td>
            <td>《Hello world》</td>
            <td>2016/10/07</td>
            <td>已批准</td>
            <td class="text-center">
              <a href="post-add.html" class="btn btn-warning btn-xs">驳回</a>
              <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr>
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
  <script src="../assets/vendors/pagination/jquery.pagination.js"></script>
  <script>NProgress.done()</script>
  <script>
    var obj = {
      held:'待审核',
      approved:'已批准',
      rejected:'已驳回',
      trashed:'回收站'
    }
    function render(page,pageNum){
      $.ajax({
        type:'get',
        url:'./comments/comAdd.php',
        data:{
          page:page||1,
          pageNum:pageNum || 10
        },
        dataType:'json',
        success:function(info){
          $('tbody').html(template('tmp_table',{list:info,obj:obj}));
        },
        complete:function(){
          // page_render();
        }
      })
      page_render();  
    }


    function page_render(){
      $.ajax({
          type:'get',
          url:'./comments/getTotal.php',
          data:null,
          dataType:'json',
          success:function(info){
            // console.log(info['total'])
            $('.pagination').pagination(info['total'],{
              prev_text:'上一页',
              next_text:'下一页',
              items_per_page:10,
              load_first_page:false,
              current_page:window.con_page - 1|| 0,
              callback:function(index){
                render(index + 1);
                $('.th-chk').prop('checked',false);
                ids = [];
                
                window.con_page = index + 1;
              }

            });
          }

        })
    }


    render();

    $('tbody').on('click','.btn-del',function(){
      // alert(111);
      var id = $(this).parent().attr('data-id');
      $.ajax({
        type:'get',
        url:'comments/com_del.php',
        data:{
          id:id
        },
        dataType:'json',
        success:function(info){
          if(info['status']==200){

          var pages = Math.ceil(info['total']/10);
                
          window.con_page = window.con_page > pages ? pages :window.con_page;
            render(window.con_page);
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
            render(window.con_page);
          }
        }
      })
    })
    var ids = [];
    $('tbody').on('change','.td-chk',function(){
      var id = $(this).parent().attr('data-id');

      if($(this).prop('checked')){
        if(ids.indexOf(id) == -1){
          ids.push(id);
        }
      }else{
        ids.splice(ids.indexOf(id),1);
      }

      ids.length==0? $('.btn-batch').hide(): $('.btn-batch').show();
      var strid = ids.join();
      $('.btn-batch').attr('data-ids',strid);
      if($('tbody .td-chk').length == ids.length){
        $('.th-chk').prop('checked',true);
      }else{
        $('.th-chk').prop('checked',false);
      }

    })
    $('.th-chk').change(function(){
      $('.td-chk').prop('checked',$(this).prop('checked')).trigger('change');
    })
   
    
    //批量批准
    $('.btn-appr-sel').click(function(){
      var id = $(this).parent().attr('data-ids');
      $.ajax({
        type:'get',
        url:'./comments/com_accp.php',
        data:{id:id},
        success:function(info){
          render(window.con_page);
          $('.th-chk').prop('checked',false);
          ids=[];
        }
      })
    })
    //批量删除
    $('.btn-del-sel').click(function(){
      var id = $(this).parent().attr('data-ids');
      $.ajax({
        type:'get',
        url:'./comments/com_del.php',
        data:{id:id},
        dataType:'json',
        success:function(info){
          console.log(info);
          // $page =  

          var pages = Math.ceil(info['total']/10);
                
          window.con_page = window.con_page > pages ? pages :window.con_page;
          render(window.con_page);
          $('.th-chk').prop('checked',false);
          ids=[];
        }
      })
    })
  </script>

  <script type="text/complate" id="tmp_table">
    {{ each list $v }}
      <tr>
          <td class="text-center" data-id="{{ $v.id }}"><input type="checkbox" class="td-chk"></td>
          <td>{{ $v.author }}</td>
          <td>{{ $v.content.substr(0,20)+'...' }}</td>
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
</body>
</html>
