<?php
    include_once '../../config.php';
    include_once '../../fn.php';

    $sql = "select comments.*,posts.title from comments join posts on comments.post_id=posts.id";
    echo json_encode(['total'=>count(my_query($sql))]);
?>