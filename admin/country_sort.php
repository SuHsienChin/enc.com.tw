<select name="branch1" id="sort_branch" class="form-control">
    <option value="" selected disabled>請選擇</option>
    <option value="E">移民館</option>
    <option value="L">留學館</option>
    <option value="G">中學館</option>
    <option value="W">語言館</option>
</select>
<br /><br />
<div id="country_data">
    <table class="table table-striped table-bordered table-hover" id="dataTables"
           style="word-break:break-all;width:70%;" >
        <thead>
        <tr>
            <th>類別</th>
            <th>代碼</th>
            <th>排序</th>
        </tr>
        </thead>
        <tbody id="country_data_tbody">


        </tbody>
        <tr id="savetr" style="display: none;">
            <td colspan="3" align="right"><a href="#" class="btn btn-primary" id="sort_save_btn"
                                             name="sort_save_btn">存檔</a></td>
        </tr>
    </table>
</div>

<script>

    $(function(){


        $("#sort_branch").change(function(){
            $('#savetr').show();
            getcountrydata();
        });

        $('#sort_save_btn').click(function(){

                $('#country_data_tbody > tr').each(function () {
                    var code = $.trim($(this).find("td:eq(1)").text());
                    var sort = $.trim($(this).find("td:eq(2)").find(".degree_accept_id").val()); //1是抓取第二欄的文字

                    $.ajax({
                        url: 'ajax/sort_article_country.php',
                        catch: false,
                        dataType: 'html',
                        type: 'GET',
                        data: {
                            bra: $("#sort_branch option:selected").val(),
                            code: code,
                            sort: sort,
                            mode: "edit"
                        },
                        error: function (xhr) {
                            alert('Ajax request 發生錯誤');
                        },
                        success: function (data) {
                            getcountrydata();

                        }
                    });

                });
            alert('更新成功');
        });



    });


    function getcountrydata(){
        $.ajax({
            url: 'ajax/sort_article_country.php',
            catch: false,
            dataType: 'html',
            type: 'GET',
            data: {
                bra: $("#sort_branch option:selected").val(),
                mode: "read"
            },
            error: function (xhr) {
                alert('Ajax request 發生錯誤');
            },
            success: function (data) {
                $('#country_data_tbody').html();
                $('#country_data_tbody').html(data);
            }
        });


    }




</script>