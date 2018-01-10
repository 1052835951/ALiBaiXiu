<?php
include_once '../config.php';
    include '../fn.php';
    $id = $_GET['id'];
    var_dump($id);
    $sql = "update comments set status='rejected' where id='$id'";
    my_exea($sql);
    header('location: ./comments.php');
?>