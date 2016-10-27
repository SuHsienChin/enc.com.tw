<?php
session_start();
header("Content-Type:text/html; charset=utf-8");
// 藉由含括子系統的設定檔，取得網站及子系統的各種設定
include_once('appConfig.php');
// 引入資料庫
include_once('../inc/db.php');
// Users類別
include_once('class/ClassAboutUs.php');

if($_POST){
    $editor1 = $_POST["editor1"];

//insert
    try{
        $dbClass = new Database();
        $dbh = $dbClass->getDb();
        $ad = new ClassAboutUs($dbh);
        $sql="DELETE FROM aboutus ;";
        $sql.="INSERT INTO aboutus (contents)";
        $sql.="VALUES ('".$editor1."');";
        if($ad->add($sql)){
            echo "<script>alert('送出成功');</script>";
        }else{
            echo "<script>alert('送出失敗');</script>";
        }
    }catch(PDOException $e){

    }
}
?>
<!DOCTYPE html>
<html lang="en">
<!-- 引入head檔 -->
<?php include('layout/head.php');?>
<link href="ckeditor/_samples/sample.css" rel="stylesheet" type="text/css"/>
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
                        <h3 class="page-header">關於我們單元管理</h3>
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
                                            <form role="form" action="" method="post">
                                                <?php
                                                $dbClass = new Database();
                                                $dbh = $dbClass->getDb();
                                                $ad = new ClassAboutUs($dbh);
                                                $result = $ad->read();
                                                ?>
                                                <textarea class="form-control" cols="100" id="editor1" name="editor1" rows="20"><?php echo $result['contents'];?></textarea>
                                                <button type="submit" class="btn btn-default" onclick="return confirm('確定要送出?');">送出</button>
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

</body>

</html>

<?php
include_once "ckeditor/ckeditor.php";
$CKEditor = new CKEditor();
$CKEditor->basePath = 'ckeditor/';
$CKEditor->replace("editor1");
?>
