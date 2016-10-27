<?php
session_start();
header("Content-Type:text/html; charset=utf-8");
// 藉由含括子系統的設定檔，取得網站及子系統的各種設定
include_once('appConfig.php');
// 引入資料庫
include_once(INCLUDE_DIR . 'db.php');

include_once('class/ClassSlider.php');

//產生物件
$obj = new ClassSlider();

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
                    <h3 class="page-header">首頁大圖輪播</h3>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#home" data-toggle="tab" id="setpic">設定圖片資訊</a>
                            </li>
                            <li><a href="#profile" data-toggle="tab">圖片管理</a>
                            </li>

                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="home">


                                <div class="dataTable_wrapper">
                                    <table class="table table-striped table-bordered table-hover" id="dataTables"
                                           style="word-break:break-all; ">
                                        <thead>
                                        <tr>
                                            <th width="20%">縮圖</th>
                                            <th width="40%">連結</th>
                                            <th width="10%">排序</th>
                                            <th width="10%">狀態</th>
                                            <th width="10%">編輯</th>
                                        </tr>
                                        </thead>
                                        <tbody id="data">
                                        <?php
                                        $arr = array();
                                        $i = 1;
                                        foreach ($recordset as $record) {
                                            $arr["$i"]="$i";
                                            ?>
                                            <tr id="<?php echo $record['id'];?>">
                                                    <!--<td><?php /*echo (count($recordset) > 0) ? "<input type=\"checkbox\" value=\"" . $record['id'] . "\">" : ""; */?></td>-->
                                                <td align="center"><img
                                                        src="server/php/files/<?php echo $record['name']; ?>"
                                                        width="142" height="70">
                                                </td>
                                                <td><?php echo ($record['url'] == "") ? "(目前暫無連結)" : "<a href=\"" . $record['url'] . "\" target=\"_blank\">" . $record['url'] . "</a>"; ?></td>
                                                <td class="sort" field="ssisort" align="center"><?php echo $record['sort']; ?></td>
                                                <td align="center" class="status" field="ssistatus"><?php
                                                    if ($record['flag'] == 1) {
                                                        echo "<i class=\"fa fa-check\"></i>";
                                                    } else {
                                                        echo "<i class=\"fa fa-times\"></i>";
                                                    }
                                                    ?></td>
                                                <td><a href="sliderEdit.php?id=<?php echo $record['id']; ?>"
                                                       class="btn btn-info btn-circle"><i class="glyphicon glyphicon-edit"></i></a></td>
                                            </tr>
                                        <?php
                                            $i++;
                                        }


                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
                            </div>
                            <div class="tab-pane fade" id="profile">
                                <br/>

                                <!-- 上傳大圖form start-->
                                <form id="fileupload" action="" method="POST" enctype="multipart/form-data">
                                    <!-- Redirect browsers with JavaScript disabled to the origin page -->

                                    <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
                                    <div class="row fileupload-buttonbar">
                                        <div class="col-lg-7">
                                            <!-- The fileinput-button span is used to style the file input field as button -->
                                    <span class="btn btn-success fileinput-button">
                                        <i class="glyphicon glyphicon-plus"></i>
                                        <span>上傳圖片</span>
                                        <input type="file" name="files[]" multiple>
                                    </span>
                                            <button type="submit" class="btn btn-primary start">
                                                <i class="glyphicon glyphicon-upload"></i>
                                                <span>開始上傳</span>
                                            </button>
                                            <button type="reset" class="btn btn-warning cancel">
                                                <i class="glyphicon glyphicon-ban-circle"></i>
                                                <span>取消上傳</span>
                                            </button>
                                            <button type="button" class="btn btn-danger delete">
                                                <i class="glyphicon glyphicon-trash"></i>
                                                <span>刪除圖片</span>
                                            </button>
                                            <input type="checkbox" class="toggle">
                                            <h5>（建議尺寸700*340px)</h5>
                                            <!-- The global file processing state -->
                                            <span class="fileupload-process"></span>

                                        </div>
                                        <!-- The global progress state -->
                                        <div class="col-lg-5 fileupload-progress fade">
                                            <!-- The global progress bar -->
                                            <div class="progress progress-striped active" role="progressbar"
                                                 aria-valuemin="0" aria-valuemax="100">
                                                <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                                            </div>
                                            <!-- The extended global progress state -->
                                            <div class="progress-extended">&nbsp;</div>
                                        </div>
                                    </div>
                                    <!-- The table listing the files available for upload/download -->
                                    <table role="presentation" class="table table-striped">
                                        <tbody class="files"></tbody>
                                    </table>
                                </form>
                                <div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls"
                                     data-filter=":even">
                                    <div class="slides"></div>
                                    <h3 class="title"></h3>
                                    <a class="prev">‹</a>
                                    <a class="next">›</a>
                                    <a class="close">×</a>
                                    <a class="play-pause"></a>
                                    <ol class="indicator"></ol>
                                </div>
                                <!-- 上傳大圖form end-->
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
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td>
            <span class="preview"></span>
        </td>
        <td>
            <p class="name">{%=file.name%}</p>
            <strong class="error text-danger"></strong>
        </td>
        <td>
            <p class="size">Processing...</p>
            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
        </td>
        <td>
            {% if (!i && !o.options.autoUpload) { %}
                <button class="btn btn-primary start" disabled>
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>Start</span>
                </button>
            {% } %}
            {% if (!i) { %}
                <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel</span>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}


