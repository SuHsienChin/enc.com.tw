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
$getDate = date("Y-m-d");
//----最新資料
$sql="SELECT * FROM news WHERE endDate >= '$getDate' ORDER BY startDate DESC LIMIT 5";

$st=$db->prepare($sql);
$st->execute();
$result=$st->fetchAll(PDO::FETCH_ASSOC);

//----問答
$qasql="SELECT * FROM qanda  WHERE flag='1' ORDER BY RAND() LIMIT 1";
$qast=$db->prepare($qasql);
$qast->execute();
$qa = $qast->fetch(PDO::FETCH_ASSOC);

//--大圖
$picsql="SELECT * FROM files WHERE flag='1' ORDER BY sort ASC ";
$picst=$db->prepare($picsql);
$picst->execute();
$pic=$picst->fetchAll(PDO::FETCH_ASSOC);

include_once('templates/header.php');

?>



<!--右頁面-->
<div class="righr_page">
    <!--輪播-->
    <div class="photo">
    <div id="abgneBlock">
            <ul class="list">
                <?php
                    foreach($pic as $item) {
                        ?>
                        <li><a target="_blank" href="<?php echo $item['url'];?>"><img src="admin/server/php/files/<?php echo $item['name'];?>"></a></li>
                    <?php
                    }
                        ?>
		</ul>
	</div>
    </div>
    
    <!--最新消息-->
    <div class="news_box">
    <h3 class="title_01">最新消息<span>Latest News</span></h3>
        <div class="news_list">
            <ul>
                <?php
                foreach ($result as $record) {
                    ?>
                    <li>
                        <a href="news.php?page=1&id=<?php echo $record['id'];?>" class="showNews">
                            <span><?php echo $record['startDate']; ?></span>
                            <?php echo $record['title']; ?>
                        </a>
                    </li>
                <?php
                }
                ?>
            </ul>
        </div>

    <p class="F-R"><a href="news.php" class="btn_more">more</a></p>
    </div>
    
    <!--常見問答-->
    <div class="faq_box">
    <h3 class="title_01">常見問答<span>FAQ</span></h3>
    <div class="qa_list">
    <p class="q"><?php echo $qa['name']?></p>
    <p class="a"><?php echo $qa['content'];?></p>
    <p class="F-R"><a href="fqa.php" class="btn_more">more</a></p>
    </div>
    </div>
    
    
</div>

<?php include_once('templates/footer.php');?>