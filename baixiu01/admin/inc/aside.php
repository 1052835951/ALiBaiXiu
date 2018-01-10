<?php
  $id = $_SESSION['current_user_id'];
  $data = my_query("select * from users where id=$id");

?>

<!-- 侧边栏 -->
  <div class="aside">
    <div class="profile">
      <img class="avatar" src="<?php echo empty($data[0]['avatar'])?'../assets/img/default.png':$data[0]['avatar'] ?>">
      <h3 class="name"><?php echo $data[0]['nickname'] ?></h3>
    </div>
    <ul class="nav">
      <li class=<?php echo $page=='index1'?"active":"" ?>>
        <!-- 选中.html 连续按 ctrl+D 向下选中所有.html 修改为PHP   -->
        <a href="index1.php"><i class="fa fa-dashboard" ></i>仪表盘</a>
      </li>
      <li class=<?php echo in_array($page,['posts','post-add','categories'])?"active":"" ?>>
        <a href="#menu-posts" class="<?php echo in_array($page,['posts','post-add','categories'])?"":"collapsed" ?>" data-toggle="collapse">
          <i class="fa fa-thumb-tack"></i>文章<i class="fa fa-angle-right"></i>
        </a>
        <ul id="menu-posts" class="collapse <?php echo in_array($page,['posts','post-add','categories'])?"in":"" ?>">
          <li class=<?php echo $page=='posts'?"active":"" ?> ><a href="posts.php">所有文章</a></li>
          <li class=<?php echo $page=='post-add'?"active":"" ?> ><a href="post-add.php">写文章</a></li>
          <li class=<?php echo $page=='categories'?"active":"" ?> ><a href="categories.php">分类目录</a></li>
        </ul>
      </li>
      <li class=<?php echo $page=='comments'?"active":"" ?>>
        <a href="comments.php"><i class="fa fa-comments"></i>评论</a>
      </li>
      <li class=<?php echo $page=='users'?"active":"" ?>>
        <a href="users.php"><i class="fa fa-users"></i>用户</a>
      </li>
      <li class=<?php echo in_array($page,['nav-menus','slides','settings'])?"active":"" ?>>
        <a href="#menu-settings" class="<?php echo in_array($page,['nav-menus','slides','settings'])?"":"collapsed" ?>" data-toggle="collapse">
          <i class="fa fa-cogs"></i>设置<i class="fa fa-angle-right"></i>
        </a>
        <ul id="menu-settings" class="collapse <?php echo in_array($page,['nav-menus','slides','settings'])?"in":"" ?>">
          <li  class=<?php echo $page=='nav-menus'?"active":"" ?>><a href="nav-menus.php">导航菜单</a></li>
          <li class=<?php echo $page=='slides'?"active":"" ?>><a href="slides.php">图片轮播</a></li>
          <li class=<?php echo $page=='settings'?"active":"" ?>><a href="settings.php">网站设置</a></li>
        </ul>
      </li>
    </ul>
  </div>