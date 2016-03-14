<div class="content-wrapper marginTop_50">
<!-- Main content -->
<section class="content">
<!-- Small boxes (Stat box) -->
<div class="col-sm-12">
<div class="form_bound">
<table cellpadding="4" width="100%" bgcolor="#D3E1F1">
    <tr>
        <td width="70%" align="center" class="save-form-title"><h2 class="title_form">{$mode} sản phẩm</h2></td>
        <td width="10%" class="form_title_button">
            <a class="icons_controll" href="javascript:void(0);" onclick="Common_admin.checkFormEdit(2);"><span alt="save" class="icon_save" ></span>Ghi lại</a>
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
    <label for="textName" class="control-label col-lg-12 marginTop_15">Tên sản phẩm <span class="note">***</span></label>
    <div class="col-lg-8">
        <input name="name" type="text" id="name" value="{$item.name}" class="form-control">
    </div>
</div>

{*phần chọn option*}
<div class="clear"></div>
<div class="float_left width_25">
    <div class="float_left width_100">
        <label for="textName" class="control-label col-lg-12 marginTop_15">Danh mục</label>
        <div class="col-lg-12">
            <select name="category_id" id="category_id" class="form-control">
                {$optionCategory}
            </select>
        </div>
    </div>

    <div class="float_left width_50">
        <label for="textName" class="control-label col-lg-12 marginTop_15">Ẩn hiện</label>
        <div class="col-lg-12">
            <select name="status" class="form-control">
                {$optionStatus}
            </select>
        </div>
    </div>
    <div class="float_left width_50">
        <label for="textName" class="control-label col-lg-12 marginTop_15">Sắp xếp</label>
        <div class="col-lg-12">
            <input name="position" type="text" id="position" value="{$item.position}" class="form-control">
        </div>
    </div>
    <div class="float_left width_100">
        <label for="textName" class="control-label col-lg-12 marginTop_15">Sản phẩm nổi bật</label>
        <div class="col-lg-12">
            <select name="hot" id="hot" class="form-control">
                {$optionHot}
            </select>
        </div>
    </div>
</div>

{*phần chọn option*}
<div class="float_left width_25">
    <div class="float_left width_50">
        <label for="textName" class="control-label col-lg-12 marginTop_15">SL nhập kho</label>
        <div class="col-lg-12">
            <input id="store" name="store" class="form-control" type="text" value="{$item.store}">
        </div>
    </div>
    <div class="float_left width_50">
        <label for="textName" class="control-label col-lg-12 marginTop_15">SL đã bán</label>
        <div class="col-lg-12">
            <input id="quantity_sell" name="quantity_sell" class="form-control" type="text" value="{$item.quantity_sell}">
        </div>
    </div>

    <div class="float_left width_100">
        <label for="textName" class="control-label col-lg-12 marginTop_15">Thời gian bắt đầu</label>
        <div class="col-lg-12">
            <input id="start_time" name="start_time" class="form-control" type="text" value="{if ($item.start_time > 0)}{$item.start_time|date_format:"%d-%m-%Y"}{/if}">
        </div>
    </div>
    <div class="float_left width_100">
        <label for="textName" class="control-label col-lg-12 marginTop_15">Thời gian kết thúc</label>
        <div class="col-lg-12">
            <input id="end_time" name="end_time" class="form-control" type="text" value="{if ($item.end_time > 0)}{$item.end_time|date_format:"%d-%m-%Y"}{/if}">
        </div>
    </div>

</div>

