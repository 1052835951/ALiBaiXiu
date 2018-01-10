<?php
include '../fn.php';
 checkLogin();

 unset($_SESSION['id']);

 header('location: ./login.php');
?>