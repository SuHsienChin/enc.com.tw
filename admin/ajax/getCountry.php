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

include_once('../class/ClassCountry.php');
$obj = new ClassCountry();
switch ($_GET['mode']) {
    case "readjson":
        $result = $obj->select();
        echo json_encode($result);
        break;
    case "readById":
        $obj->id=$_GET['id'];
        $result = $obj->DoSql();
        echo json_encode($result);
        break;
    case "readhtml":
        $result = $obj->select();
        $count = count($result);
        for ($i = 0; $i < $count; $i++) {
            echo "<tr>\n";
            echo "<td><input type=\"checkbox\" name=\"checkList\" value=\"" . $result[$i]['id'] . "\"></td>\n";
            echo "<td>" . $result[$i]['name'] . "</td>\n";
            echo "<td>" . $result[$i]['code'] . "</td>\n";
            //echo "<td><a href=\"countryEdit.php?id=" . $result[$i]['id'] . "\" class=\"btn btn-info btn-circle\" data-toggle=\"modal\" data-target=\"#editmyModal\"><i class=\"glyphicon glyphicon-edit\"></i></a></td>\n";
            echo "<td><a href=\"#\" class=\"btn btn-info btn-circle editbtn\" data-toggle=\"modal\" data-target=\"#editmyModal\" rel=\"" . $result[$i]['id'] . "\"><i class=\"glyphicon glyphicon-edit\"></i></a></td>\n";
            echo "<td><a href=\"#\" class=\"btn btn-danger btn-circle delbtn\" rel=\"" . $result[$i]['id'] . "\"><i class=\"glyphicon glyphicon-remove\"></a></td>\n";
            echo "</tr>\n";
        }
        break;
    case "del":
        $obj->id = $_GET['id'];


        if ($obj->Del()) {
            return json_encode('success');
        } else {
            return json_encode('false');
        }

        break;
    case "check":
        $obj->code = $_GET['code'];
        if ($obj->Retrieve()) {

            echo json_encode("0");
        } else {
            echo json_encode("1");
        }
        break;

}

