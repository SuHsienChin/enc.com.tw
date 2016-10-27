<?php
session_start();
header("Content-Type:text/html; charset=utf-8");
// 藉由含括子系統的設定檔，取得網站及子系統的各種設定
include_once('appConfig.php');
// 引入資料庫
include_once('../inc/db.php');
// Users類別
include_once('class/ClassUsers.php');

$uid = $_REQUEST['uid'];

$dbClass = new Database();
$dbh = $dbClass->getDb();
$users = new users($dbh);


if ($users->del($uid)) {

    //刪除 關聯表 users_sidebar WHERE users.id
    try {
        $db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_DATABASE, DB_USER, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        /*** echo a message saying we have connected ***/
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    $de_sql = "DELETE FROM users_sidebar WHERE userId='" . $_GET['uid'] . "'";
    $de = $db->prepare($de_sql);
    $de->execute();

    echo "<script>alert('刪除成功');</script>";
    echo "<script>document.location.href=\"account.php\";</script>";
    exit;
} else {
    echo "<script>alert('刪除失敗');</script>";
    echo "<script>document.location.href=\"account.php\";</script>";
    exit;
}

?>

