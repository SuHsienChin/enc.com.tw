<?php
header("Content-Type:text/html; charset=utf-8");
// 藉由含括子系統的設定檔，取得網站及子系統的各種設定
include_once('appConfig.php');
// 引入資料庫
include_once(INCLUDE_DIR . 'db.php');

//資料庫連線
try {
    $db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_DATABASE, DB_USER, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
} catch (PDOException $e) {
    echo $e->getMessage();
}

$id;


//-----------分頁start --------------


//預設每頁筆數(依需求修改)
$pageRow_records = 5;
//預設頁數
$num_pages = 1;
//若已經有翻頁，將頁數更新
if (isset($_GET['page'])) {
    $num_pages = intval($_GET['page']);
}
//本頁開始記錄筆數 = (頁數-1)*每頁記錄筆數
$startRow_records = ($num_pages - 1) * $pageRow_records;
//未加限制顯示筆數的SQL敘述句
$sql_query = "SELECT * FROM news  WHERE endDate >= date(now()) ORDER BY startDate DESC ";
$count_query = "SELECT count(*) as count FROM news ";
//加上限制顯示筆數的SQL敘述句，由本頁開始記錄筆數開始，每頁顯示預設筆數
$sql_query_limit = $sql_query . " LIMIT " . $startRow_records . ", " . $pageRow_records;
$count_query = $count_query . " LIMIT " . $startRow_records . ", " . $pageRow_records;
//以加上限制顯示筆數的SQL敘述句查詢資料到 $result 中
$stmt = $db->prepare($sql_query_limit);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
//print_r($result);

$stmt = $db->prepare($count_query);
$stmt->execute();
$re = $stmt->fetch(PDO::FETCH_ASSOC);
$total_records = $re['count'];
$total_pages = ceil($total_records / $pageRow_records);
$st = $db->prepare($sql_query_limit);
$st->execute();
$rr = $st->fetch(PDO::FETCH_ASSOC);

$id = $rr['id'];
//-----------分頁end ------------------

//判斷有無id
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = " SELECT * FROM news WHERE id='" . $id . "'";
    $qq = $db->prepare($sql);
    $qq->execute();
    $rr = $qq->fetch(PDO::FETCH_ASSOC);


} else {

}

/*//上一則id
$sql = "SELECT id FROM news WHERE id < '$id' ORDER BY id DESC limit 0,1 ";
$preq = $db->prepare($sql);
$preq->execute();
$prer = $preq->fetch(PDO::FETCH_ASSOC);
//下一則id
$sql = "SELECT id FROM news WHERE id > '$id' ORDER BY id ASC limit 0,1 ";
$nextq = $db->prepare($sql);
$nextq->execute();
$nextr = $nextq->fetch(PDO::FETCH_ASSOC);*/
//載入head
include_once('templates/header.php');



