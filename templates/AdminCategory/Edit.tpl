<div class="content-wrapper marginTop_50">
    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="col-sm-12">
            <div class="form_bound">
                 <table cellpadding="4" width="100%" bgcolor="#D3E1F1">
                    <tr>
                        <td width="70%" align="center" class="save-form-title"><h2 class="title_form">{$mode} danh mục</h2></td>
                        <td width="10%" class="form_title_button">
                            <a class="icons_controll" href="javascript:void(0);" onclick="Common_admin.checkFormEdit(3,1);"><span alt="save" class="icon_save_tem" ></span>Lưu tạm</a>
                        </td>
                        <td width="10%" class="form_title_button">
                            <a class="icons_controll" href="javascript:void(0);" onclick="Common_admin.checkFormEdit(3);"><span alt="save" class="icon_save" ></span>Ghi lại</a>
                        </td>
                        <td width="10%" class="form_title_button">
                            <a class="icons_controll" href="?page={$page}"><span alt="save" class="icon_back" ></span>Quay lại</a>
                        </td>
                    </tr>
                </table>
                <div class="form_content float_left border_road width_100">
                    {$msg}
                    <form name="EditForm" method="post" action="?{$server_string}" enctype="multipart/form-data">
                        <input type="hidden" id="id_hiden" name="id" value="{$lists.id}"/>
                        <div class="float_left width_100">
                            <label for="textName" class="control-label col-lg-12 marginTop_15">Tên danh mục <span class="note">***</span></label>
                            <div class="col-lg-6">
                                <input name="name" type="text" id="name" value="{$lists.name}" class="form-control">
                            </div>
                        </div>
                        <div class="float_left width_100">
                            <label for="textName" class="control-label col-lg-12 marginTop_15">Danh mục cha<span class="note">***</span></label>
                            <div class="col-lg-6">
                            <select name="parent_id" id="parent_id" class="form-control">
                                {$lists.option_cat}
                            </select>
                            </div>
                        </div>
                        <div class="float_left width_100">
                            <label for="textName" class="control-label col-lg-12 marginTop_15">Danh mục cha<span class="note">***</span></label>
                            <div class="col-lg-6">
                            <select name="status" id="status" class="form-control">{$lists.option_status}</select>
                            </div>
                        </div>
                        <div class="float_left width_100">
                            <label for="textName" class="control-label col-lg-12 marginTop_15">Sắp xêp<span class="note">***</span></label>
                            <div class="col-lg-6">
                            <input type="text" value="{$lists.order}" name="order" size="10" class="form-control"/>
                            </div>
                        </div>
                        <div class="float_left width_100">
                            <label for="textName" class="control-label col-lg-12 marginTop_15">Link view<span class="note">***</span></label>
                            <div class="col-lg-6">
                            <input type="text" maxlength="50" size="50" value="{$lists.linkview}" id="linkview" name="linkview" class="form-control">
                            </div>
                        </div>
                        <input type="hidden" name="act" value="{$smarty.request.act}" />
                    </form>
                </div>
                <div class="clear"></div>

            </div>

        </div><!-- Small boxes (Stat box) -->
    </section>
</div>

<!--Popup upload ảnh-->
<div class="modal fade" id="sys_PopupUploadImgOtherPro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Upload ảnh</h4>
            </div>
            <div class="modal-body">
                <form name="uploadImage" method="post" action="#" enctype="multipart/form-data">
                <div class="form_group">
                    <div id="sys_mulitplefileuploader" class="btn btn-primary">Upload ảnh</div>
                    <div id="status"></div>

                    <div class="clearfix"></div>
                    <div class="clearfix" style='margin: 5px 10px; width:100%;'>
                        <div id="div_image"></div>
                    </div>
                </div>
               </form>
            </div>
        </div>
    </div>
</div>
<!--Popup upload ảnh-->
{literal}
	<script type="text/javascript">
        jQuery(document).ready(function() {
            //dịnh dạng giá
            $('.formatMoney').autoNumeric('init');
            //set time
            // thong tin: http://xdsoft.net/jqplugins/datetimepicker/
            $('#start_time').datetimepicker({
                dayOfWeekStart : 1,
                format:'d-m-Y H:i',
                lang:'en'
            });
            $('#end_time').datetimepicker({
                dayOfWeekStart : 1,
                format:'d-m-Y H:i',
                lang:'en'
            });
        });

        $("#sys_drag_sort").dragsort({ dragSelector: "div", dragBetween: true, dragEnd: saveOrder });
        function saveOrder() {
            var data = $("#sys_drag_sort li div span").map(function() { return $(this).children().html(); }).get();
            $("input[name=list1SortOrder]").val(data.join(","));
        };

		function insertImgContent(src){
			CKEDITOR.instances.content.insertHtml('<img src="'+src+'"/>');
		}
	</script>
{/literal}

