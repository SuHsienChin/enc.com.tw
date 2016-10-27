<?php

session_start();
header("Content-Type:text/html; charset=utf-8");

// 藉由含括子系統的設定檔，取得網站及子系統的各種設定
include_once('../../inc/webConfig.php');
// 引入資料庫
include_once(INCLUDE_DIR . 'db.php');

try {
    $db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_DATABASE, DB_USER, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    /*** echo a message saying we have connected ***/
} catch (PDOException $e) {
    echo $e->getMessage();
}

switch ($_GET['mode']) {



    case "read":

        $sql = "SELECT * FROM articles WHERE branchCode=\"".$_GET['bra']."\" GROUP BY countryCode";
        $st = $db->prepare($sql);
        $st->execute();
        $rs = $st->fetchAll(PDO::FETCH_ASSOC);
        $count = count($rs);
        foreach ($rs as $item) {
            echo "<tr>";
            echo "<td>".$item['countryName']."</td>";
            echo "<td>".$item['countryCode']."</td>";
            echo "<td>";
            echo "<select class=\"degree_accept_id\">";
            for($a=0;$a<=$count;$a++){
                if($item['sort']==$a){
                    echo "<option value=\"".$a."\" selected>".$a."</option>";
                }else{
                    echo "<option value=\"".$a."\">".$a."</option>";
                }

            }
            echo "</select>";

            /*echo "$rs['sort']."</td>";*/
            echo "</tr>";
        }



        break;

    case "edit":

        $sql = "UPDATE articles SET sort =\"".$_GET['sort']."\" WHERE branchCode=\"".$_GET['bra']."\" AND countryCode=\"".$_GET['code']."\"";
        $st = $db->prepare($sql);
        try{
            $st->execute();
        }catch (PDOException $e){

        }


        break;
}