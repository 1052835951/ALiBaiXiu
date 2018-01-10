<?php
    // include './fn.php';
    
    $id = $_SESSION['id'];
    $sql = "select * from users where id='$id'";

    $arr = my_query($sql);
    $pic = $arr[0]['avatar'];
    $nickname = $arr[0]['nickname'];

?>
<div class="aside">
    <div class="profile">
      <img class="avatar" src="<?php echo $pic ?>">
      <h3 class="name"><?php echo $nickname ?></h3>
      <?php echo $page ?>
    </div>
    <ul class="nav">
      <li class=<?php echo $page=='index1.php'?"active":"" ?>>
        <a href="index1.php"><i class="fa fa-dashboard"></i>仪表盘</a>
      </li>
      <li class=<?php echo in_array($page,["posts.php","post-add.php","categories.php"])?"active":"" ?>>
        <a href="#menu-posts" data-toggle="collapse" class="<?php echo in_array($page,["posts.php","post-add.php","categories.php"])?"":"collapsed" ?>">
          <i class="fa fa-thumb-tack"></i>文章<i class="fa fa-angle-right"></i>
        </a>
        <ul id="menu-posts" class="collapse <?php echo in_array($page,["posts.php","post-add.php","categories.php"])?"in":"" ?>">
          <li class=<?php echo $page=="posts.php"?"active":"" ?> ><a href="posts.php">所有文章</a></li>
          <li class=<?php echo $page=="post-add.php"?"active":"" ?> ><a href="post-add.php">写文章</a></li>
          <li class=<?php echo $page=="categories.php"?"active":"" ?> ><a href="categories.php">分类目录</a></li>
        </ul>
      </li>
      <li class=<?php echo $page=='comments.php'?"active":"" ?>>
        <a href="comments.php"><i class="fa fa-comments"></i>评论</a>
      </li>
      <li class=<?php echo $page=='users.php'?"active":"" ?>>
        <a href="users.php"><i class="fa fa-users"></i>用户</a>
      </li>
      <li class=<?php echo in_array($page,["nav-menus.php","slides.php","settings.php"])?"active":"" ?>>
        <a href="#menu-settings" class="<?php echo in_array($page,["nav-menus.php","slides.php","settings.php"])?"":"collapsed" ?>" data-toggle="collapse">
          <i class="fa fa-cogs"></i>设置<i class="fa fa-angle-right"></i>
        </a>
        <ul id="menu-settings" class="collapse <?php echo in_array($page,["nav-menus.php","slides.php","settings.php"])?"in":"" ?>">
          <li class=<?php echo $page=="nav-menus.php"?"active":"" ?> ><a href="nav-menus.php">导航菜单</a></li>
          <li class=<?php echo $page=="slides.php"?"active":"" ?> ><a href="slides.php">图片轮播</a></li>
          <li class=<?php echo $page=="settings.php"?"active":"" ?> ><a href="settings.php">网站设置</a></li>
        </ul>
      </li>
    </ul>
  </div>
