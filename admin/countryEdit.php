<?php
session_start();
header("Content-Type:text/html; charset=utf-8");
// 藉由含括子系統的設定檔，取得網站及子系統的各種設定
include_once('appConfig.php');
// 引入資料庫
include_once(INCLUDE_DIR . 'db.php');

//資料庫連線
try {
    $db = new PDO("mysql:host=".DB_HOST.";dbname=".DB_DATABASE, DB_USER, DB_PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
}
catch(PDOException $e)
{
    echo $e->getMessage();
}

if (isset($_POST['editbtn'])) {

//檔案
    @$filename = $_FILES["file2"]["name"];
    @$tmpfile = $_FILES["file2"]["tmp_name"];
    @$size = $_FILES["file2"]["size"];
    @$type = $_FILES["file2"]["type"];
    @$newfilename = md5(uniqid(rand()));
    @$temp = explode(".", $_FILES["file2"]["name"]);
    @$extension = end($temp);
    @$newName = $newfilename . "." . $extension;
    if (move_uploaded_file($_FILES['file2']['tmp_name'], "upload/" . $_FILES["file2"]["name"])) {
        rename("upload/" . $_FILES["file2"]["name"], "upload/" . $newName);

        $fname = "upload/" . $_POST['pichidden'];
        //刪除檔案
        if (file_exists($fname)) {
            unlink($fname);//將檔案刪除
        }
        // "上傳成功"

        $name = $_POST['editcame'];
        $code = $_POST['editccode'];
        $filename = $newName;
        $PicUrl = "upload/".$newName;
        $id = $_POST['idhidden'];
        $size = $size;
        $type = $type;

        $sql = "UPDATE country SET name='$name',code='$code',picUrl='$PicUrl',filename='$filename',size='$size',type='$type' WHERE id='$id'";
        $st = $db->prepare($sql);
        try{
            $st->execute();
            $arsql = "UPDATE articles SET PicUrl ='$PicUrl' WHERE countryCode ='$code'";
            
            $st1 = $db->prepare($arsql);
            try{
                $st1->execute();
            }catch (PDOException $e){

            }
            echo "<script>alert('更新成功');</script>";
            echo "<script>document.location.href=\"article.php\";</script>";
            exit;
        }catch (PDOException $e){
            echo $e->getMessage();
        }





    } else {
        $name = $_POST['editcame'];
        $code = $_POST['editccode'];
        $id = $_POST['idhidden'];

        $sql = "UPDATE country SET name='$name',code='$code' WHERE id='$id'";
        $st = $db->prepare($sql);
        try{
            $st->execute();
            //echo $sql;
            echo "<script>alert('更新成功');</script>";
            echo "<script>document.location.href=\"article.php\";</script>";
            exit;
        }catch (PDOException $e){
            echo $e->getMessage();
        }
    }
}