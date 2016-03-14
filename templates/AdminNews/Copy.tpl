<div class="content-wrapper marginTop_50">
    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="col-sm-12">
            <div class="form_bound">
                 <table cellpadding="4" width="100%" bgcolor="#D3E1F1">
                    <tr>
                        <td width="80%" align="center" class="save-form-title"><h2 class="title_form">{$mode} một tin bài</h2></td>
                        <td width="10%" class="form_title_button">
                            <a class="icons_controll" href="javascript:void(0);" onclick="Common_admin.checkFormEdit(1);"><span alt="save" class="icon_save" ></span>Ghi lại</a>
                        </td>
                        <td width="10%" class="form_title_button">
                            <a class="icons_controll" href="?page={$page}"><span alt="save" class="icon_back" ></span>Quay lại</a>
                        </td>
                    </tr>
                </table>
                <div class="form_content float_left border_road width_100">
                    {$msg}
                    <form name="EditForm" method="post" action="?{$server_string}" enctype="multipart/form-data">
                        <input type="hidden" id="id_hiden" name="id" value="{$id}"/>
                        <div class="float_left width_50">
                            <label for="textName" class="control-label col-lg-12 marginTop_15">Tiêu đề tin <span style="color: red">(*)</span></label>
                            <div class="col-lg-8">
                                <input name="title_news" type="text" id="title_news" value="{$title_news}" class="form-control">
                            </div>
                        </div>

                        <div class="float_left width_50">
                            <label for="textName" class="control-label col-lg-12 marginTop_15">Danh mục</label>
                            <div class="col-lg-8">
                                <select name="cat_new_id" id="cat_new_id" class="form-control">
                                    {$optionTypeNew}
                                </select>
                            </div>
                        </div>

                        <div class="float_left width_50">
                            <label for="textName" class="control-label col-lg-12 marginTop_15">Ẩn hiện</label>
                            <div class="col-lg-8">
                                <select name="status" class="form-control">
                                    {$optionStatus}
                                </select>
                            </div>
                        </div>
                        <div class="float_left width_50">
                            <label for="textName" class="control-label col-lg-12 marginTop_15">Thời gian lên tin</label>
                            <div class="col-lg-8">
                                <input id="start_time" name="start_time" class="form-control" type="text" value="{$start_time}">
                            </div>
                        </div>
                        <div class="float_left width_50">
                            <label for="textName" class="control-label col-lg-12 marginTop_15">Tin nổi bật</label>
                            <div class="col-lg-8">
                                <select name="hot_news" id="hot_news" class="form-control">
                                    {$optionHot}
                                </select>
                            </div>
                        </div>
                        <div class="float_left width_50">
                            <label for="textName" class="control-label col-lg-12 marginTop_15">Thời gian hạ</label>
                            <div class="col-lg-8">
                                <input id="end_time" name="end_time" class="form-control" type="text" value="{$end_time}">
                            </div>
                        </div>

                        <div class="float_left width_100">
                            <label for="textName" class="control-label col-lg-12 marginTop_15">Ảnh đại diện</label>
                            <div class="col-lg-12">
                                <a href="javascript:;"class="btn btn-primary" onclick="Common_admin.uploadMultipleImages(1);">Upload ảnh </a>

                                <input name="image_primary" type="hidden" id="image_primary" value="">
                                {assign var="key_primary" value="-1"}
                                <ul id="sys_drag_sort" class="ul_drag_sort">
                                    {if (isset($images_other) && $images_other|@count > 0)}
                                        {foreach from=$images_other item=value name=list_item key=key}
                                            <li id="sys_div_img_other_{$key}">
                                                <div class="div_img_upload">
                                                    <img src="{$value.src}" height="80" width="80">
                                                    <input type="hidden" id="sys_img_other_{$key}" name="img_other[]" value="{$value.name_img}" class="sys_img_other">
                                                    <div class='clear'></div>
                                                    <input type="radio" id="chẹcked_image_{$key}" name="chẹcked_image" value="{$key}" {if (isset($image_primary) && ($image_primary == $value.name_img))} checked="checked" {/if} onclick="Common_admin.checkedImage('{$value.name_img}','{$key}');">
                                                    <label for="chẹcked_image_{$key}" style='font-weight:normal'>Ảnh đại diện</label>
                                                    <br/><a href="javascript:void(0);" id="sys_delete_img_other_{$key}"onclick="Common_admin.removeImage('{$key}','{$id}','{$value.name_img}','1');" {if (isset($image_primary) && ($image_primary == $value.name_img))} style="display: none" {/if}>Xóa ảnh</a>
                                                    <span style="display: none"><b>{$key}</b></span>
                                                </div>
                                                {if (isset($image_primary) && ($image_primary == $value.name_img))} {assign var="key_primary" value="$key"} {/if}
                                            </li>
                                        {/foreach}
                                        <input type="hidden" id="sys_key_image_primary" name="sys_key_image_primary" value="{$key_primary}">
                                    {/if}
                                </ul>
                                <input name="list1SortOrder" id ='list1SortOrder' type="hidden" />
                            </div>
                        </div>

                        <div class="float_left width_100">
                            <label for="textName" class="control-label col-lg-12 marginTop_15">Mô tả ngắn</label>
                            <div class="col-lg-12">
                                {$editor_description_new}
                            </div>
                        </div>
                        <div class="float_left width_100">
                            <label for="textName" class="control-label col-lg-12 marginTop_15">Nội dung</label>
                            <div class="col-lg-12">
                                <div style="text-align: center; position: relative">
                                    <div style="position: absolute; top: 10px; right: 35px">
                                        <input type="button" value="Chèn ảnh vào nội dung" onclick="Common_admin.insertImageContent(1)" class="btn-warning">
                                    </div>
                                    {*Popup anh khac de chen vao noi dung bai viet*}
                                    <div class="modal fade" id="sys_PopupImgOtherInsertContent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    <h4 class="modal-title" id="myModalLabel">Upload thêm ảnh để chèn</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <form name="uploadImage" method="post" action="#" enctype="multipart/form-data">
                                                        <div class="form_group">
                                                            <div id="sys_mulitplefileuploader_insertContent" class="btn btn-primary">Upload thêm ảnh chèn</div>
                                                            <div id="status"></div>

                                                            <div class="clearfix"></div>
                                                            <div class="clearfix" style='margin: 5px 10px; width:100%;'>
                                                                <div id="div_image" class="float_left">
                                                                    {if (isset($images_other) && $images_other|@count > 0)}
                                                                        {foreach from=$images_other item=value name=list_item key=key}
                                                                            <span class="float_left image_insert_content">
                                                                                <a class="img_item" href="javascript:void(0);" onclick="insertImgContent('{$value.src_700}')" >
                                                                                    <img src="{$value.src_80}" width="80" height="80">
                                                                                </a>
                                                                            </span>
                                                                        {/foreach}
                                                                    {/if}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {*Popup anh khac de chen vao noi dung bai viet*}

                                    {$editor_content_new}
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="act" value="{$smarty.request.act}" />
                    </form>
                </div>
                <div class="clear"></div>
                <table cellpadding="4" width="100%" bgcolor="#D3E1F1" class="float_left marginTop_15">
                    <tr>
                        <td width="80%" align="center" class="save-form-title"><h2 class="title_form">{$mode} một tin bài</h2></td>
                        <td width="10%" class="form_title_button">
                            <a class="icons_controll" href="javascript:void(0);" onclick="Common_admin.checkFormEdit(1);"><span alt="save" class="icon_save" ></span>Ghi lại</a>
                        </td>
                        <td width="10%" class="form_title_button">
                            <a class="icons_controll" href="?page={$page}" ><span alt="save" class="icon_back" ></span>Quay lại</a>
                        </td>
                    </tr>
                </table>
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
        //kéo thả ảnh
        $("#sys_drag_sort").dragsort({ dragSelector: "div", dragBetween: true, dragEnd: saveOrder });
        function saveOrder() {
            var data = $("#sys_drag_sort li div span").map(function() { return $(this).children().html(); }).get();
            $("input[name=list1SortOrder]").val(data.join(","));
        };
		function insertImgId(src){
			CKEDITOR.instances.content.insertHtml('<img src="'+src+'"/>');
		}
	</script>
{/literal}

