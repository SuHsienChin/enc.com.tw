<?php
session_start();

header("Content-Type:text/html; charset=utf-8");
// 藉由含括子系統的設定檔，取得網站及子系統的各種設定
include_once('appConfig.php');
// 引入資料庫
include_once(INCLUDE_DIR . 'db.php');

//權限
include_once('class/ClassSideAd.php');

//取得日期
$getdate = date('Y-m-d');

$obj = new ClassSideAd();

if (isset($_POST['submit'])) {

    $obj->id = $_GET['id'];
    $obj->title = $_POST['title'];
    $obj->url = $_POST['url'];
    $obj->file = $_POST['datafile'];
    $obj->flag = $_POST['flag'];


//檔案
    $filename = $_FILES["file"]["name"];
    $tmpfile = $_FILES["file"]["tmp_name"];
    $size = $_FILES["file"]["size"];
    $type = $_FILES["file"]["type"];
    $newfilename = md5(uniqid(rand()));
    $temp = explode(".", $_FILES["file"]["name"]);
    $extension = end($temp);
    $newName = $newfilename . "." . $extension;
    if (move_uploaded_file($_FILES['file']['tmp_name'], "upload/sidead/" . $_FILES["file"]["name"])) {
        rename("upload/sidead/" . $_FILES["file"]["name"], "upload/sidead/" . $newName);

        $fname = "upload/sidead/" . $_POST['datafile'];
        if (file_exists($fname)) {
            @unlink($fname);//將檔案刪除
        }
        $obj->file = $newName;
    }

    $obj->update();
    echo "<script>alert('更新成功');</script>";
    echo "<script>document.location.href=\"sidead.php\";</script>";
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
                    <h4 class="page-header"><a href="sidead.php">側邊廣告管理</a>>編輯側邊廣告</h4>
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
                                                <input type="text" class="form-control" placeholder="標題" name="title"
                                                       value="<?php echo $result['title']; ?>">
                                            </div>
                                            <div class="form-group input-group">
                                                <span class="input-group-addon">連結</span>
                                                <input type="text" class="form-control"
                                                       placeholder="連結 例：http://example.com" name="url"
                                                       value="<?php echo $result['url']; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>狀態</label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="flag" id="flag1" value="1"
                                                        <?php if ($result['flag'] == "1") echo "checked" ?>>啟用
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="flag" id="flag0"
                                                           value="0" <?php if ($result['flag'] == "0") echo "checked" ?>>停用
                                                </label>

                                            </div>
                                            <div class="form-group">
                                                <br/>
                                                <label>上傳廣告小圖（建議尺寸:寬度250px)</label><br />
                                                <img src="upload/sidead/<?php echo $result['file']; ?>" width="200px" height="70px">
                                                <input type="file" name="file" id="file">
                                                <input type="hidden" value="<?php echo $result['file']; ?>"
                                                       name="datafile">

                                            </div>
                                            <button type="submit" class="btn btn-default"
                                                    onclick="return confirm('確定要送出?');" name="submit">送出
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
