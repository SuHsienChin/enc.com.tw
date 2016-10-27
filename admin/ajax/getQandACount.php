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

include_once('../class/ClassQandA.php');
$obj = new ClassQandA();
if (isset($_GET)) {
    $obj->classId = $_GET['classId'];
    $result = $obj->countRecrodsById();
    $count = (int)$result['count'];
    echo json_encode($count);
}

