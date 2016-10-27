<?php
session_start();
header("Content-Type:text/html; charset=utf-8");
// 藉由含括子系統的設定檔，取得網站及子系統的各種設定
include_once('appConfig.php');
// 引入資料庫
include_once('../inc/db.php');
// Users類別
include_once('class/Classdlc.php');
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
                    <h3 class="page-header">下載檔案管理</h3>

                    <div class="col-lg-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <a href="accountAdd.php">新增類別</a>
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>名稱</th>
                                            <th>編輯</th>
                                            <th>刪除</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $dbClass = new Database();
                                        $dbh = $dbClass->getDb();
                                        $users = new users($dbh);

                                        $dataset = $users->readAll();
                                        foreach ($dataset as $row) {
                                            ?>
                                            <tr>
                                                <td><?php echo $row['userId']; ?></td>
                                                <td><?php echo $row['userAccount']; ?></td>
                                                <td><?php echo $row['userPassword']; ?></td>
                                                <td><?php echo $row['userFlag']; ?></td>
                                                <td><a href="accountEdit.php?uid=<?php echo $row['userId']; ?>">編輯</a>
                                                </td>
                                                <td><a href="accountDel.php?uid=<?php echo $row['userId']; ?>"
                                                       onclick="return confirm('確定要刪除?');">刪除</a></td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                    </div>

                </div>
                <!-- /.col-lg-12 -->
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
