<?php   
    include_once '../../config.php';
    include_once '../../fn.php';
    $sql = "select * from categories";
    echo json_encode(my_query($sql));
?>