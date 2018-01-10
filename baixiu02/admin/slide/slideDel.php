<?php
    include_once '../../config.php';
    include_once '../../fn.php';
    $index = $_GET['index'];
    $sql = "select * from options";
    $res = my_query($sql)[9]['value'];
    // var_dump($res);
    $result = json_decode($res,true);
    unset($result[$index]);
    $result = json_encode($result,JSON_UNESCAPED_UNICODE);
    $sql1 = "update options set value='$result' where id=10";
    my_exec($sql1);
?>