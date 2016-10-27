<?php
header("Content-Type:text/html; charset=utf-8");
// 藉由含括子系統的設定檔，取得網站及子系統的各種設定
include_once('appConfig.php');
// 引入資料庫
include_once(INCLUDE_DIR.'db.php');

include_once('class/class_news.php');

//產生物件
$obj = new class_news();

//呼叫 getRecordset 取資料
$recordset = $obj->select();

include_once('templates/header.php');
?>

<script>
    var curPage = 1; //當前頁碼
    var total,pageSize,totalPage;

    //获取数据
    function getData(page){
        $.ajax({
            type: 'GET',
            url: 'ajax/news.php',
            data: {
                'pageNum':page-1,
                'mode':'read'
            },
            dataType:'json',
            beforeSend:function(){
                $(".title_03").append("<li id='loading'>loading...</li>");
            },
            success:function(json){
                total = json.total; //总记录数
                pageSize = json.pageSize; //每页显示条数
                curPage = page; //当前页
                totalPage = json.totalPage; //总页数
                alert(json);
            },
            complete:function(){ //分頁bar
                getPageBar();
            },
            error:function(){
                alert("數據加載失敗");
            }
        });
    }

    //获取分页条
    function getPageBar(){
        //页码大于最大页数
        if(curPage>totalPage) curPage=totalPage;
        //页码小于1
        if(curPage<1) curPage=1;
        pageStr = "<span>共"+total+"条</span><span>"+curPage+"/"+totalPage+"</span>";

        //如果是第一页
        if(curPage==1){
            pageStr += "<span>首页</span><span>上一页</span>";
        }else{
            pageStr += "<span><a href='javascript:void(0)' rel='1'>首页</a></span><span><a href='javascript:void(0)' rel='"+(curPage-1)+"'>上一页</a></span>";
        }

        //如果是最后页
        if(curPage>=totalPage){
            pageStr += "<span>下一页</span><span>尾页</span>";
        }else{
            pageStr += "<span><a href='javascript:void(0)' rel='"+(parseInt(curPage)+1)+"'>下一页</a></span><span><a href='javascript:void(0)' rel='"+totalPage+"'>尾页</a></span>";
        }

        $("#pagecount").html(pageStr);
    }
    $(function(){
        getData(1);
        $("#pagecount span a").live('click',function(){
            var rel = $(this).attr("rel");
            if(rel){
                getData(rel);
            }
        });
    });
</script>
<!--右頁面-->
<div class="righr_page">
<div class="title_02">
<h2><span>最新消息</span></h2>
</div>
<div class="page_body">
  <h3 class="title_03"><span>2014-10-16</span>美國EB-3非技術勞工移民說明會</h3>
  <div class="page">
    <p>圖文編輯</p>
    <p>主講人:美國律師 Mr. Brian Kaminski<br>
       EB-3: 需要勞工證和美國雇主的贊助，但申請人可以:<br>
      1.擁有大學文憑；或<br>
      2.有兩年的特殊技能的訓練或工作經驗；或<br>
      3.不需要任何學歷或經驗(又稱非技術勞工)    非技術性勞工移民申請要求:<br>
      1.年齡介於 18-50 歲優先<br>
      2.身體健康<br>
      3.必需願意為雇主工作一年<br>
      4.無犯罪紀錄    非技術性勞工移民優勢<br>
      1.要求少<br>
      2.費用低<br>
      3.無風險<br>
      4.流程簡單快速<br>
      5.直接獲得永久綠卡<br>
      6.擔保至少 12 個月的全職工作 </p>
  </div>
  <div class="homeback2">
  <a href="#" class="btn_previous2">上一則</a>
   <a href="#" class="btn_next2">下一則</a>
  </div>
</div>
<div class="news_box">
    <ul>
    <?php
        foreach ($recordset as $record) {
    ?>
        <li><a href="shownews.php"><span><?php echo $record['creatDate'];?></span><?php echo $record['title'];?></a></li>
    <?php
        }
    ?>
    </ul>
</div>
<div class="page-no">
            <div class="no_box" id="pagecount">

            </div>
          </div>
    
    <div class="homeback">
<a href="index.html" class="btn_previous">回上頁</a>
<a href="index.html" class="btn_home">回首頁</a>
</div>
   </div>
<?php
include_once('templates/footer.php');
?>