<div class="content-wrapper marginTop_50" >
    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="col-sm-12">
            <div class="save-bound">
                {*Vùng action*}
                <table cellpadding="0" cellspacing="1" width="100%" bgcolor="#D3E1F1">
                    <tr>
                        <td width="99%" align="center" class="save-form-title"><a href="?page={$page}"><h2 class="title_form">{$title_page}</h2></a></td>
                        <td class="form_title_button">
                            <a class="icons_controll" href="?page={$page}"><span alt="Publish" class="icon_home" ></span>Home</a>
                        </td>
                        <td class="form_title_button">
                            <a class="icons_controll" href="javascript:void(0);" onclick="document.ListForm.act.value = 'publishAll'; Common_admin.checkform();"><span alt="Publish" class="icon_publich" ></span>Hiện</a>
                        </td>
                        <td class="form_title_button">
                            <a class="icons_controll" href="javascript:void(0);" onclick="document.ListForm.act.value = 'unpublishAll';Common_admin.checkform();"><span alt="UnPublish" class="icon_unPublich" ></span>Ẩn</a>
                        </td>
                        <td class="form_title_button">
                            <a class="icons_controll" href="?page={$page}&act=add"><span alt="New" class="icon_add" ></span>Thêm</a>
                        </td>
                        <td class="form_title_button" >
                            <a class="icons_controll" href="javascript:void(0);" onclick="Common_admin.confirmRemoveAll();"><span alt="Delete" class="icon_delete" ></span>Xóa</a>
                        </td>
                    </tr>
                </table>

                {*Vùng tìm kiếm*}
                <div class="clear paddingBottom10"></div>
                <div class="float_left width_100">
                    <div class="area_content_select_search">
                        <div class="col-lg-12 padding-top-1">
                            <label for="" style="font-size:16px">Vùng điều kiện lọc </label>
                        </div>
                        <div class="clear marginBottom_10"></div>

                        <div class="box">
                            <div id="div-4" class="body">
                                <div class="form-group">
                                    <div class="col-lg-3 padding-top-1">
                                        <label for="product_id" class="control-label">Tiêu đề tin</label>
                                        <div><input type="text" id="title_news" name="title_news" class="form-control" value="{$search.title_news}"></div>
                                    </div>
                                    <div class="col-lg-3 padding-top-1">
                                        <label for="status" class="control-label">Trạng thái</label>
                                        <div><select name="status" class="form-control input-sm">{$search.status}</select></div>
                                    </div>
                                    <div class="col-lg-3 padding-top-1">
                                        <label for="cat_new_id" class="control-label">Danh mục tin tức</label>
                                        <div>
                                            <select name="cat_new_id" class="form-control input-sm">{$search.cat_new_id}</select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 padding-top-1">
                                        <label for="product_id" class="control-label">&nbsp;</label>
                                        <div>
                                            <button class="btn btn-primary" name="search_product" value="1" onclick="document.ListForm.act.value = ''; javascript:document.ListForm.submit();">Tìm kiếm</button>
                                        </div>
                                    </div>
                                </div><!-- /.form-group -->
                            </div>
                        </div>
                    </div>
                </div>

                {*Vùng hiển thị kết quả*}
                <div class="float_left width_100 marginTop_20">
                    <table width="100%" class="table_page_setting">
                        <tr>
                            <td class="paging_block">{$paging}</td>
                            <td class="gotopage_block"></td>
                        </tr>
                    </table>
                    <table class="table table-bordered table-hover table-striped" width="100%" cellpadding="5" cellspacing="1" border="1">
                        <thead>
                            <tr>
                                <th width="3%" class="text_center">STT</th>
                                <th width="3%" title="check_all" class="text_center">
                                    <input type="checkbox" value="1" id="ItemType_all_checkbox" onclick="Common_admin.isCheckedList(this.checked,{$total_row});	Common_admin.selectAllCheckbox(this.form, 'ItemType', this.checked, '#FFFFEC', 'white');">
                                </th>
                                <th width="3%" class="text_center">Ảnh</th>
                                <th width="40%" class="text_left">Tiêu đề tin</th>
                                <th width="15%" class="text_center">Danh mục</th>
                                <th width="6%" class="text_center">Tin host</th>
                                <th width="6%" class="text_center">Ẩn-Hiện</th>
                                <th width="8%" class="text_center">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            {foreach from=$items item=value name=list_item}
                                <tr id="ItemType_tr_{$value.id}">
                                    <td class="text_center text_middle">{$stt+$smarty.foreach.list_item.index+1}</td>
                                    <td class="text_center text_middle">
                                        <input name="selected_ids[]" type="checkbox" value="{$value.id}" onclick="Common_admin.isCheckedList(this.checked, 0);Common_admin.select_checkbox(this.form, 'ItemType', this, '#FFFFEC', 'white');">
                                    </td>
                                    <td class="text_center text_middle">
                                        <div style="position: relative;">
                                            <div style="position: relative; z-index: 10">
                                                <img src="{$value.images}" class='imge_hover' id='{$value.id}'/>
                                            </div>
                                            <div id='div_hover_{$value.id}'style="position: absolute; bottom: 30px; left: 40px; border: 2px solid #ccc; padding: 5px; background: #F4F9FF; z-index: 1000; display: none">
                                                <img src="{$value.images_big}"/>
                                                <br/>Ngày tạo: {$value.create_time|date_format:"%d-%m-%Y"}
                                                <br/>Ngày sửa: {$value.modify_time|date_format:"%d-%m-%Y"}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text_left text_middle">
                                        <a href="?page={$page}&act=edit&id={$value.id}" title="{$value.id} - {$value.name}">{$value.name}</a>
                                    </td>
                                    <td class="text_center text_middle">{$value.cat_news_name}</td>
                                    <td class="text_center text_middle">{if $value.hot_news == 1} Có {else} Không {/if}</td>
                                    <td class="text_center text_middle">
                                        {if $value.status ==1}
                                            <a href="?page={$page}&act=status&id={$value.id}&status={$value.status}" title="Click để ẩn"><span class="icon_true"></span></a>
                                        {else}
                                            <a href="?page={$page}&act=status&id={$value.id}&status={$value.status}" title="Click để hiện"><span class="icon_fasle"></span></a>
                                        {/if}
                                    </td>
                                    <td class="text_center text_middle">
                                        <a href="?page={$page}&act=edit&id={$value.id}" title="Edit item" class="a_list_action"><span class="icon_edit"></span></a>
                                        <a href="?page={$page}&act=copy&id={$value.id}" title="Sao chép" class="a_list_action"><span class="icon_copy"></span></a>
                                        <a href="?page={$page}&act=delete&id={$value.id}" title="Xóa" class="a_list_action" onclick="Common_admin.confirmDelete();"><span class="icon_remove"></span></a>
                                    </td>
                                </tr>
                            <input type="hidden" name="list_ids[]" value="{$item.id}" />
                        {/foreach}
                        </tbody>
                    </table>
                    <table width="100%" class="table_page_setting">
                        <tr>
                            <td class="paging_block">{$paging}</td>
                            <td class="gotopage_block"></td>
                        </tr>
                    </table>
                </div>

	            <input type="hidden" name="act" value="{$smarty.request.act}" />
	            <input type="hidden" value="0" name="boxchecked">
            </div>
        </div> <!-- Small boxes (Stat box) -->
    </section>
</div>
