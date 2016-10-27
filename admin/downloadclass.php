<?php
session_start();
header("Content-Type:text/html; charset=utf-8");
// 藉由含括子系統的設定檔，取得網站及子系統的各種設定
include_once('appConfig.php');
// 引入資料庫
include_once(INCLUDE_DIR . 'db.php');

include_once('class/Classdlc.php');

//產生物件
$obj = new Classdlc();

//呼叫 getRecordset 取資料
$recordset = $obj->select();
$output = '';

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
                    <h3 class="page-header">檔案下載類別管理</h3>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <a href="dlclassAdd.php" class="btn btn-success">新增</a>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="dataTables"
                                       style="word-break:break-all; ">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>標題</th>
                                        <th>編輯</th>
                                        <th>刪除</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach ($recordset as $record) {
                                        ?>
                                        <tr>
                                            <td width="10%"><?php echo $record['id'];//echo (count($recordset) > 0) ? "<input type=\"checkbox\" value=\"" . $record['id'] . "\">" : ""; ?></td>
                                            <td width="50%"><?php echo $record['title']; ?></td>
                                            <td width="10%" align="center"><a href="dlEdit.php?id=<?php echo $record['id']; ?>"
                                                                              class="btn btn-info btn-circle"><i class="glyphicon glyphicon-edit"></i></a></td>
                                            <td width="10%" align="center"><a href="dlDel.php?id=<?php echo $record['id']; ?>"
                                                                              onclick="return confirm('確定要刪除? \n此操作將會連下載檔案一併刪除!');"
                                                                              class="btn btn-danger btn-circle"><i class="glyphicon glyphicon-remove"></i></a></td>
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

<!-- DataTables JavaScript -->
<script src="../bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
    $(document).ready(function () {
        $('#dataTables').DataTable({
            responsive: true,
            searching: false, //不顯示搜尋列
            oLanguage: {
                "sLengthMenu": "顯示 _MENU_ 筆記錄",
                "sZeroRecords": "無符合資料",
                "sInfo": "目前記錄：_START_ 至 _END_, 總筆數：_TOTAL_",
                "oPaginate": {
                    "sFirst": "首頁",
                    "sPrevious": "上頁",
                    "sNext": "下頁",
                    "sLast": "尾頁"
                },
                bStateSave: true
            }
        });
    });
</script>
</body>

</html>
