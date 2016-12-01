<?php
session_start();
header("Content-Type:text/html; charset=utf-8");


ini_set('display_errors','1');
ini_set('display_startup_errors','1');
error_reporting(E_ALL);
// 藉由含括子系統的設定檔，取得網站及子系統的各種設定
include_once('../inc/webConfig.php');
// 引入資料庫
include('../inc/db.php');
// Users類別
include('class/ClassUsers.php');

include_once('class/pageadd.php');


$dbClass = new Database();
$dbh = $dbClass->getDb();
$users = new users($dbh);


if ($_POST) {

    $account = $_POST['account'];
    $pwd = md5($_POST['pwd']);

    $login = $users->login($account, $pwd);

    if ($login === false) {
        $errors[] = '帳號或密碼錯誤!\n\n請洽管理員' ;
        echo "<script>alert('" . $errors[0] . "');</script>";
    } else {
        //登入成功存入session
        $_SESSION['userId'] = $login['id'];//使用者id
        $_SESSION['account'] = $login['account'];//使用者帳號
        $_SESSION['name'] = $login['name'];//使用者名稱

        //搜尋權限並把可存取的頁面 存入 陣列 再存到session
        //資料庫連線
        try {
            $db = new PDO("mysql:host=".DB_HOST.";dbname=".DB_DATABASE, DB_USER, DB_PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
        $arr = array();
        array_push($arr,"main.php");
        $sql = "SELECT * FROM adminsidebar,users_sidebar WHERE adminsidebar.id=users_sidebar.sidebarId AND users_sidebar.userId = '".$login['id']."' AND adminsidebar.parentId='0' ";
        $p = $db->prepare($sql);
        $p->execute();
        $r = $p->fetchAll(PDO::FETCH_ASSOC);

        foreach ($r as $item) {
            if($item['url']<>""){
                array_push($arr,$item['url']);
            }else{
                $sql = "SELECT url FROM adminsidebar WHERE parentId = '".$item['sidebarId']."'";
                $c = $db->prepare($sql);
                $c->execute();
                $re=$c->fetchAll(PDO::FETCH_ASSOC);

                foreach ($re as $it) {
                    array_push($arr,$it['url']);
                }

            }

        }

        addpage($arr);




        echo "<script>alert('登入成功');</script>";
        //登入成功轉址
        echo "<script>document.location.href=\"main.php\";</script>";
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include('layout/head.php'); ?>

<body>

<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">維德國際-後台登入</h3>
                </div>
                <div class="panel-body">
                    <form role="form" action="" method="post">
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="帳號" name="account" autofocus>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="密碼" name="pwd" type="password" value="">
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input name="remember" type="checkbox" value="RememberMe">記得我
                                </label>
                            </div>
                            <!-- Change this to a button or input when using this as a form -->
                            <button class="btn btn-lg btn-success btn-block" type="submit" formmethod="post">登入</button>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

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