<?php
session_start();
header("Content-Type:text/html; charset=utf-8");
// 藉由含括子系統的設定檔，取得網站及子系統的各種設定
include_once('appConfig.php');
// 引入資料庫
include_once('../inc/db.php');
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
<h3 class="page-header">各館文章管理</h3>
<!-- /.panel-heading -->
<div class="panel-body">
<!-- Nav tabs -->
<ul class="nav nav-tabs">
    <li class="active"><a href="#home" data-toggle="tab">文章管理</a>
    </li>
    <li><a href="#profile" data-toggle="tab">新增文章</a>
    </li>
    <li><a href="#messages" data-toggle="tab" id="editcountry">編輯國家</a></li>
    <li><a href="#settings" data-toggle="tab" id="sortcountry">編輯國家排序</a></li>

</ul>

<!-- Tab panes -->
<div class="tab-content">
<div class="tab-pane fade in active" id="home">
    <div class="dataTable_wrapper">
        選擇館別
        <select name="branch1" id="branch1" class="form-control">
            <option value="" selected disabled>請選擇</option>
            <option value="E">移民館</option>
            <option value="L">留學館</option>
            <option value="G">中學館</option>
            <option value="W">語言館</option>
        </select>
        <table class="table table-striped table-bordered table-hover" id="dataTables"
               style="word-break:break-all; ">
            <thead>
            <tr>
                <th width="10%">#</th>
                <th width="20%">國家</th>
                <th width="50%">標題</th>
                <th width="10%">編輯</th>
                <th width="10%">刪除</th>
            </tr>
            </thead>
            <tbody id="articleData">


            </tbody>
        </table>
    </div>
    <!-- /.table-responsive -->

    <!-- Edit 文章 -->
    <form method="post">
        <div class="modal fade" id="editmyarticle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"
                                aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">編輯文章</h4>
                    </div>
                    <div class="modal-body">
                        <div class="panel-body" id="panel-body">
                            <div class="panel-group" id="editaccordion">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            第一步
                                        </h4>
                                    </div>
                                    <div id="editcollapseOne" class="panel-collapse collapse in">
                                        <div class="panel-body">
                                            選擇館別
                                            <select name="editbranch" id="editbranch" class="form-control">
                                                <option value="E">移民館</option>
                                                <option value="L">留學館</option>
                                                <option value="G">中學館</option>
                                                <option value="W">語言館</option>
                                            </select>
                                            <a data-toggle="collapse" data-parent="#editaccordion"
                                               href="#editcollapseTwo"
                                               id="editNext1"
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
                                    <div id="editcollapseTwo" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <label>館別：</label><label class="branchTxt" style="color:red;"></label>
                                            <br/><br/>
                                            <label>選擇國家</label>
                                            <select name="editcountryddl" id="editcountryddl"
                                                    class="form-control country">
                                            </select>

                                            <br/>
                                            <br/>


                                            <a data-toggle="collapse" data-parent="#editaccordion"
                                               href="#editcollapseThree"
                                               class="btn btn-success" id="editNext2">下一步</a>
                                            <a data-toggle="collapse" data-parent="#editaccordion"
                                               href="#editcollapseOne"
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
                                    <div id="editcollapseThree" class="panel-collapse collapse">
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
                                                    <td>文章<br/>標題</td>
                                                    <td><input class="form-control" name="edittitle" id="edittitle">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>文章<br/>內容</td>
                                                    <td id="area">
                                                        <textarea cols="10" id="editcontent" class="editor"
                                                                  rows="10"></textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>
                                                        <input type="hidden" id="editid" value="">
                                                        <a data-toggle="collapse" data-parent="#editaccordion"
                                                           href="#editcollapseTwo"
                                                           class="btn btn-warning">回上一步</a>
                                                        <button type="button" class="btn btn-default"
                                                                data-dismiss="modal" id="editclosebtn">Close
                                                        </button>
                                                        <a href="#" class="btn btn-primary" id="editsavebtn"
                                                           name="editsavebtn">存檔</a>

                                                    </td>
                                                </tr>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">


                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </form>
    <!-- /.edit 文章 -->
