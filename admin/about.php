<?php
session_start();

header("Content-Type:text/html; charset=utf-8");
// 藉由含括子系統的設定檔，取得網站及子系統的各種設定
include_once('appConfig.php');
// 引入資料庫
include_once(INCLUDE_DIR . 'db.php');

include_once('class/ClassAbout.php');

//產生物件
$obj = new ClassAbout();

//呼叫 getRecordset 取資料
$recordset = $obj->select();


?>
<!DOCTYPE html>
<html lang="en">
<!-- 引入head檔 -->
<?php include('layout/uploadHead.php'); ?>
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
                    <h3 class="page-header">關於我們管理</h3>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <a href="aboutAdd.php" class="btn btn-success">新增</a><label style="float: right;"> 點兩下編輯「排序」或「狀態」</label>
                        </div>
                        <div class="dataTable_wrapper">
                            <table class="table table-striped table-bordered table-hover" id="dataTables"
                                   style="word-break:break-all; ">
                                <thead>
                                <tr>
                                    <th width="10%">#</th>
                                    <th width="50%">標題</th>
                                    <th width="10%">排序</th>
                                    <th width="10%">狀態</th>
                                    <th width="10%">編輯</th>
                                    <th width="10%">刪除</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $arr = array();
                                $i = 1;
                                foreach ($recordset as $record) {
                                    $arr["$i"]="$i";
                                    ?>
                                    <tr id="<?php echo $record['id'];?>">
                                        <td><?php echo $record['id'];//echo (count($recordset) > 0) ? "<input type=\"checkbox\" value=\"" . $record['id'] . "\">" : ""; ?></td>
                                        <td><?php echo $record['title']; ?></td>
                                        <td class="sort" field="aboutsort"><?php echo $record['sort']; ?></td>
                                        <td align="center" class="status" field="aboutstatus"><?php
                                            if ($record['flag'] == 1) {
                                                echo "<i id=\"iflag\" class=\"fa fa-check\"></i>";
                                            } else {
                                                echo "<i id=\"iflag\" class=\"fa fa-times\"></i>";
                                            }
                                            ?></td>

                                        <td align="center"><a href="aboutEdit.php?id=<?php echo $record['id']; ?>"
                                               class="btn btn-info btn-circle"><i class="glyphicon glyphicon-edit"></i></a>
                                        </td>
                                        <td align="center"><a href="aboutDel.php?id=<?php echo $record['id']; ?>"
                                               onclick="return confirm('確定要刪除?');" class="btn btn-danger btn-circle"><i
                                                    class="glyphicon glyphicon-remove"></i></a></td>
                                    </tr>
                                <?php
                                    $i++;
                                }
                                $i+1;
                                $arr["$i"]="$i";
                                ?>
                                </tbody>
                            </table>
                        </div>
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

<!-- 即時編輯表格 -->
<script src="js/jquery.jeditable.js"></script>

<script>
    $(function () {
        $(".sort").editable("ajax/edittable.php", {
            event: 'dblclick',
            tooltip: '點兩下編輯...',
            indicator: '存檔中...',
            submit: '確定',
            onblur: 'ignore',// 『cancle』：編輯框消息不做任何修改；『submit』：送出，等於按了送出鈕；『ignore』:不做任何修改，編輯框還在。
            type: 'select',//顯示下拉選單
            //loadurl:'ajax/sort_about.php',
            data:'<?php print json_encode($arr);?>',
            submitdata: function (value, settings) {
                $("#tip").text(
                    "id=" + $(this).parent().attr('id') + "&" +
                    "field=" + $(this).attr('field') + "&" +
                    "oldvalue=" + value
                );
                return {id: $(this).parent().attr('id'), field: $(this).attr('field'), oldvalue: value};
            },
            callback: function (value, settings) {

                alert('更新排序成功');
            }
        });

        $(".status").editable("ajax/edittable.php", {
            event: 'dblclick',
            tooltip: '點兩下編輯...',
            indicator: '存檔中...',
            submit: '確定',
            onblur: 'ignore',// 『cancle』：編輯框消息不做任何修改；『submit』：送出，等於按了送出鈕；『ignore』:不做任何修改，編輯框還在。
            type: 'select',//顯示下拉選單
            data:{'1':'上架', '0':'下架'},
            submitdata: function (value, settings) {

                return {id: $(this).parent().attr('id'), field: $(this).attr('field'), oldvalue: value};
            },
            callback: function (value, settings) {
                alert('更新成功');


            }
        });

    })
</script>

</body>

</html>


