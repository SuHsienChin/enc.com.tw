<?php
session_start();
header("Content-Type:text/html; charset=utf-8");
// 藉由含括子系統的設定檔，取得網站及子系統的各種設定
include_once('appConfig.php');
// 引入資料庫
include_once(INCLUDE_DIR . 'db.php');

include_once('class/Classdlf.php');
include_once('class/Classdlc.php');
//取得日期
$getDate = date("Y-m-d");

$cobj = new Classdlc();
$result = $cobj->select();


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

    if (move_uploaded_file($_FILES['file']['tmp_name'], "upload/" . $_FILES["file"]["name"])) {
        rename("upload/" . $_FILES["file"]["name"], "upload/" . $newName);
        // "上傳成功"

        $fname = "upload/" . $_POST['oldname'];
        //刪除檔案
        if (file_exists($fname)) {
            unlink($fname);//將檔案刪除
        }
        //產生物件
        $obj = new Classdlf();
        // 呼叫 setProperties() 方法，將物件各屬性，設定為表單各相對欄位的資料
        $obj->name = $filename;
        $obj->tmp_name = $tmpfile;
        $obj->size = $size;
        $obj->type = $type;
        $obj->url = "upload/" . $_FILES["file"]["name"];
        $obj->title = $_POST['title'];
        $obj->cId = $_POST['cId'];
        $obj->filename = $newName;
        $obj->id=$_GET['id'];

        //呼叫 Add 方法，新增一筆資料
        $obj->update() || die('無法更新');

        echo "<script>alert('更新成功');</script>";
        echo "<script>document.location.href=\"dlfile.php\";</script>";
        exit;
    } else {

        //資料庫連線
        try {
            $db = new PDO("mysql:host=".DB_HOST.";dbname=".DB_DATABASE, DB_USER, DB_PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }

        $title = $_POST['title'];
        $cId = $_POST['cId'];


        $update_sql = "UPDATE dlfiles SET cId='$cId',title='$title'";
        $update_sql .= " WHERE id='".$_GET['id']."'";

        $st = $db->prepare($update_sql);
        try{
            $st->execute();
            echo "<script>alert('更新成功');</script>";
            echo "<script>document.location.href=\"dlfile.php\";</script>";
            exit;
        }catch (PDOException $e){

        }






    }


}else{
    $obj = new Classdlf();
    $obj->id = $_GET['id'];
    $res=$obj->Retrieve();
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
                        <h4 class="page-header"><a href="dlfile.php">檔案管理</a>>編輯檔案</h4>
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
                                                <div class="form-group">
                                                    <label>選擇類別</label>
                                                    <select class="form-control" name="cId">
                                                        <?php
                                                        foreach ($result as $item) {
                                                            if($res['cId']==$item['id']){
                                                                echo "<option value=\"" . $item['id'] . "\" selected>" . $item['title'] . "</option>\n";
                                                            }else{
                                                                echo "<option value=\"" . $item['id'] . "\">" . $item['title'] . "</option>\n";
                                                            }

                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group input-group">
                                                    <span class="input-group-addon">檔案標題</span>
                                                    <input type="text" class="form-control" placeholder="檔案標題"
                                                           name="title" value="<?php echo $res['title'] ?>">
                                                </div>
                                                <div class="form-group">

                                                    <label>檔案名稱：<?php echo $res['url']?></label>
                                                    <br />
                                                    <br />
                                                    <label>選擇檔案</label>
                                                    <input type="file" name="file">
                                                </div>

                                                <button type="submit" class="btn btn-default"
                                                        onclick="return confirm('確定要更新?');" name="submit">更新
                                                </button>
                                                <input type="hidden" name="oldname" value="<?php echo $res['filename'] ;?>">
                                                <button type="reset" class="btn btn-default">重設</button>
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