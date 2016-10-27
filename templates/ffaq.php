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

//----問答
$sql="SELECT * FROM qanda ORDER BY RAND() LIMIT 5";
$qq=$db->prepare($sql);
$qq->execute();
$result=$qq->fetchAll(PDO::FETCH_ASSOC);
?>
<h6>常見問答</h6>
<ul>
    <?php
    foreach ($result as $item) {
        ?>
        <li><a href="fqa_page.php?id=<?php echo $item['id'];?>"><?php echo $item['name'];?></a></li>
    <?php
    }
    ?>
</ul>
