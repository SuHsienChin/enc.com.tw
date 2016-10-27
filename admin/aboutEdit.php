<?php
session_start();

header("Content-Type:text/html; charset=utf-8");
// 藉由含括子系統的設定檔，取得網站及子系統的各種設定
include_once('appConfig.php');
// 引入資料庫
include_once(INCLUDE_DIR . 'db.php');

//權限
include_once('class/ClassAbout.php');
$obj = new ClassAbout();

if (isset($_POST['submit'])) {

    $obj->title = $_POST['title'];
    $obj->content = $_POST['content'];
    $obj->flag = $_POST['flag'];
    $obj->id = $_GET['id'];
    $obj->update();

    echo "<script>alert('新增成功');</script>";
    echo "<script>document.location.href=\"about.php\";</script>";
    exit;
} else {
    $obj->id = $_GET['id'];
    $result = $obj->Retrieve();
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
                        <h4 class="page-header"><a href="about.php">關於我們管理</a>>編輯關於我們</h4>
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
                                            <form role="form" method="post" enctype="multipart/form-data">
                                                <div class="form-group input-group">
                                                    <span class="input-group-addon">標題</span>
                                                    <input type="text" class="form-control" placeholder="標題"
                                                           name="title" value="<?php echo $result['title']; ?>">
                                                </div>
                                                <div class="form-group input-group">
                                                    <div class="panel-heading">
                                                        內容
                                                    </div>
                                                    <div class="panel-body">
                                                        <textarea class="form-control" cols="100" id="editor1"
                                                                  name="content"
                                                                  rows="20"><?php echo $result['content']; ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>狀態</label>
                                                    <label class="radio-inline">
                                                        <input type="radio" name="flag" id="flag1" value="1"
                                                            <?php if ($result['flag'] == 1) echo "checked"; ?>>啟用
                                                    </label>
                                                    <label class="radio-inline">
                                                        <input type="radio" name="flag" id="flag0"
                                                               value="0" <?php if ($result['flag'] == 0) echo "checked"; ?>>停用
                                                    </label>

                                                </div>
                                                <button type="submit" class="btn btn-default"
                                                        onclick="return confirm('確定更新?');" name="submit">更新
                                                </button>
                                                <button type="reset" class="btn btn-default">重設</button>
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

        $(function () {
            //檢查帳號是否有重覆
            $('#account').blur(function () {
                var account = $('#account').val();
                $.ajax({
                    url: 'ajax/account.php',
                    catch: false,
                    dataType: 'json',
                    type: 'GET',
                    data: {
                        account: account,
                        mode: "check"
                    },
                    error: function (xhr) {
                        alert('Ajax request 發生錯誤');
                    },
                    success: function (data) {
                        //0:國家代碼存在
                        if (data == "0") {
                            alert('帳號存在，請重新輸入');
                            $('#account').val("");
                            $('#account').focus();
                        } else {

                        }

                    }
                });
            });

        })

    </script>


    </body>

    </html>
<?php
include_once "ckeditor/ckeditor.php";
$CKEditor = new CKEditor();
$CKEditor->basePath = 'ckeditor/';
$CKEditor->replace("editor1");
?>