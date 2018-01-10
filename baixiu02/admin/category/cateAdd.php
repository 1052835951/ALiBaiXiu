<?php
    include_once '../../config.php';
    include_once '../../fn.php';

    $name = $_GET['name'];
    $slug = $_GET['slug'];
    $id = isset($_GET['id']);
    // var_dump(empty($name)||empty($slug));
    // var_dump(empty($id));
    if(empty($name)||empty($slug)){
        $info=[
            'msg'=>'数据不完整！',
            'status'=>100
        ];
        echo json_encode($info);
    }else{
         if(!$id){
            $sql = "insert into categories (name,slug) values ('$name','$slug')";
        }else{
            $id1=$_GET['id'];
            $sql = "update categories set name='$name',slug='$slug' where id='$id1'";
        }
        
        $info = my_exec($sql);
        if($info){
            $res = [
                'msg'=> "操作成功！",
                'status'=>200
            ];
        }else{
            $res = [
                'msg'=> "操作失败！",
                'status'=>100
            ];
        }

        echo json_encode($res);
    }

   
?>