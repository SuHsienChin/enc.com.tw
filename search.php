<?php
header("Content-Type:text/html; charset=utf-8");
// 藉由含括子系統的設定檔，取得網站及子系統的各種設定
include_once('appConfig.php');

//資料庫連線
try {
    $db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_DATABASE, DB_USER, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
} catch (PDOException $e) {
    echo $e->getMessage();
}
$keywords = $_GET['keywords'];
$sql = "SELECT * FROM articles WHERE articles.content like '%".$keywords."%' OR articles.title like '%".$keywords."%'";
$st = $db->prepare($sql);
$st->execute();
$result = $st->fetchAll(PDO::FETCH_ASSOC);

include_once('templates/header.php');

?>
<!--右頁面-->
<div class="righr_page">
    <div class="title_02">
        <h2><span>搜尋結果</span></h2>
    </div>

    <!-- 內容 start -->
    <div class="page_body">
        <ul>
            <?php
            foreach ($result as $item) {
                echo "<li><a href=\"class_page.php?id=".$item['id']."\">".$item['title']."</a></li>";
            }
            ?>
        </ul>

    </div>
    <!-- 內容 end -->
    <?php include_once('templates/homeback.php'); ?>

</div>
<?php include_once('templates/footer.php'); ?>
