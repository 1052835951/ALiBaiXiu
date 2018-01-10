<?php
    include_once '../../config.php';
    include_once '../../fn.php';

// var_dump($_POST);
// var_dump($_FILES);
    $text = $_POST['text'];
    $link = $_POST['link'];
    if(!empty($_FILES) && $_FILES['image']['error']==0){
        $ftmp = $_FILES['image']['tmp_name'];
        $name = $_FILES['image']['name'];
        $ext = strrchr($name,'.');
        $newname = 'uploads/slide_'.rand(0,100).$ext;
    
        move_uploaded_file($ftmp,'../../'.$newname);
    
        $arr = [
            'image'=>$newname,
            'text'=>$text,
            'link'=>$link
        ];
    
        $sql = "select * from options";
        $res = my_query($sql)[9]['value'];
        // var_dump($res);
        $result = json_decode($res,true);
        $result[]=$arr;
        $result = json_encode($result,JSON_UNESCAPED_UNICODE);
    
        $sql1 = "update options set value='$result' where id=10";
        my_exec($sql1);
    }
   

?>