?>
<!--右頁面-->
<div class="righr_page">
    <div class="title_02">
        <h2><span>最新消息</span></h2>
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
        <h3 class="title_03"><span id="ardate"><?php echo $rr['startDate']; ?>-</span><span
                id="artitle"><?php echo $rr['title']; ?></span></h3>

        <div class="page" id="arcontent">
            <?php echo $rr['content']; ?>
        </div>
        <div class="homeback2">
            <?php
            $url = explode("id=", $_SERVER['REQUEST_URI']);
            if (count($url) < 2) {
                $url_r = $url[0] . "&";
            } else {
                $url_r = $url[0];
            }
            /*if($prer['id']!=""){
                echo "<a href=\"".$url_r."id=".$prer['id']."\" id=\"previousa\" class=\"\">上一則</a>";
            }
            if($nextr['id'] != ""){
                echo "<a href=\"".$url_r."id=".$nextr['id']."\" id=\"previousa\">下一則</a>";
            }*/
            ?>
            <a href="javascript:void(0);" id="previousa">上一則</a>
            <a href="javascript:void(0);" id="nexta">下一則</a>
            <input type="hidden" id="hiddenid" name="hiddenid" value="<?php echo $id; ?>">
        </div>
    </div>
    <div class="news_box">
        <ul id="dataul">
            <?php
            foreach ($result as $record) {
                ?>
                <li alt="<?php echo $record['id']; ?>">
                    <a href="<?php echo $url_r; ?>id=<?php echo $record['id']; ?>"
                       class="showNews"><span><?php echo $record['startDate']; ?></span><?php echo $record['title']; ?>
                    </a>
                </li>
            <?php
            }
            ?>
        </ul>
    </div>
    <div class="page-no">
        <div class="no_box" id="pagecount">
            <div class="no_box">
                <ul>
                    <?php
                    if ($num_pages > 1) { // 若不是第一頁則顯示
                        ?>
                        <li><a href="<?php echo "{$_SERVER['PHP_SELF']}"; ?>?page=1">最前一頁</a></li>
                        <li><a href="<?php echo "{$_SERVER['PHP_SELF']}"; ?>?page=<?php echo $num_pages - 1; ?>">上一頁</a>
                        </li>
                    <?php } ?>
                    <?php if ($num_pages < $total_pages) { // 若不是最後一頁則顯示 ?>
                        <li><a href="<?php echo "{$_SERVER['PHP_SELF']}"; ?>?page=<?php echo $num_pages + 1; ?>">下一頁</a>
                        </li>
                        <li><a href="<?php echo "{$_SERVER['PHP_SELF']}"; ?>?page=<?php echo $total_pages; ?>">最後一頁</a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>

    <?php include_once('templates/homeback.php'); ?>
</div>

<?php
include_once('templates/footer.php');
?>
<script>
    $(function () {

        //儲存 依上架日排序的 id
        var idarr = new Array();

        var initid;
        var newid;
        var key;

        //進入頁面先取出id再存到陣列
        $.ajax({
            url: 'ajax/news.php',
            catch: false,
            dataType: 'json',
            type: 'GET',
            data: {
                mode: "readid"
            },
            error: function (xhr) {
                alert('Ajax request 發生錯誤');
            },
            success: function (data) {
                for (var i = 0; i < data.length; i++) {
                    idarr[i] = data[i]['id'];
                }

                initid = $('#hiddenid').val();
                key = jQuery.inArray(initid, idarr);


            }
        });

        //點擊下一則，比對id後取資料
        $('#nexta').click(function () {
            $('#previousa').show();
            key = key + 1;
            newid = idarr[key];
            if(key < idarr.length){
                $.ajax({
                    url: 'ajax/news.php',
                    catch: false,
                    dataType: 'json',
                    type: 'GET',
                    data: {
                        mode: "readById",
                        id: newid
                    },
                    error: function (xhr) {
                        alert('Ajax request 發生錯誤');
                    },
                    success: function (data) {
                        $('#ardate').html(data['startDate']);
                        $('#artitle').html(data['title']);
                        $('#arcontent').html(data['content']);

                    }
                });
            }else{
                key = idarr.length -1 ;
                $('#nexta').hide();
            }


        });

        //點擊上一則，比對id後取資料
        $('#previousa').click(function () {
            $('#nexta').show();
            key = key - 1;
            newid = idarr[key];
            if (!key || key > -1) {
                $.ajax({
                    url: 'ajax/news.php',
                    catch: false,
                    dataType: 'json',
                    type: 'GET',
                    data: {
                        mode: "readById",
                        id: newid
                    },
                    error: function (xhr) {
                        alert('Ajax request 發生錯誤');
                    },
                    success: function (data) {
                        $('#ardate').html(data['startDate']);
                        $('#artitle').html(data['title']);
                        $('#arcontent').html(data['content']);

                    }
                });
            }else{
                key=0;
                $('#previousa').hide();

            }

        });


    })
</script>
