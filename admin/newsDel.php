<?php
session_start();
header("Content-Type:text/html; charset=utf-8");
// 藉由含括子系統的設定檔，取得網站及子系統的各種設定
include_once('appConfig.php');
// 引入資料庫
include_once(INCLUDE_DIR . 'db.php');

include_once('class/ClassNews.php');
//取得日期
$getDate = date("Y-m-d");

if (isset($_GET)) {
    //產生物件
    $obj = new ClassNews();
    // 呼叫 setProperties() 方法，將物件各屬性，設定為表單各相對欄位的資料
    $obj->id = $_GET['id'];
    //$obj->setProperties();
    //執行刪除一則最新消息
    if ($obj->Del()) {
        echo "<script>alert('刪除成功');</script>";
        echo "<script>document.location.href=\"setnews.php\";</script>";
        exit;
    } else {
        echo "<script>alert('刪除失敗');</script>";
        echo "<script>document.location.href=\"setnews.php\";</script>";
    }


}
?>

