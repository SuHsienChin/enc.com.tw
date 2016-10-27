<?php
/**
 * Created by PhpStorm.
 * User: MayumiKing
 * Date: 2016/2/23
 * Time: 下午 03:40
 */
session_start();
header("Content-Type:text/html; charset=utf-8");

// 藉由含括子系統的設定檔，取得網站及子系統的各種設定
include_once('../../inc/webConfig.php');
// 引入資料庫
include_once(INCLUDE_DIR . 'db.php');

include_once('../class/ClassUser.php');
$obj = new ClassUser();
switch ($_GET['mode']) {

    case "check":

        try {
            $db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_DATABASE, DB_USER, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            /*** echo a message saying we have connected ***/
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        $sql = "SELECT account FROM users WHERE account ='" . $_GET['account'] . "'";
        $st = $db->prepare($sql);
        $st->execute();
        $rs = $st->fetch(PDO::FETCH_ASSOC);

        if ($rs) {

            echo json_encode("0");
        } else {
            echo json_encode("1");
        }
        break;

}

