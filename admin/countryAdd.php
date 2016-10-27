<?php
session_start();
header("Content-Type:text/html; charset=utf-8");
// 藉由含括子系統的設定檔，取得網站及子系統的各種設定
include_once('appConfig.php');
// 引入資料庫
include_once(INCLUDE_DIR . 'db.php');

include_once('class/ClassCountry.php');
//取得日期
$getDate = date("Y-m-d");


if (isset($_POST['savebtn'])) {


    @$filename = $_FILES["file"]["name"];
    @$tmpfile = $_FILES["file"]["tmp_name"];
    @$size = $_FILES["file"]["size"];
    @$type = $_FILES["file"]["type"];
    @$newfilename = md5(uniqid(rand()));
    @$temp = explode(".", $_FILES["file"]["name"]);
    @$extension = end($temp);
    @$newName = $newfilename . "." . $extension;
    if (move_uploaded_file($_FILES['file']['tmp_name'], "upload/" . $_FILES["file"]["name"])) {
        rename("upload/" . $_FILES["file"]["name"], "upload/" . $newName);
        // "上傳成功"
        //產生物件
        $obj = new ClassCountry();
        // 呼叫 setProperties() 方法，將物件各屬性，設定為表單各相對欄位的資料
        $obj->name = $_POST['countryname'];
        $obj->code = $_POST['countrycode'];
        $obj->PicUrl = "upload/" . $newName;
        $obj->filename = $newName;
        $obj->size = $size;
        $obj->type = $type;
        $obj->path = $filename;
        $obj->ADD();
        echo "<script>alert('新增成功');</script>";
        echo "<script>document.location.href=\"article.php\";</script>";
        exit;

    } else {
        echo "上傳失敗";
    }
}
?>
