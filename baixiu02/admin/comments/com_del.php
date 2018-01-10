<?php
    include_once '../../config.php';
    include_once '../../fn.php';

    $id = $_GET['id'];
    $sql = "delete from comments where id in ($id)";
    if(my_exec($sql)){
        $sql = "select count(*) as total from comments join posts on comments.post_id=posts.id";
        $total = my_query($sql)[0]['total'];
        $data = [
            "msg"=>"操作成功",
            "status"=>200,
            'total'=>$total
        ];
        $data = json_encode($data);
        echo $data;
    }else{
        $data = [
            "msg"=>"操作失败",
            "status"=>100
        ];
        $data = json_encode($data);
        echo $data;
    }
?>