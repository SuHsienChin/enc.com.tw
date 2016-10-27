<?php
/**
 * Created by PhpStorm.
 * User: MayumiKing
 * Date: 2016/2/24
 * Time: 下午 08:50
 */

header("Content-Type:text/html; charset=utf-8");

// 藉由含括子系統的設定檔，取得網站及子系統的各種設定
include_once('../inc/webConfig.php');
// 引入資料庫
include_once(INCLUDE_DIR.'db.php');

include_once('../class/class_news.php');
$obj = new class_news();

try {
    $db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_DATABASE, DB_USER, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

} catch (PDOException $e) {
    echo $e->getMessage();
}

switch ($_GET['mode']){
    case "readid":
        try {
            $sql = "SELECT id FROM news ORDER BY startDate DESC";
            $st = $db->prepare($sql);
            $st->execute();
            $result = $st->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($result);
        } catch (PDOException $e) {

        }
        break;

    case "readById":
        try {
            $sql = "SELECT * FROM news WHERE id ='$_GET[id]'";
            $st = $db->prepare($sql);
            $st->execute();
            $result = $st->fetch(PDO::FETCH_ASSOC);
            echo json_encode($result);
        } catch (PDOException $e) {

        }
        break;


}



