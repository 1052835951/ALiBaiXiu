<?php
    include_once '../../config.php';
    include_once '../../fn.php';
    $page = $_POST['page'];
    $pageNum = $_POST['pageNum'];
    $sql = "select posts.*,categories.name,users.nickname from posts
    join users on posts.user_id=users.id
    join categories on posts.category_id=categories.id
    order by posts.id desc";
    $res=my_query($sql);
    for($i=($page - 1)*$pageNum;$i<($page - 1)*$pageNum + $pageNum;$i++){
        if(isset($res[$i])){
            $result[]=$res[$i];
        }
    }
    $total = count($res);
    $arr = [
        'total' => $total,
        'list' => $result
    ];
    if(!$res){
        echo 'false';
    }else{
        echo json_encode($arr);
    }
?>