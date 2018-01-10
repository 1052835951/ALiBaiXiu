<?php
    header('content-type:text/html;charset=utf-8');
    
    include_once '../../config.php';
    include_once '../../fn.php';
    $page = $_GET['page'];
    $pageNum = $_GET['pageNum'];
    $index = ($page - 1)*$pageNum;
    $sql = "select comments.*,posts.title from comments join posts on comments.post_id=posts.id limit $index,$pageNum";
    echo json_encode(my_query($sql));
?>