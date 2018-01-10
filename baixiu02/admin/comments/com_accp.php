<?php
    include_once '../../config.php';
    include_once '../../fn.php';

     $id = $_GET['id'];
     $sql = "update comments set status='approved' where id in ($id)";

     if(my_exec($sql)){
        $data = [
            "msg"=>"操作成功",
            "status"=>200
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