{*phần chọn giá*}
<div class="float_left width_25">
    <div class="float_left width_100">
        <label for="textName" class="control-label col-lg-12 marginTop_15">Giá bán <span class="note">***</span></label>
        <div class="col-lg-12">
            <input type="text" id="price" name="price" class="formatMoney text-right form-control" data-v-max="999999999999999" data-v-min="0" data-a-sep="." data-a-dec="," data-a-sign=" đ" data-p-sign="s" value="{$item.price}">
            <input type="hidden" id="price_hide" name="price_hide" value="0">
        </div>
    </div>

    <div class="float_left width_100">
        <label for="textName" class="control-label col-lg-12 marginTop_15">Giá nhập <span class="note">***</span></label>
        <div class="col-lg-12">
            <input type="text" id="price_input" name="price_input" class="formatMoney text-right form-control" data-v-max="999999999999999" data-v-min="0" data-a-sep="." data-a-dec="," data-a-sign=" đ" data-p-sign="s" value="{$item.price_input}">
            <input type="hidden" id="price_input_hide" name="price_input_hide" value="0">
        </div>
    </div>

    <div class="float_left width_100">
        <label for="textName" class="control-label col-lg-12 marginTop_15">Giá thị trường <span class="note">***</span></label>
        <div class="col-lg-12">
            <input type="text" id="price_market" name="price_market" class="formatMoney text-right form-control" data-v-max="999999999999999" data-v-min="0" data-a-sep="." data-a-dec="," data-a-sign=" đ" data-p-sign="s" value="{$item.price_market}">
            <input type="hidden" id="price_market_hide" name="price_market_hide" value="0">
        </div>
    </div>
</div>

{*phần chọn thời gian*}
<div class="float_left width_25">
    <div class="float_left width_100">
        <label for="textName" class="control-label col-lg-12 marginTop_15">Từ khóa seo</label>
        <div class="col-lg-12">
            <textarea class="form-control" rows="2" id="page_keywords" name="page_keywords">{$item.page_keywords}</textarea>
        </div>
    </div>
    <div class="float_left width_100">
        <label for="textName" class="control-label col-lg-12 marginTop_15">Mô tả seo</label>
        <div class="col-lg-12">
            <textarea class="form-control" rows="2" id="page_descriptions" name="page_descriptions">{$item.page_descriptions}</textarea>
        </div>
    </div>
</div>

<div class="float_left width_100">
    <label for="textName" class="control-label col-lg-12 marginTop_15">Ảnh đại diện</label>
    <div class="col-lg-12">
        <a href="javascript:;"class="btn btn-primary" onclick="Common_admin.uploadMultipleImages(2);">Upload ảnh </a>

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
                            <input type="radio" id="chẹcked_image_{$key}" name="chẹcked_image" value="{$key}" {if (isset($item.images) && ($item.images == $value.name_img))} checked="checked" {/if} onclick="Common_admin.checkedImage('{$value.name_img}','{$key}');">
                            <label for="chẹcked_image_{$key}" style='font-weight:normal'>Ảnh đại diện</label>
                            <br/><a href="javascript:void(0);" id="sys_delete_img_other_{$key}"onclick="Common_admin.removeImage('{$key}','{$id}','{$value.name_img}','2');" {if (isset($item.images) && ($item.images == $value.name_img))} style="display: none" {/if}>Xóa ảnh</a>
                            <span style="display: none"><b>{$key}</b></span>
                        </div>
                        {if (isset($item.images) && ($item.images == $value.name_img))} {assign var="key_primary" value="$key"} {/if}
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
        {$editor_description}
    </div>
</div>
<div class="float_left width_100">
    <label for="textName" class="control-label col-lg-12 marginTop_15">Nội dung</label>
    <div class="col-lg-12">
        <div style="text-align: center; position: relative">
            <div style="position: absolute; top: 10px; right: 35px">
                <input type="button" value="Chèn ảnh vào nội dung" onclick="Common_admin.insertImageContent(2)" class="btn-warning">
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

            {$editor_content}
        </div>

    </div>
</div>
<input type="hidden" name="act" value="{$smarty.request.act}" />
</form>
</div>
<div class="clear"></div>
<table cellpadding="4" width="100%" bgcolor="#D3E1F1">
    <tr>
        <td width="70%" align="center" class="save-form-title"><h2 class="title_form">{$mode} sản phẩm</h2></td>
        <td width="10%" class="form_title_button">
            <a class="icons_controll" href="javascript:void(0);" onclick="Common_admin.checkFormEdit(2,1);"><span alt="save" class="icon_save_tem" ></span>Lưu tạm</a>
        </td>
        <td width="10%" class="form_title_button">
            <a class="icons_controll" href="javascript:void(0);" onclick="Common_admin.checkFormEdit(2);"><span alt="save" class="icon_save" ></span>Ghi lại</a>
        </td>
        <td width="10%" class="form_title_button">
            <a class="icons_controll" href="?page={$page}"><span alt="save" class="icon_back" ></span>Quay lại</a>
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

