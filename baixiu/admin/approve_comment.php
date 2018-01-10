<?php 
include_once '../config.php';
     include '../fn.php';
     $id = $_GET['id'];
     var_dump($id);
     $sql = "update comments set status='approved' where id='$id'";
     my_exea($sql);
     header('location: ./comments.php');
?>