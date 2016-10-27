<?php
$uid =  $_SESSION['userId'];
// 藉由含括子系統的設定檔，取得網站及子系統的各種設定
include_once('appConfig.php');
//引入計數器
include_once('usercount.php');
//資料庫連線
try {
    $db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_DATABASE, DB_USER, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
} catch (PDOException $e) {
    echo $e->getMessage();
}

//查出父節點
$s1 = "SELECT * FROM adminsidebar,users_sidebar WHERE adminsidebar.id=users_sidebar.sidebarId AND users_sidebar.userId = '$uid' AND adminsidebar.parentId = '0' ";
$s1 = $db->prepare($s1);
$s1->execute();
$rs1 = $s1->fetchAll(PDO::FETCH_ASSOC);

echo "<ul id=\"side-menu\" class=\"nav\">\n";
foreach ($rs1 as $item) {

    $s2 = "SELECT * FROM adminsidebar WHERE parentId ='" . $item['sidebarId'] . "'";
    $s2 = $db->prepare($s2);
    $s2->execute();
    $rs2 = $s2->fetchAll(PDO::FETCH_ASSOC);
    if (count($rs2) > 0) {//代表有資料
        echo "<li>\n";
        echo "<a href=\"#\"><i class=\"fa fa-sitemap fa-fw\"></i>" . $item['name'] . "<span class=\"fa arrow\"></span></a>\n";
        echo "<ul class=\"nav nav-second-level\">\n";
        foreach ($rs2 as $item2) {
            echo "<li><a href=\"" . $item2['url'] . "\">" . $item2['name'] . "</a></li>\n";
        }
        echo "</ul>\n";
        echo "</li>\n";
    } else {
        echo "<li><a href=\"" . $item['url'] . "\"><i class=\"fa fa-dashboard fa-fw\"></i>" . $item['name'] . "</a></li>\n";
    }
}
echo "<li><i class=\"fa fa-dashboard fa-fw\"></i>瀏覽人數：" . $c . "</li>\n";
echo "</ul>\n";