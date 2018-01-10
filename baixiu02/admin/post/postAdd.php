<?php 
    include_once '../../config.php';
    include_once '../../fn.php';
    $page = $_GET['page'];
    $pageNum = $_GET['pageNum'];
    $index = ($page - 1)*$pageNum;
    $cateid = $_GET['cateid'];
    $status = $_GET['status'];
    if($cateid == 0){
        $cateid = '%';
    }
    if($status == 'all'){
        $status = '%';
    }
    $sql = "select posts.*,categories.name,users.nickname from posts
    join users on posts.user_id=users.id
    join categories on posts.category_id=categories.id
    where posts.category_id like '$cateid' and posts.status like '$status'
    order by posts.id desc
    limit $index,$pageNum";
    $data = my_query($sql);
    echo json_encode($data);


?>