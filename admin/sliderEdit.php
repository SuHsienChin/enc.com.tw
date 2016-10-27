<?php
session_start();
header("Content-Type:text/html; charset=utf-8");
// 藉由含括子系統的設定檔，取得網站及子系統的各種設定
include_once('appConfig.php');
// 引入資料庫
include_once(INCLUDE_DIR . 'db.php');

include_once('class/ClassSlider.php');
//取得日期
$getDate = date("Y-m-d");


// 產生 物件
$obj = new ClassSlider();
if (isset($_POST['submit'])) {
    // 呼叫 setProperties() 方法，將物件各屬性，設定為表單各相對欄位的資料
    $obj->title = $_POST['title'];
    $obj->url = $_POST['url'];
    $obj->desc = $_POST['desc'];
    $obj->flag = $_POST['flag'];
    $obj->id = $_GET['id'];
    $obj->update() || die('無法更新');

    echo "<script>alert('更新成功');</script>";
    echo "<script>document.location.href=\"setSlider.php\";</script>";
    exit;
} else {
    // 設定 物件的 id 屬性
    $obj->id = $_GET['id'];
    //使用 物件的 Retrieve() 方法，取得這筆留言的資料
    $record = $obj->Retrieve();
}
?>
<!DOCTYPE html>
<html lang="en">
<!-- 引入head檔 -->
<?php include('layout/head.php'); ?>
<body>

<div id="wrapper">
    <!-- Navigation start -->
    <?php include_once('layout/navigation.php'); ?>
    <!-- Navigation end -->

    <!-- Page Content start -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header">更新圖片資訊</h3>
                </div>
                <!-- /.col-lg-12 -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">

                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <form role="form" method="post">
                                            <div class="form-group input-group">
                                                <img src="server/php/files/<?php echo $record['name']; ?>" width="50%"
                                                     heigth="50%">
                                            </div>
                                            <div class="form-group input-group">
                                                <span class="input-group-addon">圖片標題</span>
                                                <input type="text" class="form-control" placeholder="圖片標題" name="title"
                                                       value="<?php echo $record['title']; ?>">
                                            </div>
                                            <div class="form-group input-group">
                                                <span class="input-group-addon">圖片連結</span>
                                                <input type="text" class="form-control"
                                                       placeholder="圖片連結 例：http://tw.yahoo.com/" name="url"
                                                       value="<?php echo $record['url']; ?>">
                                            </div>
                                            <div class="form-group input-group">
                                                <span class="input-group-addon">圖片描述</span>
                                                <input type="text" class="form-control" placeholder="圖片描述" name="desc"
                                                       value="<?php echo $record['description']; ?>">
                                            </div>
                                            <div class="form-group input-group">
                                                <label>狀態</label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="flag" id="flag1"
                                                           value="1" <?php if ($record['flag'] == 1) echo "checked"; ?>>啟用
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="flag" id="flag2"
                                                           value="0" <?php if ($record['flag'] == 0) echo "checked"; ?>>停用
                                                </label>
                                            </div>

                                            <button type="submit" class="btn btn-default"
                                                    onclick="return confirm('確定要送出?');" name="submit">送出
                                            </button>
                                        </form>
                                    </div>
                                    <!-- /.col-lg-6 (nested) -->

                                </div>
                                <!-- /.row (nested) -->
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
</div>
<!-- /#wrapper -->

<!-- jQuery -->
<script src="../bower_components/jquery/dist/jquery.min.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

<!-- Custom Theme JavaScript -->
<script src="../dist/js/sb-admin-2.js"></script>


</body>

</html>
