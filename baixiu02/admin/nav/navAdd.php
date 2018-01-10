<?php
    include_once '../../config.php';
    include_once '../../fn.php';
    $icons = [
        'fa fa-gift',
        'fa fa-fire',
        'fa fa-phone',
        'fa fa-glass'
    ];
    $icon = $icons[array_rand($icons)];
    $text = $_POST['text'];
    $title = $_POST['title'];
    $link = $_POST['href'];

    $arr = [
        'icon'=>$icon,
        'title'=>$title,
        'link'=>$link,
        'text'=>$text
    ];
    $sql = "select value from options where id=9";

    $info = my_query($sql)[0]['value'];
    var_dump($info);
    $info = json_decode($info,true);
    var_dump($info);

    $info[]=$arr;


    $info = json_encode($info,JSON_UNESCAPED_UNICODE);

    $sql = "update options set value='$info' where id=9";

    my_exec($sql);


?>