</script>
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        <td>
            <span class="preview">
                {% if (file.thumbnailUrl) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
                {% } %}
            </span>
        </td>
        <td>
            <p class="name">
                {% if (file.url) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
                {% } else { %}
                    <span>{%=file.name%}</span>
                {% } %}
            </p>
            {% if (file.error) { %}
                <div><span class="label label-danger">Error</span> {%=file.error%}</div>
            {% } %}
        </td>
        <td>
            <span class="size">{%=o.formatFileSize(file.size)%}</span>
        </td>
        <td>
            {% if (file.deleteUrl) { %}
                <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                    <i class="glyphicon glyphicon-trash"></i>
                    <span>刪除</span>
                </button>
                <input type="checkbox" name="delete" value="1" class="toggle">
            {% } else { %}
                <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel</span>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}


</script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="js/vendor/jquery.ui.widget.js"></script>
<!-- The Templates plugin is included to render the upload/download listings -->
<script src="//blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="//blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="//blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
<!-- Bootstrap JS is not required, but included for the responsive demo navigation -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<!-- blueimp Gallery script -->
<script src="//blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
<!-- The basic File Upload plugin -->
<script src="js/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="js/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="js/jquery.fileupload-image.js"></script>
<!-- The File Upload validation plugin -->
<script src="js/jquery.fileupload-validate.js"></script>
<!-- The File Upload user interface plugin -->
<script src="js/jquery.fileupload-ui.js"></script>
<!-- The main application script -->
<script src="js/cors/jquery.xdr-transport.js"></script>


<!-- 主要上傳的js -->
<script src="js/main.js"></script>

<!-- 即時編輯表格 -->
<script src="js/jquery.jeditable.js"></script>

<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
<!--[if (gte IE 8)&(lt IE 10)]>
<![endif]-->


<script>

    $(function () {

        function getdate(){
            //點設定圖片資訊時，重新讀取資料

                $.ajax({
                    url: 'ajax/slider.php',
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
                        $('#data').html("");
                        $('#data').html(data);
                    }
                });

        }

        $('#setpic').click(function () {
            getdate();
        });


        $(document).on('click','.sort', function(){
            $(this).editable("ajax/edittable.php", {
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
                    getdate();
                }
            });
        });


        $(document).on('click','.status', function(){
            $(this).editable("ajax/edittable.php", {
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
                    getdate();

                }
            });
        });


    })
</script>

</body>

</html>
