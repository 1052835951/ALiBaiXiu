<?php
    include_once '../../config.php';
    include_once '../../fn.php';
    $data = $_POST['data'];
    var_dump($data);
    for($i=0;$i<count($data);$i++){
        $id = $data[$i];
        $sql = "delete from comments where id=$id";
        my_exec($sql);
    }
?>