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

include_once('../class/ClassSlider.php');
$obj = new ClassSlider();
switch ($_GET['mode']) {

    case "readhtml":
        $result = $obj->select();
        $count = count($result);
        foreach ($result as $record) {
            echo "<tr id=\"".$record['id']."\">\n";
            //
            echo "<td align=\"center\"><img src=\"server/php/files/" . $record['name'] . "\" width=\"142\" height=\"70\"></td>\n";
            echo "<td>";
            if ($record['url'] == "") {
                echo "(目前暫無連結)";
            } else {
                echo "<a href=\"" . $record['url'] . "\" target=\"_blank\">" . $record['url'] . "</a>";
            }

            echo "</td>\n";
            echo "<td align=\"center\" class=\"sort\" field=\"ssisort\">" . $record['sort'] . "</td>\n";

            echo "<td align=\"center\" class=\"status\" field=\"ssistatus\">";
            if ($record['flag'] == 1) {
                echo "<i class=\"fa fa-check\"></i>";
            } else {
                echo "<i class=\"fa fa-times\"></i>";
            }
            echo "</td>\n";
            echo "<td align=\"center\"><a href=\"sliderEdit.php?id=" . $record['id'] . "\" class=\"btn btn-info btn-circle\"><i class=\"glyphicon glyphicon-edit\"></i></a></td>\n";
            echo "</tr>\n";
        }
break;

}

