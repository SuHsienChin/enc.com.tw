<?php
session_start();
header("Content-Type:text/html; charset=utf-8");
// 藉由含括子系統的設定檔，取得網站及子系統的各種設定
include_once('appConfig.php');
// 引入資料庫
include_once(INCLUDE_DIR . 'db.php');

include_once('class/Classdlf.php');
include_once('class/Classdlc.php');

//產生物件
$obj = new Classdlc();

//呼叫 getRecordset 取資料
$recordset = $obj->select();

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
                    <h3 class="page-header">檔案管理</h3>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <a href="dlfAdd.php" class="btn btn-success">新增</a>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <div class="form-group">
                                    <label>選擇類別</label>
                                    <select class="form-control" name="cId" id="cid">
                                        <option value="" disabled selected>請選擇</option>
                                        <?php
                                        foreach ($recordset as $item) {
                                            echo "<option value=\"" . $item['id'] . "\">" . $item['title'] . "</option>\n";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <table class="table table-striped table-bordered table-hover" id="dataTables"
                                       style="word-break:break-all; ">
                                    <thead>
                                    <tr>
                                        <th width="10%">#</th>
                                        <th width="60%">標題</th>
                                        <th width="15%" align="center">編輯</th>
                                        <th width="15%" align="center">刪除</th>
                                    </tr>
                                    </thead>
                                    <tbody id="dllist">

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
        var table = $('#dataTables').DataTable({
            responsive: true,
            lengthChange: false,//顯示數量
            ordering: false,//排序功能
            searching: false, //不顯示搜尋列
            oLanguage: {
                "sLengthMenu": "顯示 _MENU_ 筆記錄",
                "sZeroRecords": "無符合資料",
                "sInfo": "目前記錄：_START_ 至 _END_, 總筆數：_TOTAL_",
                "sInfoEmpty": "",
                "oPaginate": {
                    "sFirst": "首頁",
                    "sPrevious": "上頁",
                    "sNext": "下頁",
                    "sLast": "尾頁"
                },

                bStateSave: true
            }
        });

        $('#cid').change(function () {
            getDatatable();
        });

        //刪除
        $('#dllist').on('click', '.delbtn', function () {
            if (confirm('確定刪除?')) {
                var $id = $(this).attr('rel');
                var $filename = $(this).attr('alt');
                deldata($id, $filename);
            } else {
                return false;
            }

        });

        //顯示
        function getDatatable() {
            $.ajax({
                url: 'ajax/file.php',
                catch: false,
                dataType: 'html',
                type: 'POST',
                data: {
                    cId: $('#cid option:selected').val(),
                    mode: "read"
                },
                error: function (xhr) {
                    alert('Ajax request 發生錯誤');
                },
                success: function (data) {
                    $('#dllist').html(data);
                }
            });
        }

        //刪除
        function deldata(id, filename) {
            $.ajax({
                url: 'ajax/file.php',
                catch: false,
                dataType: 'html',
                type: 'POST',
                data: {
                    id: id,
                    filename: filename,
                    mode: "del"
                },
                error: function (xhr) {
                    alert('Ajax request 發生錯誤');
                },
                success: function (data) {
                    getDatatable();
                    alert('刪除成功');
                }
            });
        }

        //checkbox全選
        $("#checkAll").on("click", function () {
            if ($(this).prop("checked") === true) {
                $("input[name='checkList']").prop("checked", $(this).prop("checked"));
                $('#example tbody tr').addClass('selected');
            } else {
                $("input[name='checkList']").prop("checked", false);
                $('#example tbody tr').removeClass('selected');
            }
        });
    });
</script>
</body>

</html>
