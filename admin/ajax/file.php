<?php
/**
 * Created by PhpStorm.
 * User: MayumiKing
 * Date: 2016/2/24
 * Time: 下午 08:50
 */

header("Content-Type:text/html; charset=utf-8");

// 藉由含括子系統的設定檔，取得網站及子系統的各種設定
include_once('../../inc/webConfig.php');
// 引入資料庫
include_once(INCLUDE_DIR . 'db.php');

include_once('../class/Classdlf.php');
$obj = new Classdlf();

switch ($_POST['mode']) {

    case "read":
        $obj->cId = $_POST['cId'];
        $result = $obj->selectClass();
        //print_r($result);
        $count = count($result);
        for ($i = 0; $i < $count; $i++) {
            echo "<tr>\n";
            //echo "<td><input type=\"checkbox\" name=\"checkList\" value=\"" . $result[$i]['id'] . "\"></td>\n";
            echo "<td>".$result[$i]['id']."</td>\n";
            echo "<td>" . $result[$i]['title'] . "</td>\n";
            echo "<td align=\"center\"><a href=\"dlfEdit.php?id=" . $result[$i]['id'] . "\" class=\"btn btn-info btn-circle\"><i class=\"glyphicon glyphicon-edit\"></i></a></td>\n";
            echo "<td align=\"center\"><a href=\"#\" class=\"btn btn-danger btn-circle delbtn\" rel=\"" . $result[$i]['id'] . "\" alt=\"" . $result[$i]['filename'] . "\"><i class=\"glyphicon glyphicon-remove\"></a></td>\n";
            echo "</tr>\n";
        }

        break;
    case "del":
        $obj->id = $_POST['id'];
        $fn = $_POST['filename'];
        $path = "../upload/" . $fn;
        if (file_exists($path)) {
            unlink($path);
        }


        if ($obj->Del()) {
            return json_encode('success');
        } else {
            return json_encode('false');
        }


        break;


}



