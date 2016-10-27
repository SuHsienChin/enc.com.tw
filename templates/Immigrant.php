<?php
// 藉由含括子系統的設定檔，取得網站及子系統的各種設定
include_once('appConfig.php');
//資料庫連線
try {
    $db = new PDO("mysql:host=".DB_HOST.";dbname=".DB_DATABASE, DB_USER, DB_PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
}
catch(PDOException $e)
{
    echo $e->getMessage();
}
//----
$sql="SELECT * FROM articles WHERE branchCode='E' GROUP BY countryCode";
$st=$db->prepare($sql);
$st->execute();
$result=$st->fetchAll(PDO::FETCH_ASSOC);


?>
<h6>移民館</h6>
<ul>
    <?php
    foreach ($result as $item) {
    ?>
    <li><a href="class_list.php?bcode=<?php echo $item['branchCode'];?>&ccode=<?php echo $item['countryCode'];?>"><?php echo $item['countryName'];?></a></li>
    <?php
    }
    ?>
</ul>

