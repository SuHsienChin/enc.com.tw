<?php
session_start();
header("Content-Type:text/html; charset=utf-8");
// 藉由含括子系統的設定檔，取得網站及子系統的各種設定
include_once('appConfig.php');
// 引入資料庫
include_once(INCLUDE_DIR . 'db.php');

include_once('class/ClassLink.php');

//資料庫連線
try {
    $db = new PDO("mysql:host=".DB_HOST.";dbname=".DB_DATABASE, DB_USER, DB_PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
}
catch(PDOException $e)
{
    echo $e->getMessage();
}

if (isset($_POST['submit'])) {
//檔案
    @$filename = $_FILES["file"]["name"];
    @$tmpfile = $_FILES["file"]["tmp_name"];
    @$size = $_FILES["file"]["size"];
    @$type = $_FILES["file"]["type"];
    @$newfilename = md5(uniqid(rand()));
    @$temp = explode(".", $_FILES["file"]["name"]);
    @$extension = end($temp);
    @$newName = $newfilename . "." . $extension;
    if (move_uploaded_file($_FILES['file']['tmp_name'], "upload/link/" . $_FILES["file"]["name"])) {
        rename("upload/link/" . $_FILES["file"]["name"], "upload/link/" . $newName);

        $fname = "upload/link/" . $_POST['pic2'];
        //刪除檔案
        if (file_exists($fname)) {
            unlink($fname);//將檔案刪除
        }
        // "上傳成功"
        //產生物件

        $name = $_POST['name'];
        $url = $_POST['url'];
        $pic = $newName;
        $id = $_GET['id'];

        $sql = "UPDATE links SET name='$nam',url='$url',pic='$pic' WHERE id='$id'";
        $st = $db->prepare($sql);
        try{
            $st->execute();

            echo "<script>alert('更新成功');</script>";
            echo "<script>document.location.href=\"link.php\";</script>";
            exit;
        }catch (PDOException $e){

        }


    } else {
        $name = $_POST['name'];
        $url = $_POST['url'];
        $id = $_GET['id'];

        $sql = "UPDATE links SET name='$nam',url='$url' WHERE id='$id'";
        $st = $db->prepare($sql);
        try{
            $st->execute();

            echo "<script>alert('更新成功');</script>";
            echo "<script>document.location.href=\"link.php\";</script>";
            exit;
        }catch (PDOException $e){

        }
    }
} else {
    //產生物件
    $obj = new ClassLink();
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
                        <h4 class="page-header"><a href="link.php">好站連結管理</a>>編輯好站連結</h4>
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
                                                    <span class="input-group-addon">站名</span>
                                                    <input type="text" class="form-control" placeholder="站名" name="name"
                                                           value="<?php echo $result['name']; ?>">
                                                </div>
                                                <div class="form-group input-group">
                                                    <span class="input-group-addon">網址</span>
                                                    <input type="text" class="form-control" placeholder="網址" name="url"
                                                           value="<?php echo $result['url']; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label>圖片</label>
                                                    <input type="file" name="file">
                                                    <?php
                                                    if ($result['pic'] <> "") {
                                                        echo "<img src=\"upload/link/" . $result['pic'] . "\" width=\"100px\" height=\"100px\">";
                                                    }
                                                    ?>
                                                </div>
                                                <input type="hidden" name="pic2" value="<?php echo $result['pic']; ?>">
                                                <button type="submit" class="btn btn-default"
                                                        onclick="return confirm('確定要更新?');" name="submit">更新
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
        $("select#classId").change(function () {
            var classId = $("select#classId").val();
            $.ajax({
                url: 'ajax/getQandACount.php',
                catch: false,
                dataType: 'html',
                type: 'GET',
                data: {classId: $("select#classId").val()},
                error: function (xhr) {
                    alert('Ajax request 發生錯誤');
                },
                success: function (response) {
                    var count = parseInt(response);
                    $("select#sort").children().remove();
                    for (var i = 1; i <= count + 1; i++) {
                        $("select#sort").append($('<option></option>').attr('value', "" + i + "").text("" + i + ""));

                    }
                }


            });
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