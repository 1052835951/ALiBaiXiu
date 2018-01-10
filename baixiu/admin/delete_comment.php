<?php
include_once '../config.php';
    include '../fn.php';
    $id = $_GET['id'];
    var_dump($id);
    $sql = "delete from comments where id='$id'";
    my_exea($sql);
    header('location: ./comments.php');
?>