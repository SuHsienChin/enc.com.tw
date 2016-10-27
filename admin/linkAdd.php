<?php
session_start();
header("Content-Type:text/html; charset=utf-8");
// 藉由含括子系統的設定檔，取得網站及子系統的各種設定
include_once('appConfig.php');
// 引入資料庫
include_once(INCLUDE_DIR . 'db.php');

include_once('class/ClassLink.php');

//取得日期
$getDate = date("Y-m-d");
//產生物件

if (isset($_POST['submit'])) {
//檔案
    $filename = $_FILES["file"]["name"];
    $tmpfile = $_FILES["file"]["tmp_name"];
    $size = $_FILES["file"]["size"];
    $type = $_FILES["file"]["type"];
    $newfilename = md5(uniqid(rand()));
    $temp = explode(".", $_FILES["file"]["name"]);
    $extension = end($temp);
    $newName = $newfilename . "." . $extension;
    if (move_uploaded_file($_FILES['file']['tmp_name'], "upload/link/" . $_FILES["file"]["name"])) {
        rename("upload/link/" . $_FILES["file"]["name"], "upload/link/" . $newName);
        // "上傳成功"
        //產生物件
        $obj = new ClassLink();
        // 呼叫 setProperties() 方法，將物件各屬性，設定為表單各相對欄位的資料
        $obj->name = $_POST['name'];
        $obj->url = $_POST['url'];
        $obj->pic = $newName;


        //呼叫 Add 方法，新增一筆資料
        $obj->Add() || die('無法新增');

        echo "<script>alert('新增成功');</script>";
        echo "<script>document.location.href=\"link.php\";</script>";
        exit;
    } else {
        //產生物件
        $obj = new ClassLink();
        // 呼叫 setProperties() 方法，將物件各屬性，設定為表單各相對欄位的資料
        $obj->name = $_POST['name'];
        $obj->url = $_POST['url'];
        $obj->pic = "";


        //呼叫 Add 方法，新增一筆資料
        $obj->Add() || die('無法新增');

        echo "<script>alert('新增成功');</script>";
        echo "<script>document.location.href=\"link.php\";</script>";
        exit;
    }
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
                        <h4 class="page-header"><a href="link.php">好站連結管理</a>> 新增好站連結</h4>
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
                                                    <input type="text" class="form-control" placeholder="站名"
                                                           name="name">
                                                </div>
                                                <div class="form-group input-group">
                                                    <span class="input-group-addon">網址</span>
                                                    <input type="text" class="form-control" placeholder="網址" name="url">
                                                </div>
                                                <div class="form-group">
                                                    <label>圖片</label>
                                                    <input type="file" name="file">
                                                </div>
                                                <button type="submit" class="btn btn-default"
                                                        onclick="return confirm('確定要新增?');" name="submit">新增
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