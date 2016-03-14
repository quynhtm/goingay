<div class="content-wrapper marginTop_50" >
    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="col-sm-12">
            <div class="save-bound">
                {*Vùng action*}
                <table cellpadding="0" cellspacing="1" width="100%" bgcolor="#D3E1F1">
                    <tr>
                        <td width="99%" align="center" class="save-form-title"><a href="?page={$page}"><h2 class="title_form">Quản trị Page</h2></a></td>
                        <td class="form_title_button">
                            <a class="icons_controll" href="?page={$page}"><span alt="Publish" class="icon_home" ></span>Home</a>
                        </td>
                        <td class="form_title_button">
                            <a class="icons_controll" href="?page={$page}&act=add"><span alt="New" class="icon_add" ></span>Thêm</a>
                        </td>
                        <td class="form_title_button" >
                            <a class="icons_controll" href="javascript:void(0);" onclick="Common_admin.confirmRemoveAll();"><span alt="Delete" class="icon_cancel" ></span>Xóa</a>
                        </td>
                        <td class="form_title_button" width="20%">
                            <a class="icons_controll" href="?page=page&cmd=delete_all_cache"><span alt="Delete Cache" class="icon_delete" ></span>Cache</a>
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
                        <div class="clear paddingBottom5"></div>

                        <div class="box">
                            <div id="div-4" class="body">
                                <div class="form-group">
                                    <div class="col-lg-3 padding-top-1">
                                        <div>
                                            <label for="product_id" class="control-label">Tìm trang</label>
                                            <div><input onkeyup="Common_admin.filter(this.value)" name="name" type="text" id="name" class="form-control" value="{$name}"></div>
                                        </div>

                                    </div>

                                    <div class="col-lg-3 padding-top-1">
                                        <div>
                                            <label for="product_id" class="control-label">Tiêu đề trang</label>
                                            <div><input type="text" id="title" name="title" class="form-control" value="{$title}"></div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 padding-top-1">
                                        <div>
                                            <label for="product_type" class="control-label">Id page</label>
                                            <div><input type="text" id="id" name="id" class="form-control" {if ($id > 0)}value="{$id}"{else}value=""{/if}></div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 padding-top-1">
                                        <div>
                                            <label for="product_id" class="control-label">&nbsp;</label>
                                            <div class="text_center">
                                                <button class="btn btn-primary" name="search_product" value="1" onclick="document.ListForm.act.value = ''; javascript:document.ListForm.submit();">Tìm kiếm</button>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- /.form-group -->
                            </div>
                        </div>
                        <div class="clear marginBottom_20"></div>
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
                        <tr valign="middle">
                            <th width="3%" title="check_all" class="text_center">
                                <input type="checkbox" value="1" id="ItemType_all_checkbox" onclick="Common_admin.isCheckedList(this.checked,{$total_row});	Common_admin.selectAllCheckbox(this.form, 'ItemType', this.checked, '#FFFFEC', 'white');">
                            </th>
                            <th width="6%" class="text_center"><a href="{$href_id}">ID</a> {$img_id}</th>
                            <th width="15%" class="text_left" nowrap >Tên page</a></th>
                            <th width="15%" class="text_left" nowrap >Lay out</a></th>
                            <th width="20%" class="text_left" nowrap >Tiêu đề</a></th>
                            <th width="20%" class="text_left">Mô tả</th>
                            <th width="15%" class="text_center" nowrap>Các chức năng</th>
                        </tr>
                        </thead>
                        <tbody>
                        {foreach from=$aryPage item=value}
                            <tr class="rowItems"  name="{$value.name}">
                                <td class="text_center text_middle">
                                    <input name="selected_ids[]" type="checkbox" value="{$value.id}" onclick="Common_admin.isCheckedList(this.checked, 0);Common_admin.select_checkbox(this.form, 'ItemType', this, '#FFFFEC', 'white');">
                                </td>
                                <td class="text_center text_middle">{$value.id}</td>
                                <td class="text_left text_middle"><a href="{$value.href}" title="Bố cục trang">{$value.name}</a></td>
                                <td class="text_left text_middle"><a href="{$value.href}" title="Bố cục trang">{$value.layout}</a></td>
                                <td class="text_left text_middle"><a href="{$value.href}" title="Bố cục trang">{$value.title}</a></td>
                                <td class="text_left text_middle">{$value.description}</td>
                                <td class="text_center text_middle">
                                    <a href="?page=page&act=edit&cmd=edit&id={$value.id}" title="Edit page" class="a_list_action"><span class="icon_edit"></span></a>
                                    <a href="?page=edit_page&id={$value.id}" title="Cài đặt page" class="a_list_action"><span class="icon_settings"></span></a>
                                    <a target="_blank" href="?page={$value.name}" title="View page" class="a_list_action"><span class="icon_view"></span></a>
                                    <a href="?page=page&act=copy&cmd=copy&id={$value.id}"title="Sao chép" class="a_list_action"><span class="icon_copy"></span></a>
                                    <a href="?page=page&act=delete_item&id={$value.id}" onclick="return confirm('Bạn có chắc chắn muốn xoá không!')" title="Xóa" class="a_list_action"><span class="icon_remove"></span></a>
                                </td>
                            </tr>
                        {/foreach}
                        </tbody>
                    </table>
                    <input type="hidden" name="act" value="{$smarty.request.act}" />
                    <input type="hidden" value="0" name="boxchecked">
                    <table width="100%" class="table_page_setting">
                        <tr>
                            <td class="paging_block">{$paging}</td>
                            <td class="gotopage_block"></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div> <!-- Small boxes (Stat box) -->
    </section>
</div>
