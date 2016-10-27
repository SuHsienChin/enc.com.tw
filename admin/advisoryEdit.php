<?php
session_start();

header("Content-Type:text/html; charset=utf-8");
// 藉由含括子系統的設定檔，取得網站及子系統的各種設定
include_once('appConfig.php');
// 引入資料庫
include_once(INCLUDE_DIR . 'db.php');

include_once('class/ClassAdvisory.php');

//取得日期
$getdate = date('Y-m-d');

$obj = new ClassAdvisory();

if (isset($_POST['submit'])) {
    //產生物件
    $obj = new ClassAdvisory();
    // 呼叫 setProperties() 方法，將物件各屬性，設定為表單各相對欄位的資料
    $obj->id = $_GET['id'];
    $obj->reply = $_POST['reply'];
    $obj->replyer = $_POST['replyer'];
    $obj->replyDate = $getdate;
    $obj->process = "1";
    //$obj->setProperties();
    //執行刪除一則最新消息
    if ($obj->update()) {
        echo "<script>alert('更新成功');</script>";
        echo "<script>document.location.href=\"advisory.php\";</script>";
        exit;
    } else {
        echo "<script>alert('更新失敗');</script>";
        echo "<script>document.location.href=\"advisory.php\";</script>";
    }

} else {
    //取得資料
    $obj->id = $_GET['id'];
    $result = $obj->Retrieve();

    //print_r($us_re);
    /* 搜尋 回傳值 有沒有在陣列裡 ps:目前用不到
    foreach($us_re as $row) {
        if ( in_array( '後台管理者帳號管理', $row  ) ) { echo "WAHOO"; }
    }
    */


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
                        <h3 class="page-header">編輯帳號</h3>
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
                                                <div class="panel panel-success">
                                                    <div class="panel-heading">
                                                        諮詢內容
                                                    </div>
                                                    <div class="panel-body">
                                                        <label>諮詢姓名：</label><?php echo $result['name']; ?><br/><br/>
                                                        <label>E-MAIL：</label><?php echo $result['email']; ?><br/><br/>
                                                        <label>聯絡電話：</label><?php echo $result['tel']; ?><br/><br/>
                                                        <fieldset>
                                                            <label>諮詢內容</label>
                                                            <br/>
                                                            <?php echo nl2br($result['content']); ?>
                                                        </fieldset>

                                                    </div>
                                                </div>
                                                <div class="form-group input-group">
                                                    <span class="input-group-addon">回覆人</span>
                                                    <input type="text" class="form-control" placeholder="名稱" name="replyer"
                                                           value="<?php echo $_SESSION['name'] ?>" readonly>
                                                </div>
                                                <div class="form-group input-group">
                                                    <span class="input-group-addon">回覆日期</span>
                                                    <input type="text" class="form-control" placeholder="帳號"
                                                           name="account"
                                                           id="account" value="<?php echo $_SESSION['account'] ?>" readonly>
                                                </div>
                                                <div class="form-group input-group">
                                                    <div class="panel-heading">
                                                        回覆內容
                                                    </div>
                                                    <div class="panel-body">
                                                        <textarea class="form-control" cols="100" id="editor1"
                                                                  name="reply" rows="10"> <?php echo nl2br($result['reply']); ?></textarea>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-default"
                                                        onclick="return confirm('確定送出?');" name="submit">送出
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

    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

    <script>
        //checkbox全選
        $("#checkAll").on("click", function () {
            if ($(this).prop("checked") === true) {
                $("input[name='purview[]']").prop("checked", $(this).prop("checked"));
                $('#example tbody tr').addClass('selected');
            } else {
                $("input[name='purview[]']").prop("checked", false);
                $('#example tbody tr').removeClass('selected');
            }
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