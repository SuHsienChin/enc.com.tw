<!--搜尋/廣告-->
<div class="flo_box">
    <!---->
    <div class="contactus_box">
        <?php include_once('advisory.php');?>
    </div>
    <!---->
    <div class="ad_list">
        <?php include_once('ad_list.php'); ?>
    </div>

</div>
</section>
<!--section end----------------->


<!--footer star----------------->
<footer>
    <div class="footer">
        <?php include_once("copyright.php"); ?>
        <div class="web_map">
            <div class="list_6">
                <h6>維德國際</h6>
                <ul>
                    <li><a href="about.php">關於我們</a></li>
                    <li><a href="news.php">最新消息</a></li>
                    <li><a href="fqa.phh">常見問答</a></li>
                    <li><a href="link.php">好站連結</a></li>
                    <li><a href="download.php">檔案下載</a></li>
                    <li><a href="contactus.php">聯絡我們</a></li>
                </ul>
            </div>
            <div class="list_6">
            <?php
                //移民館
                include_once('Immigrant.php');
            ?>
            </div>
            <div class="list_6">
                <?php
                //留學館
                include_once('study.php');
                ?>
            </div>
            <div class="list_6">
                <?php
                //中學館
                include_once('school.php');
                ?>
            </div>
            <div class="list_6">
                <?php
                //中學館
                include_once('lang.php');
                ?>
            </div>
            <div class="list_6">
                <?php
                //常見問答
                include_once('ffaq.php');
                ?>
            </div>
        </div>
    </div>
</footer>
<!--footer star----------------->
<div id="gotop">˄</div>
<?php

//引入計數器
include_once('admin/layout/usercount.php');
?>
</body>
</html>
