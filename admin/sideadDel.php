<?php
session_start();
header("Content-Type:text/html; charset=utf-8");
// 藉由含括子系統的設定檔，取得網站及子系統的各種設定
include_once('appConfig.php');
// 引入資料庫
include_once(INCLUDE_DIR . 'db.php');

include_once('class/ClassSideAd.php');
//取得日期
$getDate = date("Y-m-d");

if (isset($_GET)) {
    //產生物件
    $obj = new ClassSideAd();
    $obj->id = $_GET['id'];

    //刪除檔案
    $fname = "upload/sidead/" . $_GET['file'];
    if (file_exists($fname)) {
        @unlink($fname);//將檔案刪除
    }
    //執行刪除
    if ($obj->Del()) {
        echo "<script>alert('刪除成功');</script>";
        echo "<script>document.location.href=\"sidead.php\";</script>";
        exit;
    } else {
        echo "<script>alert('刪除失敗');</script>";
        echo "<script>document.location.href=\"sidead.php\";</script>";
    }


}
?>

