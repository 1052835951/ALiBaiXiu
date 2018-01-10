<?php 
    include_once '../../config.php';
    include_once  '../../fn.php';
    
    if(!isset($_GET['id'])){
        $id = '%';
    }else{
        $id = $_GET['id'];
    }
    $sql = "select * from categories where id like '$id'";

    echo json_encode(my_query($sql));
?>