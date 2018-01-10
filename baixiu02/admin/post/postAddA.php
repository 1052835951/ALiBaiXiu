<?php
    include_once '../../config.php';
    include_once '../../fn.php';
//    var_dump($_POST);
//     var_dump($_FILES);
    session_start();
    $title = $_POST['title'];
    $content  = $_POST['content'];
    $slug = $_POST['slug'];
    $cateid = $_POST['category'];
    $created = $_POST['created'];
    $status = $_POST['status'];
    // echo $title;
    // echo $content;
    // echo $slug;
    // echo $cateid;
    // echo $created;
    // echo $status;
    $tmp = $_FILES['feature']['tmp_name'];
    $lname = strrchr($_FILES['feature']['name'],'.');
    $feature = 'uploads/'.time().rand(1000,9999).$lname;
    // echo $feature;
    move_uploaded_file($tmp,'../../'.$feature);
    $userid = $_SESSION['current_user_id'];
        $has = !empty($_POST[['postid']]);
    if($has){
        $id = $_POST['postid'];
        if(!empty($_FILES['feature'] && $_FILES['feature']['error'] == 0)){
            $sql = "update posts set slug='$slug',title='$title',created='$created',content='$content',
                                    status='$status',category_id='$cateid',feature='$feature' where id='$id'";
        }else{
            $sql = "update posts set slug='$slug',title='$title',created='$created',content='$content',
            status='$status',category_id='$cateid' where id='$id'";
        }
    }else{
    if(!empty($_FILES['feature']) && $_FILES['feature']['error'] == 0){
        $sql = "insert into posts (slug,title,created,content,status,user_id,category_id,feature) 
                            values('$slug','$title','$created','$content','$status','$userid',$cateid,'$feature')";
    }else{
        $sql = "insert into posts (slug,title,created,content,status,user_id,category_id) 
        values('$slug','$title','$created','$content','$status','$userid','$cateid')";
    }
    }

    my_exec($sql);
   

    header('location: ../posts.php');
?>