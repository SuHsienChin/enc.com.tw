<?php
session_start();
header("Content-Type:text/html; charset=utf-8");
// 藉由含括子系統的設定檔，取得網站及子系統的各種設定
include_once('appConfig.php');
// 引入資料庫
include_once(INCLUDE_DIR . 'db.php');

include_once('class/ClassQandAClass.php');
//取得日期
$getDate = date("Y-m-d");


// 產生物件
$obj = new ClassQandAClass();
$obj->select();
$rowcount = count($obj);

if (isset($_POST['submit'])) {
    // 呼叫 setProperties() 方法，將物件各屬性，設定為表單各相對欄位的資料
    $obj->setProperties();
    $obj->id = $_GET['id'];
    // 呼叫 方法，新增一筆留言的資料
    $obj->update() || die('更新失敗');

    echo "<script>alert('更新成功');</script>";
    echo "<script>document.location.href=\"qandaclass.php\";</script>";
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
                        <h4 class="page-header"><a href="qandaclass.php">Q&A類別管理</a>>更新Q&A類別</h4>
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
                                                    <span class="input-group-addon">類別名稱</span>
                                                    <input type="text" class="form-control" placeholder="類別名稱"
                                                           name="name" value="<?php echo $record['name']; ?>">
                                                </div>
                                                <div class="form-group input-group">
                                                    <label>排序</label>
                                                    <select class="form-control" name="sort">
                                                        <?php
                                                        for ($i = 1; $i <= $rowcount + 1; $i++) {
                                                            if ($record['sort'] == $i) {
                                                                echo "<option selected>$i</option>";
                                                            } else {
                                                                echo "<option>$i</option>";
                                                            }

                                                        }
                                                        ?>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label>狀態</label>
                                                    <label class="radio-inline">
                                                        <input type="radio" name="flag" id="optionsRadiosInline1"
                                                               value="1"
                                                               <?php if ($record['flag'] == 1) { ?>checked <?php } ?>>啟用
                                                    </label>
                                                    <label class="radio-inline">
                                                        <input type="radio" name="flag" id="optionsRadiosInline2"
                                                               value="0"
                                                               <?php if ($record['flag'] == 0) { ?>checked <?php } ?>>停用
                                                    </label>
                                                </div>
                                                <div class="form-group input-group">
                                                    <span class="input-group-addon">建檔人員</span>
                                                    <input type="text" class="form-control" placeholder="建檔人員" disabled
                                                           name="man" value="<?php echo $record['creater'] ?>">
                                                </div>
                                                <div class="form-group input-group">
                                                    <span class="input-group-addon">建檔日期</span>
                                                    <input type="text" class="form-control" placeholder="建檔日期"
                                                           value="<?php echo $getDate; ?>" name="creatDate">
                                                </div>
                                                <button type="submit" class="btn btn-default"
                                                        onclick="return confirm('確定要新增?');" name="submit">送出
                                                </button>
                                                <input type="hidden" name="id" value="">
                                                <input type="hidden" name="creater" value="">
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

    <script>

        $(function () {

            $.datepicker.regional['zh-TW'] = {
                dayNames: ["星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六"],
                dayNamesMin: ["日", "一", "二", "三", "四", "五", "六"],
                monthNames: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
                monthNamesShort: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
                prevText: "上月",
                nextText: "次月",
                weekHeader: "週"
            };
            $.datepicker.setDefaults($.datepicker.regional["zh-TW"]);
            $("#datepicker").datepicker({dateFormat: "yy-mm-dd", showMonthAfterYear: true});
        });

    </script>

    </body>

    </html>
<?php
include_once "ckeditor/ckeditor.php";
$CKEditor = new CKEditor();
$CKEditor->basePath = 'ckeditor/';
$CKEditor->replace("editor1");
?>