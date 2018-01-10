<?php
header('content-type:text/html;charset=utf-8');

include_once '../config.php';
  include '../fn.php';
  checkLogin();
  $sql = "select comments.id,comments.author, comments.content, comments.created, comments.status, posts.title from comments join posts on posts.id=comments.post_id";
  $arr = my_query($sql);
  // var_dump($arr);
  $leng = count($arr);
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
  <script src="../assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">

    <?php $page='comments.php' ?>
    <!-- 导入导航栏 -->
    <?php include './inc/head.php' ?>


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
        <div class="btn-batch" style="display:none">
          <button class="btn btn-info btn-sm">批量批准</button>
          <button class="btn btn-warning btn-sm">批量拒绝</button>
          <button class="btn btn-danger btn-sm btn-del-all">批量删除</button>
        </div>
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
            <th>作者</th>
            <th>评论</th>
            <th>评论在</th>
            <th>提交于</th>
            <th>状态</th>
            <th class="text-center" width="100">操作</th>
          </tr>
        </thead>
        <tbody>
          <!-- <tr class="danger">
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
          </tr> -->
          <?php for($i = 0; $i < $leng; $i++) { ?>
            <tr class="text-center">
              <td class="text-center" id="<?php echo $arr[$i]['id'] ?>"><input type="checkbox"></td>
              <td><?php echo $arr[$i]['author'] ?></td>
              <td><?php echo $arr[$i]['content'] ?></td>
              <td><?php echo $arr[$i]['title'] ?></td>
              <td><?php echo $arr[$i]['created'] ?></td>
              <td><?php switch ($arr[$i]['status']){

                          case 'approved':
                            echo '已批准';
                            break;
                          case 'rejected':
                            echo '已驳回';
                            break;
                          case 'held':
                            echo '未批准';
                            break;
              }
              ?></td>
              <td class="text-right">
                <?php if($arr[$i]['status'] == 'rejected' || $arr[$i]['status'] == 'held') {?>
                <a href="./approve_comment.php?id=<?php echo $arr[$i]['id'] ?>" class="btn btn-info btn-xs">批准</a>
                <?php } ?>
                <?php if($arr[$i]['status'] == 'approved') {?>
                <a href="./reject_comment.php?id=<?php echo $arr[$i]['id'] ?>" class="btn btn-warning btn-xs">驳回</a>
                <?php } ?>
                <a href="./delete_comment.php?id=<?php echo $arr[$i]['id'] ?>" class="btn btn-danger btn-xs">删除</a>
              </td>
            </tr>
          <?php } ?>
          
        </tbody>
      </table>
    </div>
  </div>

  <!-- 导入侧边栏 -->
  <?php include './inc/aside.php' ?>
  
  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script src="./template-web.js"></script>
  <script>NProgress.done()</script>
  <script>

var obj = {
      held:'待审核',
      approved:'已批准',
      rejected:'已驳回',
      trashed:'回收站'
    }
   function render(){
      $.ajax({
        type:'get',
        url:'./comAdd.php',
        data:{},
        dataType:'json',
        success:function(info){
          $('tbody').html(template('tmp_table',{list:info,obj:obj}));
        }
      })
    }
     $('tbody input').change(function(){
         var flag = true;
        $('tbody input').each(function(index,ele){
          if(ele.checked == true){
            flag=false;
            $('.btn-batch').show();
          }
        })
       if(flag){
        $('.btn-batch').hide();
        flag=true;

       }
     })
     var arr = [];
     $('.btn-del-all').click(function(){
      $('tbody input').each(function(index,ele){
          if(ele.checked == true){
            arr.push($(ele).parent().attr('id'));
          }
        })
        console.log(arr);
        $.ajax({
          type:'post',
          url:'./com-del-all.php',
          data:{ data:arr },
          success:function(info){
            render();
          }
        })
     })

  </script>
  <script type="text/complate" id="tmp_table">
    {{ each list $v }}
      <tr>
          <td class="text-center"><input type="checkbox"></td>
          <td>{{ $v.author }}</td>
          <td>{{ $v.content }}</td>
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
