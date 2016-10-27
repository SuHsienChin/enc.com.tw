<?php
session_start();
header("Content-Type:text/html; charset=utf-8");
// 藉由含括子系統的設定檔，取得網站及子系統的各種設定
include_once('appConfig.php');
// 引入資料庫
include_once('../inc/db.php');
// Users類別
include_once('class/classWebInfo.php');

if ($_POST) {
    $meil1 = $_POST["email1"];
    $meil2 = $_POST["email2"];
    $meil3 = $_POST["email3"];
    $meil4 = $_POST["email4"];
    $meil5 = $_POST["email5"];

//insert
    try {
        $dbClass = new Database();
        $dbh = $dbClass->getDb();
        $info = new classWebInfo($dbh);
        $sql = "DELETE FROM webinfo ;";
        $sql .= "INSERT INTO webinfo ( email1, email2, email3, email4, email5)";
        $sql .= "VALUES ('" . $meil1 . "','" . $meil2 . "','" . $meil3 . "','" . $meil4 . "','" . $meil5 . "')";
        if ($info->add($sql)) {
            echo "<script>alert('送出成功');</script>";
        } else {
            echo "<script>alert('送出失敗');</script>";
        }

    } catch (PDOException $e) {

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
                    <h3 class="page-header">網站資訊管理</h3>
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
                                        <?php
                                        $dbClass = new Database();
                                        $dbh = $dbClass->getDb();
                                        $info = new classWebInfo($dbh);
                                        $result = $info->read();

                                        ?>
                                        <form role="form" action="" method="post">
                                            <div class="form-group input-group">
                                                <span class="input-group-addon">網帳Email-1</span>
                                                <input type="text" class="form-control" placeholder="網帳Email-1"
                                                       name="email1" value="<?php echo $result[1]; ?>">
                                            </div>
                                            <div class="form-group input-group">
                                                <span class="input-group-addon">網帳Email-2</span>
                                                <input type="text" class="form-control" placeholder="網帳Email-2"
                                                       name="email2" value="<?php echo $result[2]; ?>">
                                            </div>
                                            <div class="form-group input-group">
                                                <span class="input-group-addon">網帳Email-3</span>
                                                <input type="text" class="form-control" placeholder="網帳Email-3"
                                                       name="email3" value="<?php echo $result[3]; ?>">
                                            </div>
                                            <div class="form-group input-group">
                                                <span class="input-group-addon">網帳Email-4</span>
                                                <input type="text" class="form-control" placeholder="網帳Email-4"
                                                       name="email4" value="<?php echo $result[4]; ?>">
                                            </div>
                                            <div class="form-group input-group">
                                                <span class="input-group-addon">網帳Email-5</span>
                                                <input type="text" class="form-control" placeholder="網帳Email-5"
                                                       name="email5" value="<?php echo $result[5]; ?>">
                                            </div>

                                            <button type="submit" class="btn btn-success"
                                                    onclick="return confirm('確定要送出?');">送出
                                            </button>
                                            <button type="reset" class="btn btn-warning">重設</button>
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
