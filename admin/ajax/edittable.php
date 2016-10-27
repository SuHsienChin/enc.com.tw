<?php
/**
 * Created by PhpStorm.
 * User: MayumiKing
 * Date: 2016/3/2
 * Time: 下午 05:12
 */
session_start();
header("Content-Type:text/html; charset=utf-8");

// 藉由含括子系統的設定檔，取得網站及子系統的各種設定
include_once('../../inc/webConfig.php');
// 引入資料庫
include_once(INCLUDE_DIR . 'db.php');

try {
    $db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_DATABASE, DB_USER, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

} catch (PDOException $e) {
    echo $e->getMessage();
}
switch ($_POST['field']) {
    case 'aboutsort': //更新關於我們的排序

        try {
            $sql = "UPDATE aboutus SET sort ='" . $_POST['value'] . "' WHERE id='" . $_POST['id'] . "'";
            $st = $db->prepare($sql);
            $st->execute();

            echo $_POST['value'];
        } catch (PDOException $e) {

        }


        break;

    case 'aboutstatus'://更新關於我們
        try {
            $sql = "UPDATE aboutus SET flag ='" . $_POST['value'] . "' WHERE id='" . $_POST['id'] . "'";
            $st = $db->prepare($sql);
            $st->execute();
            if ($_POST['value'] == 1) {
                echo "<i id=\"iflag\" class=\"fa fa-check\"></i>";
            } else {
                echo "<i id=\"iflag\" class=\"fa fa-times\"></i>";
            }

        } catch (PDOException $e) {

        }
        break;

    case 'qcsort'://更新Q&A類別
        try {
            $sql = "UPDATE qandaclass SET sort ='" . $_POST['value'] . "' WHERE id='" . $_POST['id'] . "'";
            $st = $db->prepare($sql);
            $st->execute();

            echo $_POST['value'];
        } catch (PDOException $e) {

        }
        break;

    case 'qcstatus'://更新Q&A類別
        try {
            $sql = "UPDATE qandaclass SET flag ='" . $_POST['value'] . "' WHERE id='" . $_POST['id'] . "'";
            $st = $db->prepare($sql);
            $st->execute();
            if ($_POST['value'] == 1) {
                echo "<i id=\"iflag\" class=\"fa fa-check\"></i>";
            } else {
                echo "<i id=\"iflag\" class=\"fa fa-times\"></i>";
            }

        } catch (PDOException $e) {

        }
        break;

    case 'qasort'://更新Q&A
        try {
            $sql = "UPDATE qanda SET sort ='" . $_POST['value'] . "' WHERE id='" . $_POST['id'] . "'";
            $st = $db->prepare($sql);
            $st->execute();

            echo $_POST['value'];
        } catch (PDOException $e) {

        }
        break;

    case 'qastatus'://更新Q&A
        try {
            $sql = "UPDATE qanda SET flag ='" . $_POST['value'] . "' WHERE id='" . $_POST['id'] . "'";
            $st = $db->prepare($sql);
            $st->execute();
            if ($_POST['value'] == 1) {
                echo "<i id=\"iflag\" class=\"fa fa-check\"></i>";
            } else {
                echo "<i id=\"iflag\" class=\"fa fa-times\"></i>";
            }

        } catch (PDOException $e) {

        }
        break;

    case 'ssisort'://更新大圖
        //oldvalue 舊值
        //id 舊值id
        //value 新值
        try {
            //$sql = "UPDATE files SET sort ='" . $_POST['value'] . "' WHERE id='" . $_POST['id'] . "'";
            $sql = "UPDATE files SET sort ='99999999' WHERE id='" . $_POST['id'] . "'";
            $st = $db->prepare($sql);
            $st->execute();
            $sql = "UPDATE files SET sort ='" . $_POST['oldvalue'] . "' WHERE sort='" . $_POST['value'] . "'";
            $st = $db->prepare($sql);
            $st->execute();
            $sql = "UPDATE files SET sort ='" . $_POST['value'] . "' WHERE sort='99999999'";
            $st = $db->prepare($sql);
            $st->execute();

            echo $_POST['value'];
        } catch (PDOException $e) {

        }
        break;

    case 'ssistatus':
        try {
            $sql = "UPDATE files SET flag ='" . $_POST['value'] . "' WHERE id='" . $_POST['id'] . "'";
            $st = $db->prepare($sql);
            $st->execute();
            if ($_POST['value'] == 1) {
                echo "<i id=\"iflag\" class=\"fa fa-check\"></i>";
            } else {
                echo "<i id=\"iflag\" class=\"fa fa-times\"></i>";
            }

        } catch (PDOException $e) {

        }

    case 'sidstatus'://更新大圖
        try {
            $sql = "UPDATE sidead SET flag ='" . $_POST['value'] . "' WHERE id='" . $_POST['id'] . "'";
            $st = $db->prepare($sql);
            $st->execute();
            if ($_POST['value'] == 1) {
                echo "<i id=\"iflag\" class=\"fa fa-check\"></i>";
            } else {
                echo "<i id=\"iflag\" class=\"fa fa-times\"></i>";
            }

        } catch (PDOException $e) {

        }
        break;

}