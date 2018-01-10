<?php
    include_once '../../config.php';
    include_once '../../fn.php';

    $sql="select * from options where id=9";

    echo json_encode(my_query($sql));
    
?>