<?php
    include_once '../../config.php';
    include_once '../../fn.php';

    $state = $_GET['state'];
    $cate = $_GET['cate'];
    if($state == 'all'){
        if($cate==0){
            $sql = "select posts.*,categories.name,users.nickname from posts
            join users on posts.user_id=users.id
            join categories on posts.category_id=categories.id";
        }else{
            $sql = "select posts.*,categories.name,users.nickname from posts
            join users on posts.user_id=users.id
            join categories on posts.category_id=categories.id
             where posts.category_id='$cate'";
        }
    }else{
        if($cate==0){
            $sql = "select posts.*,categories.name,users.nickname from posts
            join users on posts.user_id=users.id
            join categories on posts.category_id=categories.id
             where posts.status='$state'";
        }else{
            $sql = "select posts.*,categories.name,users.nickname from posts
            join users on posts.user_id=users.id
            join categories on posts.category_id=categories.id
             where posts.status='$state' and category_id='$cate'";
        }
    }
    // echo $sql;
    $arr=[
        'list'=>my_query($sql),
        'total'=>count(my_query($sql))
    ];
    echo json_encode($arr);

?>