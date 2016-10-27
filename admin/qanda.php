<?php
session_start();
header("Content-Type:text/html; charset=utf-8");
// 藉由含括子系統的設定檔，取得網站及子系統的各種設定
include_once('appConfig.php');
// 引入資料庫
include_once(INCLUDE_DIR . 'db.php');

include_once('class/ClassQandA.php');
include_once('class/ClassQandAClass.php');


//產生物件
$cobj = new ClassQandAClass();
//呼叫 取資料
$result = $cobj->select();
try {
    $db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_DATABASE, DB_USER, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

} catch (PDOException $e) {
    echo $e->getMessage();
}
if (isset($_POST['cscs'])) {
    try {
        $sql = "SELECT qandaclass.name as className,qandaclass.id,qanda.id,qanda.classId,qanda.name,qanda.content,qanda.sort,qanda.flag FROM qandaclass,qanda WHERE qandaclass.id=qanda.classId AND classId='" . $_POST['cscs'] . "'";
        $st = $db->prepare($sql);
        $st->execute();
        $cre = $st->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {

    }
} else {
    try {
        $sql = "SELECT qandaclass.name as className,qandaclass.id,qanda.id,qanda.classId,qanda.name,qanda.content,qanda.sort,qanda.flag FROM qandaclass,qanda WHERE qandaclass.id=qanda.classId AND id='0'";
        $st = $db->prepare($sql);
        $st->execute();
        $cre = $st->fetchAll(PDO::FETCH_ASSOC);
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
                    <h3 class="page-header">Q&A 管理</h3>

                    <div class="panel panel-default">

                        <div class="panel-heading">

                            <a href="qandaAdd.php" class="btn btn-success">新增</a>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <label> 請選擇類別名稱</label><label style="float: right;"> 點兩下編輯「排序」或「狀態」</label>

                                <form name="Form1" method="POST">
                                    <select name="cscs" OnChange="Form1.submit()">
                                        <option value="">請選擇</option>
                                        <?php

                                        foreach ($result as $citem) {


                                            if ($_POST['cscs'] == $citem['id']) {
                                                echo "<option value='" . $citem['id'] . "' selected>" . $citem['name'] . "</option>";
                                            } else {
                                                echo "<option value='" . $citem['id'] . "'>" . $citem['name'] . "</option>";
                                            }

                                        }
                                        ?>
                                    </select>
                                </form>
                                <br/>
                                <br/>
                                <table class="table table-striped table-bordered table-hover" id="dataTables"
                                       style="word-break:break-all; ">
                                    <thead>
                                    <tr>

                                        <th>類別</th>
                                        <th>名稱</th>
                                        <th>排序</th>
                                        <th>狀態</th>
                                        <th>編輯</th>
                                        <th>刪除</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $arr = array();
                                    $i = 1;
                                    foreach ($cre as $record) {
                                        $arr["$i"] = "$i";
                                        ?>
                                        <tr id="<?php echo $record['id']; ?>">
                                            <!--<td width="10%"><?php /*echo $record['id'];//echo (count($cre) > 0) ? "<input type=\"checkbox\" value=\"" . $record['id'] . "\">" : ""; */?></td>-->
                                            <td width="30%"><?php echo $record['className']; ?></td>
                                            <td width="40%"><?php echo $record['name']; ?></td>
                                            <td width="10%" class="sort"
                                                field="qasort"><?php echo $record['sort']; ?></td>
                                            <td width="10%" class="status" field="qastatus">
                                                <?php
                                                if ($record['flag'] == 1) {
                                                    echo "<i class=\"fa fa-check\"></i>";
                                                } else {
                                                    echo "<i class=\"fa fa-times\"></i>";
                                                }
                                                ?>
                                            </td>
                                            <td width="10%"><a
                                                    href="qandaEdit.php?id=<?php echo $record['id']; ?>"
                                                    class="btn btn-info btn-circle"><i
                                                        class="glyphicon glyphicon-edit"></i></a></td>
                                            <td width="10%"><a
                                                    href="qandaDel.php?id=<?php echo $record['id']; ?>"
                                                    onclick="return confirm('確定要刪除?');"
                                                    class="btn btn-danger btn-circle"><i
                                                        class="glyphicon glyphicon-remove"></a></td>
                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                    $i + 1;
                                    $arr["$i"] = "$i";
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

<!-- 即時編輯表格 -->
<script src="js/jquery.jeditable.js"></script>

<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
    $(function () {
        $('#dataTables').DataTable({
            responsive: true,
            searching: false, //不顯示搜尋列
            oLanguage: {
                "sLengthMenu": "顯示 _MENU_ 筆記錄",
                "sZeroRecords": "無符合資料",
                "sInfoEmpty": "",
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

        $(".sort").editable("ajax/edittable.php", {
            event: 'dblclick',
            tooltip: '點兩下編輯...',
            indicator: '存檔中...',
            submit: '確定',
            onblur: 'ignore',// 『cancle』：編輯框消息不做任何修改；『submit』：送出，等於按了送出鈕；『ignore』:不做任何修改，編輯框還在。
            type: 'select',//顯示下拉選單
            //loadurl:'ajax/sort_about.php',
            data: '<?php print json_encode($arr);?>',
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