</div>
<div class="tab-pane fade" id="profile">
    <div class="panel panel-default">

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
                                <option value="" selected disabled>請選擇</option>
                                <option value="E">移民館</option>
                                <option value="L">留學館</option>
                                <option value="G">中學館</option>
                                <option value="W">語言館</option>
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
                            <select name="country" id="country" class="form-control country">
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
                                    <td>文章<br/>標題</td>
                                    <td><input class="form-control" name="title" id="title"></td>
                                </tr>
                                <tr>
                                    <td>文章<br/>內容</td>
                                    <td id="area">
                                        <textarea cols="10" id="content" rows="10"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        <a data-toggle="collapse" data-parent="#accordion" href="#"
                                           class="btn btn-success" id="addArticle"
                                           onclick="return confirm('確定新增?');">新增文章</a>
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
    <!-- /.panel -->
</div>
<div class="tab-pane fade" id="messages">
    <div class="dataTable_wrapper">
        <br/>


        <!-- Button trigger modal -->
        <button class="btn btn-primary" data-toggle="modal" data-target="#myModal">
            新增
        </button>
        <!-- Add Modal -->
        <form method="post" action="countryAdd.php" enctype="multipart/form-data" name="FileForm" id="FileForm">
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"
                                    aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel">新增國家</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group input-group">
                                <span class="input-group-addon">國家名稱</span>
                                <input type="text" id="countryNametxt" name="countryname" class="form-control"
                                       placeholder="國家名稱">
                            </div>
                            <div class="form-group input-group">
                                <span class="input-group-addon">國家代碼(3碼)</span>
                                <input type="text" id="countryCodetxt" name="countrycode" class="form-control"
                                       placeholder="國家代碼" maxlength="3">
                            </div>
                            <div class="form-group input-group">
                                國家國旗：<input type="file" name="file" id="file1">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="savebtn" name="savebtn">存檔</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
        </form>
        <!-- /.add modal -->
        <!-- Edit Modal -->
        <form method="post" action="countryEdit.php" enctype="multipart/form-data" name="FileForm" id="FileForm">
            <div class="modal fade" id="editmyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"
                                    aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel">編輯國家</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group input-group">
                                <span class="input-group-addon">國家名稱</span>
                                <input type="text" id="cNametxt" name="editcame" class="form-control"
                                       placeholder="國家名稱">
                            </div>
                            <div class="form-group input-group">
                                <span class="input-group-addon">國家代碼(3碼)</span>
                                <input type="text" id="cCodetxt" name="editccode" class="form-control"
                                       placeholder="國家代碼" maxlength="3" value="">
                            </div>
                            <div class="form-group input-group">
                                <br/>
                                <img src="" width="71" height="36" id="editimg">
                                <br/>
                                國家國旗：<input type="file" name="file2" id="file3">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" value="" id="idhidden" name="idhidden">
                            <input type="hidden" value="" id="pichidden" name="pichidden">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="editbtn" name="editbtn">存檔</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
        </form>
        <!-- /.edit modal -->
        <br/><br/>
        <table class="table table-striped table-bordered table-hover" id="dataTables"
               style="word-break:break-all; ">
            <thead>
            <tr>
                <th width="10%">#</th>
                <th width="30%">國家名稱</th>
                <th width="30%">國家代碼</th>
                <th width="15%">編輯</th>
                <th width="15%">刪除</th>
            </tr>
            </thead>
            <tbody id="countryData">


            </tbody>
        </table>
    </div>
    <!-- /.table-responsive -->
</div>
<div class="tab-pane fade" id="settings">

</div>
</div>
</div>
<!-- /.panel-body -->
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
<script>

