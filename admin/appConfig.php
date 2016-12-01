<?php

//沒有登入則踢到登入頁面
if(@$_SESSION['userId'] == null){
    echo "<script>alert('請先登入');</script>";
    echo "<script>document.location.href=\"login.php\";</script>";
    exit();
}
//判斷權限有沒有這頁，沒有的話踢到主頁

@$page =  $_SERVER['PHP_SELF'];
@$arr = $_SESSION['pages'];


if(is_array($arr) && !empty($arr)){
    $flag = 0;
    foreach ($arr as $p) {
        if(strpos($page,$p)){
            $flag = 1;
        }
    }
}


if($flag==0){
    echo "<script>alert('無限權登入此頁面');</script>";
    echo "<script>document.location.href=\"main.php\";</script>";
}

// 含括網站設定檔 web_config.php
include_once('../inc/webConfig.php');
//開啟server error message
ini_set("display_errors", "On");
