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

//----關於我們
$sql="SELECT * FROM links ";
$st=$db->prepare($sql);
$st->execute();
$result=$st->fetchAll(PDO::FETCH_ASSOC);

include_once('templates/header.php');

?>

<!--右頁面-->
<div class="righr_page">
<div class="title_02">
<h2><span>好站連結</span></h2>
</div>

<div class="page_body">
    <?php
        if(count($result) == 0){
            echo "<img src=\"images/noresult.jpg\">";
        }
    ?>
<ul class="link_list">

    <?php
        foreach ($result as $item) {
            ?>
            <li><a href="<?php echo $item['url']; ?>" target="_blank"><p class="link_img">
                        <?php
                        if ($item['pic'] == "") {
                            echo "<img src=\"images/img_nologo.png\">";
                        } else {
                            echo "<img src=\"admin/upload/link/" . $item['pic'] . "\"> </p>";
                        }
                        ?>

                    <p><?php echo $item['name'];?></p>
                </a></li>
        <?php
        }
    ?>
</ul>

<div class="page-no">
            <div class="no_box">

          </div>
</div>
    <?php include_once('templates/homeback.php');?>
    
   </div>
    </div>
<?php include_once('templates/footer.php');?>