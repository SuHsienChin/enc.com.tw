<?php
session_start();

header("Content-Type:text/html; charset=utf-8");
// 藉由含括子系統的設定檔，取得網站及子系統的各種設定
include_once('appConfig.php');
// 引入資料庫
include_once(INCLUDE_DIR . 'db.php');

//權限
include_once('class/ClassAdmin.php');

//使用者
include_once('class/ClassUser.php');

//使用者對應menu
include_once('class/Class_users_sidebar.php');

//取得日期
$getdate = date('Y-m-d');

//列出權限
$obj = new ClassAdmin();
$uobj = new ClassUser();
$usobj = new Class_users_sidebar();

$result = $obj->select();

//md5($password);//加密


if (isset($_POST['submit'])) {


    //新增到users 表格
    try {
        $db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_DATABASE, DB_USER, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        /*** echo a message saying we have connected ***/
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

    $update_sql = "UPDATE users SET name='" . $_POST['name'] . "', account='" . $_POST['account'] . "'";
    $update_sql .= ", pwd='" . md5($_POST['pwd']) . "',flag='" . $_POST['flag'] . "'";
    $update_sql .= " WHERE id='" . $_GET['uid'] . "'";


    $st = $db->prepare($update_sql);
    $st->execute();

    //刪除 關聯表 users_sidebar WHERE users.id

    $de_sql = "DELETE FROM users_sidebar WHERE userId='" . $_GET['uid'] . "'";
    $de = $db->prepare($de_sql);
    $de->execute();
    //選取權限
    $arr = array();
    $arr = $_POST['purview'];
    foreach ($arr as $k => $v) {
        //新增到users_sidebar表格
        $usobj->userId = $_GET['uid'];
        $usobj->sidebarId = $v;
        $usobj->Add();
    }

    echo "<script>alert('新增更新');</script>";
    echo "<script>document.location.href=\"account.php\";</script>";
    exit;

} else {
    //取得users資料
    $uobj->id = $_GET['uid'];
    $ure = $uobj->Retrieve();

    //取得 使用者權限 資料
    try {
        $db2 = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_DATABASE, DB_USER, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    $us_sql = "SELECT adminsidebar.id,adminsidebar.name,users_sidebar.userId,users_sidebar.sidebarId FROM adminsidebar,users_sidebar WHERE adminsidebar.id=users_sidebar.sidebarId AND adminsidebar.parentId='0' AND users_sidebar.userId='" . $_GET['uid'] . "'";
    $us_si = $db2->prepare($us_sql);
    $us_si->execute();
    $us_arr = array();

    while ($us_re = $us_si->fetch(PDO::FETCH_ASSOC)) {
        array_push($us_arr, $us_re['sidebarId']);
    }

    //print_r($us_re);
    /* 搜尋 回傳值 有沒有在陣列裡 ps:目前用不到
    foreach($us_re as $row) {
        if ( in_array( '後台管理者帳號管理', $row  ) ) { echo "WAHOO"; }
    }
    */


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
                    <h4 class="page-header"><a href="account.php">帳號管理</a>>編輯帳號</h4>
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
                                        <form role="form" method="post">
                                            <div class="form-group input-group">
                                                <span class="input-group-addon">名稱</span>
                                                <input type="text" class="form-control" placeholder="名稱" name="name"
                                                       value="<?php echo $ure['name']; ?>">
                                            </div>
                                            <div class="form-group input-group">
                                                <span class="input-group-addon">帳號</span>
                                                <input type="text" class="form-control" placeholder="帳號" name="account"
                                                       id="account" value="<?php echo $ure['account']; ?>">
                                            </div>
                                            <div class="form-group input-group">
                                                <span class="input-group-addon">密碼</span>
                                                <input type="password" class="form-control" placeholder="密碼" name="pwd"
                                                       value="<?php echo $ure['pwd']; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>狀態</label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="flag" id="optionsRadiosInline1"
                                                           value="1" <?php if ($ure['flag'] == 1) echo "checked"; ?>>啟用
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="flag" id="optionsRadiosInline2"
                                                           value="0" <?php if ($ure['flag'] == 0) echo "checked"; ?>>停用
                                                </label>

                                            </div>
                                            <div class="form-group">
                                                <label>權限：</label>
                                                <br/>
                                                <label>全選<input type="checkbox" id="checkAll"></label>
                                                <ul style="list-style:none; width:100%;">

                                                    <?php

                                                    foreach ($result as $item) {
                                                        ?>
                                                        <li style="float:left; width:300px;">
                                                            <?php
                                                            if (in_array($item['id'], $us_arr)) {
                                                                echo "<input name=\"purview[]\" type=\"checkbox\" value=" . $item['id'] . " checked>" . $item['name'] . "";
                                                            } else {
                                                                echo "<input name=\"purview[]\" type=\"checkbox\" value=" . $item['id'] . " >" . $item['name'] . "";
                                                            }
                                                            ?>
                                                        </li>
                                                    <?php
                                                    }
                                                    ?>


                                                </ul>
                                            </div>
                                            <div class="form-group input-group" style="width: 100%;">

                                            </div>
                                            <div class="form-group input-group" style="width: 100%;">
                                                <span class="input-group-addon">建檔人員</span>
                                                <input type="text" class="form-control" placeholder="建檔人員"
                                                       name="creatOwner" value="<?php echo $ure['creatOwner']; ?>"
                                                       readonly>
                                            </div>
                                            <div class="form-group input-group">
                                                <span class="input-group-addon">建檔日期</span>
                                                <input type="text" class="form-control" placeholder="建檔日期"
                                                       value="<?php echo $ure['creatDate']; ?>" readonly>
                                            </div>
                                            <!--
                                            <div class="form-group input-group">
                                                <span class="input-group-addon">修改人員</span>
                                                <input type="text" class="form-control" placeholder="修改人員" readonly>
                                            </div>
                                            <div class="form-group input-group">
                                                <span class="input-group-addon">修改日期</span>
                                                <input type="text" class="form-control" placeholder="修改日期" readonly>
                                            </div>
                                            -->
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

<!-- Bootstrap Core JavaScript -->
<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

<!-- Custom Theme JavaScript -->
<script src="../dist/js/sb-admin-2.js"></script>

<script>
    //checkbox全選
    $("#checkAll").on("click", function () {
        if ($(this).prop("checked") === true) {
            $("input[name='purview[]']").prop("checked", $(this).prop("checked"));
            $('#example tbody tr').addClass('selected');
        } else {
            $("input[name='purview[]']").prop("checked", false);
            $('#example tbody tr').removeClass('selected');
        }
    });

    $(function () {
        //檢查帳號是否有重覆
        $('#account').blur(function () {
            var account = $('#account').val();
            $.ajax({
                url: 'ajax/account.php',
                catch: false,
                dataType: 'json',
                type: 'GET',
                data: {
                    account: account,
                    mode: "check"
                },
                error: function (xhr) {
                    alert('Ajax request 發生錯誤');
                },
                success: function (data) {
                    //0:國家代碼存在
                    if (data == "0") {
                        alert('帳號存在，請重新輸入');
                        $('#account').val("");
                        $('#account').focus();
                    } else {

                    }

                }
            });
        });

    })

</script>


</body>

</html>
