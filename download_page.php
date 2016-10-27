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

//----faq
$sql="SELECT * FROM dlfiles WHERE cId =" . $_GET['id'];

$st=$db->prepare($sql);
$st->execute();
$result=$st->fetchAll(PDO::FETCH_ASSOC);

$csql="SELECT * FROM dlclass WHERE id =". $_GET['id'];
$a=$db->prepare($csql);
$a->execute();
$rs=$a->fetch(PDO::FETCH_ASSOC);

include_once('templates/header.php');

?>
<!--右頁面-->
<div class="righr_page">
<div class="title_02">
<h2><span>檔案下載</span></h2>
</div>

<div class="page_body">
<h3 class="title_03"><?php echo $rs['title'];?></h3>
<ul class="download_list">
    <?php
        foreach($result as $item){
    ?>
            <li><a href="admin/upload/<?php echo $item['filename'];?>"><?php echo $item['name'];?></a></li>
    <?php
        }
    ?>
</ul>

</div>
<div class="page-no">

</div>
    <?php include_once('templates/homeback.php');?>
    
   </div>
<?php include_once('templates/footer.php');?>