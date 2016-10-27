<?php
header("Content-Type:text/html; charset=utf-8");
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

//----faq
$sql="SELECT * FROM dlclass";
$st=$db->prepare($sql);
$st->execute();
$result=$st->fetchAll(PDO::FETCH_ASSOC);

include_once('templates/header.php');

?>
<!--右頁面-->
<div class="righr_page">
<div class="title_02">
<h2><span>檔案下載</span></h2>
</div>

<div class="page_body">
<ul class="about_list">
        <?php
            foreach($result as $item){
        ?>
            <li><a href="download_page.php?id=<?php echo $item['id'];?>"><?php echo $item['title'];?></a></li>
        <?php
            }
        ?>
</ul>
    </div>
    <?php include_once('templates/homeback.php');?>
    
   </div>
<?php include_once('templates/footer.php');?>