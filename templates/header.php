<?php

// 藉由含括子系統的設定檔，取得網站及子系統的各種設定
include_once('appConfig.php');
// 引入資料庫
include_once(INCLUDE_DIR . 'db.php');

//資料庫連線
try {
    $db = new PDO("mysql:host=".DB_HOST.";dbname=".DB_DATABASE, DB_USER, DB_PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
}
catch(PDOException $e)
{
    echo $e->getMessage();
}

$sql = "SELECT * FROM webseo";
$st = $db->prepare($sql);
$st->execute();
$res = $st->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="zh-tw"><head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title><?php echo $res['title']; ?></title>
    <meta name="description" content="<?php echo $res['webDesc'];?>" />
    <meta name="keywords" content="<?php echo $res['keyWords']; ?>" />
    <link rel="stylesheet" href="css/desktop-layout.css">
    <link rel="stylesheet" href="css/responsiverc.css">
    <script type="text/javascript" src="js/jquery-latest.min.js"></script>
    <script type="text/javascript" src="js/menu.js"></script>
    <script type="text/javascript" src="js/photo.js"></script>
    <!-- 驗證表單 js -->
    <script src="js/jquery.validate.min.js"></script>
    <script src="js/jQueryValidation_localization/messages_zh_TW.min.js"></script>

</head>

<body>
<!--header star----------------->
<header>
    <div id="header">
        <h1><a href="index.php">維德國際開發有限公司</a></h1>
        <div class="sv_r">
            <div class="link">
                <ul>
                    <li class="link07"><a href="index.php">回首頁</a></li>
                    <li class="link02"><a href="javascript: void(window.open('http://www.facebook.com/share.php?u='.concat(encodeURIComponent(location.href)) ));">
                            推到 Facebook</a></li>
                    <li class="link03"><a href="javascript: void(window.open('http://www.plurk.com/?qualifier=shares&status=' .concat(encodeURIComponent(location.href))
                 .concat(' ') .concat('&#40;') .concat(encodeURIComponent(document.title)) .concat('&#41;')));">推到Plurk</a></li>
                    <li class="link04"><a href="javascript: void(window.open('http://twitter.com/home/?status='.concat(encodeURIComponent(document.title))
                 .concat(' ') .concat(encodeURIComponent(location.href))));">推到Twitter</a></li>
                    <li><script type="text/javascript" src="https://apis.google.com/js/plusone.js">{lang: 'zh-TW'}</script>
                        <g:plusone size="small"></g:plusone></li>
                </ul>

            </div>
            <div class="sv_box">
                <form method="get" action="search.php">
                <input name="keywords" type="text" class="txt_sv" placeholder="搜尋關鍵字"><input name="" type="submit" value="搜尋" class="btn_sv">
                </form>
            </div>
        </div>
        <h4 id="TOP_MENU">選單</h4>
    </div>
</header>
<!--header end----------------->
<!--主選單-->
<nav class="menu_ber">
    <div class="menu">
        <ul id="SUBMENU">
            <li id="SUBMENU_in">X</li>
            <li><a href="index.php">首頁</a></li>
            <li><a href="about.php">關於我們</a></li>
            <li><a href="news.php?page=1">最新消息</a></li>
            <li><a href="fqa.php">常見問答</a></li>
            <li><a href="link.php">好站連結</a></li>
            <li><a href="download.php">檔案下載</a></li>
            <li><a href="contactus.php">聯絡我們</a></li>

        </ul>
    </div>
</nav>

<!--section star----------------->
<section>
    <div class="conter">
        <!--左選單-->
        <nav>
            <div class="lift_menu">
                <ul>
                    <li class="menu2_1"><a href="class.php?code=E">移民館</a></li>
                    <li class="menu2_2"><a href="class.php?code=L">留學館</a></li>
                    <li class="menu2_3"><a href="class.php?code=G">中學館</a></li>
                    <li class="menu2_4"><a href="class.php?code=W">語言館</a></li>
                </ul>
            </div>
        </nav>