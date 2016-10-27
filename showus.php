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
$sql="SELECT * FROM aboutus WHERE id =" . $_GET['id'];
$st=$db->prepare($sql);
$st->execute();
$result=$st->fetch(PDO::FETCH_ASSOC);

include_once('templates/header.php');

?>
<!--右頁面-->
<div class="righr_page">
    <div class="title_02">
        <h2><span>關於我們</span></h2>
    </div>
    <div style="float: right;">
        <!--FB推播-->
        <div id="fb-root"></div>
        <script>(function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) return;
                js = d.createElement(s); js.id = id;
                js.src = "//connect.facebook.net/zh_TW/sdk.js#xfbml=1&version=v2.0";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));</script>

        <div class="fb-share-button" data-type="button_count"></div>
    </div>
    <div class="page_body">
        <h3 class="title_03"><?php echo $result['title'];?></h3>
        <div class="page">
            <?php echo $result['content'];?>
        </div>

    </div>
    <?php include_once('templates/homeback.php');?>
</div>
<?php include_once('templates/footer.php');?>