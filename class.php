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

ini_set('display_errors','1');
ini_set('display_startup_errors','1');
error_reporting(E_ALL);

//----
$sql="SELECT * FROM articles WHERE branchCode=\"".$_GET['code']."\" GROUP BY countryCode ORDER BY sort ASC";
$st=$db->prepare($sql);
$st->execute();
$result=$st->fetchAll(PDO::FETCH_ASSOC);

include_once('templates/header.php');

?>
<!--右頁面-->
<div class="righr_page">
<div class="title_02">
    <h2><span>
        <?php
            switch($_GET['code']){
                case "E":
                    echo "移民館";
                    break;
                case "L":
                    echo "留學館";
                    break;
                case "G":
                    echo "中學館";
                    break;
                case "W":
                    echo "語言館";
                    break;
            }
        ?>
    </span></h2>
<!--第二層-->

</div>
<div class="page_body">
<ul class="Flag_list">
        <?php
            foreach($result as $item){
        ?>
            <li><a href="class_list.php?bcode=<?php echo $item['branchCode']; ?>&ccode=<?php echo $item['countryCode']; ?>"><p><?php echo $item['countryName']; ?></p> <img src="admin/<?php echo $item['PicUrl']; ?>" ></a></li>
        <?php
            }
        ?>


</ul>

</div>

    
   </div>
<?php include_once('templates/footer.php');?>