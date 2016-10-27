<?php
/**
 * Created by PhpStorm.
 * User: MayumiKing
 * Date: 2016/2/24
 * Time: 下午 08:50
 */

header("Content-Type:text/html; charset=utf-8");

// 藉由含括子系統的設定檔，取得網站及子系統的各種設定
include_once('../../inc/webConfig.php');
// 引入資料庫
include_once(INCLUDE_DIR . 'db.php');

include_once('../class/ClassArticle.php');
$obj = new ClassArticle();

switch ($_POST['mode']) {
    //新增
    case "add":
        //$this->id = $_POST['id'];
        $obj->countryCode = $_POST['countryCode'];
        $obj->countryName = $_POST['countryName'];
        $obj->PicUrl = $_POST['PicUrl'];
        $obj->branchCode = $_POST['branchCode'];
        $obj->branchName = $_POST['branchName'];
        $obj->title = $_POST['title'];
        $obj->content = $_POST['content'];

        if ($obj->Add()) {
            echo json_encode("success");
        } else {
            echo json_encode("false");
        }
        break;
    case "update":
        $obj->id = $_POST['id'];
        $obj->countryCode = $_POST['countryCode'];
        $obj->countryName = $_POST['countryName'];
        $obj->PicUrl = $_POST['PicUrl'];
        $obj->branchCode = $_POST['branchCode'];
        $obj->branchName = $_POST['branchName'];
        $obj->title = $_POST['title'];
        $obj->content = $_POST['content'];

        if ($obj->update()) {
            echo json_encode("success");
        } else {
            echo json_encode("false");
        }
        break;

    case "read":
        $obj->branchCode = $_POST['branchCode'];
        $result = $obj->selectClass();
        //print_r($result);
        $count = count($result);
        for ($i = 0; $i < $count; $i++) {
            echo "<tr>\n";
            //echo "<td><input type=\"checkbox\" name=\"checkList\" value=\"" . $result[$i]['id'] . "\"></td>\n";
            echo "<td>" . $result[$i]['id'] . "</td>\n";
            echo "<td>" . $result[$i]['countryName'] . "</td>\n";
            echo "<td>" . $result[$i]['title'] . "</td>\n";
            echo "<td><a href=\"#\" class=\"btn btn-info btn-circle editarticlebtn1\" rel=\"".$result[$i]['id']."\" data-target=\"#editmyarticle\" data-toggle=\"modal\"><i class=\"glyphicon glyphicon-edit\"></i></a></td>\n";
            //echo "<td><a href=\"articleEdit.php?id=" . $result[$i]['id'] . "\" class=\"btn btn-info btn-circle\"><i class=\"glyphicon glyphicon-edit\"></i></a></td>\n";
            echo "<td><a href=\"#\" class=\"btn btn-danger btn-circle delbtn\" rel=\"" . $result[$i]['id'] . "\"><i class=\"glyphicon glyphicon-remove\"></a></td>\n";
            echo "</tr>\n";
        }

        break;

    case "readById":
        $obj->id = $_POST['id'];
        try{
            $result = $obj->Retrieve();
            echo json_encode($result);
        }catch (PDOException $e){
            echo "error";
        }

        break;

    case "del":
        $obj->id = $_POST['id'];


        if ($obj->Del()) {
            return json_encode('success');
        } else {
            return json_encode('false');
        }

        break;

}