$(function () {

    //新增文章 顯示第二步
    $('#addNext1').click(function () {
        if ($('#branch option:selected').val() == "") {
            alert('請選擇館別');
            return false;
        } else {
            getcounrty();
            $('.branchTxt').text($('#branch option:selected').text());
        }
    });

//顯示文章的國家
    function getDatatable() {
        $.ajax({
            url: 'ajax/article.php',
            catch: false,
            dataType: 'html',
            type: 'POST',
            data: {
                branchCode: $('#branch1 option:selected').val(),
                mode: "read"
            },
            error: function (xhr) {
                alert('Ajax request 發生錯誤');
            },
            success: function (data) {
                $('#articleData').html(data);
            }
        });
    }

//新增文章 顯示最後一步
    $('#addNext2').click(function () {
        $('.countryTxt').text($('#country option:selected').text());
    });


//新增文章按鈕
    $('#addArticle').click(function () {
        for (instance in CKEDITOR.instances)
            CKEDITOR.instances[instance].updateElement();

        $.ajax({
            url: 'ajax/article.php',
            catch: false,
            dataType: 'json',
            type: 'POST',
            data: {
                branchName: $('#branch option:selected').text(),
                branchCode: $('#branch option:selected').val(),
                countryName: $('#country option:selected').text(),
                countryCode: $('#country option:selected').val(),
                PicUrl: $('#country option:selected').attr("data-imagesrc"),
                title: $('#title').val(),
                content: $('#content').val(),
                mode: "add"
            },
            error: function (xhr) {
                alert('Ajax request 發生錯誤');
            },
            success: function (data) {
                alert('新增成功');
                document.location.href="article.php";
            }
        });
    });

    //取得datable 功能設定
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
    //文章管理 顯示館別文章
    $('#branch1').change(function () {
        getDatatable();
    });

    //文章管理 刪除文章
    $('#articleData').on('click', '.delbtn', function () {

        if (confirm('確定刪除?')) {
            var $id = $(this).attr('rel');
            deldata($id);
        } else {
            return false;
        }

    });

    //文章管理 編輯文章
    $('#articleData').on('click', '.editarticlebtn1', function () {
        var branch = $('#branch1 option:selected').val();
        var id = $(this).attr('rel');

        //設定id
        $('#editid').val(id);

        $('#editcollapseOne').attr('class', 'panel-collapse collapse in');
        $('#editcollapseTwo').attr('class', 'panel-collapse collapse');
        $('#editcollapseThree').attr('class', 'panel-collapse collapse');
        $('#editcollapseOne').attr('aria-expanded', 'true');
        $('#editcollapseOne').attr('style', '');


        $.ajax({
            url: 'ajax/article.php',
            catch: false,
            dataType: 'json',
            type: 'POST',
            data: {
                id: id,
                mode: "readById"
            },
            error: function (xhr) {
                alert('Ajax request 發生錯誤');
            },
            success: function (data) {


                //館別設定跟資料庫一樣
                $('#editbranch option[value=' + branch + ']').attr('selected', true);
                getcounrty();
                //設定國家跟資料庫一樣
                $('#editcountryddl option[value=' + data['countryCode'] + ']').attr('selected', true);
                //設定文章標題
                $('#edittitle').val(data['title']);
                //設定內容
                CKEDITOR.instances.editcontent.setData(data['content']);


            }
        });

    });

    //編輯文章 到第二步

    $('#editNext1').click(function () {

        $('.branchTxt').text($('#editbranch option:selected').text());
    });

    //編輯文章 顯示最後一步
    $('#editNext2').click(function () {
        $('.countryTxt').text($('#editcountryddl option:selected').text());
    });

    //編輯文章 - 存檔
    $('#editsavebtn').click(function () {
        if (confirm('確定存檔?')) {
            var id = $('#editid').val();
            $.ajax({
                url: 'ajax/article.php',
                catch: false,
                dataType: 'json',
                type: 'POST',
                data: {
                    id: id,
                    PicUrl: $('#editcountryddl option:selected').attr('data-imagesrc'),
                    countryCode: $('#editcountryddl option:selected').val(),
                    countryName: $('#editcountryddl option:selected').text(),
                    branchCode: $('#editbranch option:selected').val(),
                    branchName: $('#editbranch option:selected').text(),
                    title: $('#edittitle').val(),
                    content: CKEDITOR.instances.editcontent.getData(),
                    mode: "update"
                },
                error: function (xhr) {
                    alert('Ajax request 發生錯誤');
                },
                success: function (data) {
                    alert('更新成功');
                    $('#editclosebtn').click();
                    getDatatable();

                }
            });
        }

    });


    //顯示國家內容
    $('#editcountry').click(function () {
        //顯示國家datatable
        getCountryData();
    });
    //新增國家
    $('#savebtn').click(function () {
        if (confirm('確定要新增?')) {
            //檢查上傳檔案
            //checkFile()
            if ($('#countryNametxt').val() == "") {
                alert('請輸入國家名稱');
                $('#countryNametxt').focus();
                return false;
            } else if ($('#countryCodetxt').val() == "") {
                alert('請輸入國家代碼');
                $('#countryCodetxt').focus();
                return false;
            } else {

            }


        }
    });

    //編輯國家內容
    $('#countryData').on('click', '.editbtn', function () {
        //取得國家的id
        var $id = $(this).attr('rel');
        //依id取得國家內容
        getcounrtyById($id);

    });

    //小寫改大寫
    $("#countryCodetxt").keyup(function (e) {
        var str = $(this).val();
        str = str.toUpperCase();
        $(this).val(str);
    });

    $("#cCodetxt").keyup(function (e) {
        var str = $(this).val();
        str = str.toUpperCase();
        $(this).val(str);
    });
    //檢查國家代碼是否有重覆
    $('#countryCodetxt').blur(function () {
        var code = $('#countryCodetxt').val();
        $.ajax({
            url: 'ajax/getCountry.php',
            catch: false,
            dataType: 'json',
            type: 'GET',
            data: {
                code: code,
                mode: "check"
            },
            error: function (xhr) {
                alert('Ajax request 發生錯誤');
            },
            success: function (data) {
                //0:國家代碼存在
                if (data == "0") {
                    alert('國家代碼存在，請重新輸入');
                    $('#countryCodetxt').val("");
                    $('#countryCodetxt').focus();
                } else {

                }

            }
        });
    });

    //文章管理 刪除國家
    $('#countryData').on('click', '.delbtn', function () {
        if (confirm('確定刪除?')) {
            var $id = $(this).attr('rel');
            delCountry($id);
        } else {
            return false;
        }

    });

    //取得國家列表
    function getcounrty() {
        $.ajax({
            url: 'ajax/getCountry.php',
            catch: false,
            dataType: 'json',
            type: 'GET',
            data: {
                mode: "readjson"
            },
            error: function (xhr) {
                alert('Ajax request 發生錯誤');
            },
            success: function (data) {
                var count = data.length;
                $("select.country").children().remove();
                for (var i = 0; i <= count; i++) {
                    $("select.country").append($('<option></option>').attr('value', "" + data[i]['code'] + "").text("" + data[i]['name'] + "").attr('data-imagesrc', "" + data[i]['picUrl'] + ""));
                }

            }
        });
    }

    //依id取得國家特定內容
    function getcounrtyById(id) {

        $.ajax({
            url: 'ajax/getCountry.php',
            catch: false,
            dataType: 'json',
            type: 'GET',
            data: {
                mode: "readById",
                id: id
            },
            error: function (xhr) {
                alert('Ajax request 發生錯誤');
            },
            success: function (data) {
                $('#cNametxt').val(data['name']);
                $('#cCodetxt').val(data['code']);
                $('#editimg').attr("src", data['picUrl']);
                $('#idhidden').val(id);
                $('#pichidden').val(data['filename']);
            }
        });
    }

    //顯示國家
    function getCountryData() {
        $.ajax({
            url: 'ajax/getCountry.php',
            catch: false,
            dataType: 'html',
            type: 'GET',
            data: {
                mode: "readhtml"
            },
            error: function (xhr) {
                alert('Ajax request 發生錯誤');
            },
            success: function (data) {
                $('#countryData').html(data);
            }
        });
    }

    //刪除國家
    function delCountry(id) {
        $.ajax({
            url: 'ajax/getCountry.php',
            catch: false,
            dataType: 'html',
            type: 'GET',
            data: {
                id: id,
                mode: "del"
            },
            error: function (xhr) {
                alert('Ajax request 發生錯誤');
            },
            success: function (data) {
                getCountryData();
                alert('刪除成功');
            }
        });
    }

    //刪除文章
    function deldata(id) {
        $.ajax({
            url: 'ajax/article.php',
            catch: false,
            dataType: 'html',
            type: 'POST',
            data: {
                id: id,
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

    //點擊編緝國家排序
    $("#sortcountry").on("click", function(){
        $("#settings").load('country_sort.php');
    });


})


</script>
</body>

</html>
<?php
include_once "ckeditor/ckeditor.php";
$CKEditor = new CKEditor();
$CKEditor->basePath = 'ckeditor/';
$CKEditor->replace("content");
$CKEditor->replace("editcontent");

?>
