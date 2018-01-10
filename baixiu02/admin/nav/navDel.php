<?php
    include_once '../../config.php';
    include_once '../../fn.php';

    $index = $_GET['index'];
    $sql = "select value from options where id=9";
    $info = my_query($sql)[0]['value'];
    $info = json_decode($info,true);

    unset($info[$index]);


    $info = json_encode($info,JSON_UNESCAPED_UNICODE);

    $sql = "update options set value='$info' where id=9";

    my_exec($sql);

?>