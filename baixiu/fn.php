<?php
    

     function my_exea($sql){
        
        
        $link = mysqli_connect(HOST,UNAME,PWD,DB);
        if(!$link){
          echo '数据库连接失败！';
          return false;
        }
    
        if(!mysqli_query($link,$sql)){
          echo '操作失败！';
          mysqli_close($link);
          return  false;
        }
    
        mysqli_close($link);
        return false;
    
    
      }
    
      function my_query($sql){
    
        $link = mysqli_connect(HOST,UNAME,PWD,DB);
        if(!$link){
          echo '数据库连接失败！';
          return false;
        }
    
        $res = mysqli_query($link,$sql);
    
        if(!isset($res) || mysqli_num_rows($res) == 0){
          echo '无搜索结果！';
          mysqli_close($link);
          return false;
        }
    
        while($row = mysqli_fetch_assoc($res)){
          $arr[]=$row;
        }
    
        mysqli_close($link);
        return $arr;
      }
    

    function checkLogin(){
        session_start();
        if(!isset($_SESSION['id'])){
          header('location: ./login.php');
          die();
        }
    }

?>