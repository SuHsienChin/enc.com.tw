<?php
session_start();
header("Content-Type:text/html; charset=utf-8");
// 藉由含括子系統的設定檔，取得網站及子系統的各種設定
include_once('appConfig.php');
// 引入資料庫
include_once(INCLUDE_DIR . 'db.php');

try {
    $db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_DATABASE, DB_USER, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

} catch (PDOException $e) {
    echo $e->getMessage();
}

try {
    $sql = "SELECT * FROM articles WHERE id='".$_GET['id']."'";
    $st = $db->prepare($sql);
    $st->execute();
    $result = $st->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {

}

//取國家
try{
    $sql = "SELECT * FROM country";
    $st = $db->prepare($sql);
    $st->execute();
    $couresult = $st->fetchAll(PDO::FETCH_ASSOC);

}catch(PDOException $e){

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
                        <h3 class="page-header">編輯文章</h3>
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
                                            <!-- .panel-heading -->

                                            <div class="panel-body" id="panel-body">
                                                <div class="panel-group" id="accordion">
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                第一步
                                                            </h4>
                                                        </div>
                                                        <div id="collapseOne" class="panel-collapse collapse in">
                                                            <div class="panel-body">
                                                                選擇館別
                                                                <select name="branch" id="branch" class="form-control">
                                                                    <option value="E" <?php if($result['branchCode']=="E")echo "selected"?>>移民館</option>
                                                                    <option value="L" <?php if($result['branchCode']=="L")echo "selected"?>>留學館</option>
                                                                    <option value="G" <?php if($result['branchCode']=="G")echo "selected"?>>中學館</option>
                                                                    <option value="W" <?php if($result['branchCode']=="W")echo "selected"?>>文學館</option>
                                                                </select>
                                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" id="addNext1"
                                                                   class="btn btn-success">下一步</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                第二步
                                                            </h4>
                                                        </div>
                                                        <div id="collapseTwo" class="panel-collapse collapse">
                                                            <div class="panel-body">
                                                                <label>館別：</label><label class="branchTxt" style="color:red;"></label>
                                                                <br/><br/>
                                                                <label>選擇國家</label>

                                                                <select name="country" id="country" class="form-control">
                                                                    <?php
                                                                    foreach($couresult as $item){
                                                                        if($result['countryCode'] == $item['code']){
                                                                            echo "<option value=\"".$item['code']."\" selected data-imagesrc=\"".$item['picUrl']."\">".$item['name']."</option>";
                                                                        }else{
                                                                            echo "<option value=\"".$item['code']."\" data-imagesrc=\"".$item['picUrl']."\">".$item['name']."</option>";
                                                                        }

                                                                    }
                                                                    ?>
                                                                </select>

                                                                <br/>
                                                                <br/>

                                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree"
                                                                   class="btn btn-success" id="addNext2">下一步</a>
                                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"
                                                                   class="btn btn-warning">回上一步</a>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                最後一步
                                                            </h4>
                                                        </div>
                                                        <div id="collapseThree" class="panel-collapse collapse">
                                                            <div class="panel-body">
                                                                <table width="100%" class="table table-striped table-bordered table-hover">
                                                                    <tr>
                                                                        <td>館別</td>
                                                                        <td><label class="branchTxt" style="color:red;"></label></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>國家</td>
                                                                        <td><label class="countryTxt" style="color:red;"></label></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>文章<br />標題</td>
                                                                        <td><input class="form-control" name="title" id="title" value="<?php echo $result['title']; ?>"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>文章<br />內容</td>
                                                                        <td id="area">
                                                                            <textarea cols="10" id="content" rows="10"><?php echo $result['content']; ?></textarea>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td></td>
                                                                        <td>
                                                                            <input type="hidden" id="artid" value="<?php echo $result['id']; ?>">
                                                                            <a data-toggle="collapse" data-parent="#accordion" href="#"
                                                                               class="btn btn-success" id="updateArticle"
                                                                               onclick="return confirm('確定更新?');">更新</a>
                                                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"
                                                                               class="btn btn-warning">回上一步</a>

                                                                        </td>
                                                                    </tr>
                                                                </table>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- .panel-body -->
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
    <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

    <script>

        $(function () {



            //新增文章 顯示第二步
            $('#addNext1').click(function () {
                if ($('#branch option:selected').val() == "") {
                    alert('請選擇館別');
                    return false;
                } else {

                    $('.branchTxt').text($('#branch option:selected').text());
                }
            });

            //新增文章 顯示最後一步
            $('#addNext2').click(function () {
                $('.countryTxt').text($('#country option:selected').text());
            });

            $('#updateArticle').click(function () {
                for (instance in CKEDITOR.instances)
                    CKEDITOR.instances[instance].updateElement();

                $.ajax({
                    url: 'ajax/article.php',
                    catch: false,
                    dataType: 'json',
                    type: 'POST',
                    data: {
                        id:$('#artid').val(),
                        branchName: $('#branch option:selected').text(),
                        branchCode: $('#branch option:selected').val(),
                        countryName: $('#country option:selected').text(),
                        countryCode: $('#country option:selected').val(),
                        PicUrl: $('#country option:selected').attr("data-imagesrc"),
                        title: $('#title').val(),
                        content: $('#content').val(),
                        mode: "update"
                    },
                    error: function (xhr) {
                        alert('Ajax request 發生錯誤');
                    },
                    success: function (data) {
                        alert('更新成功');
                        document.location.href="article.php";
                    }
                });
            });

        });


    </script>

    </body>

    </html>
<?php
include_once "ckeditor/ckeditor.php";
$CKEditor = new CKEditor();
$CKEditor->basePath = 'ckeditor/';
$CKEditor->replace("content");
?>
