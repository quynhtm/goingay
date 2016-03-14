<div class="content-wrapper" style="padding-top: 50px">
    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="col-sm-12">
        <div class="save-bound">
            {*Vùng action*}
            <table cellpadding="0" cellspacing="1" width="100%" bgcolor="#D3E1F1">
                <tr>
                    <td width="99%" align="center" class="save-form-title" style="text-align: center; color: #32CD32"><a href="?page={$page}"><h2>{$title_page}</h2></a></td>
                    <td class="form_title_button">
                        <a style="color:#025A8D;text-align: center;text-decoration: none;border:1px solid #FBFBFB;cursor:pointer;display:block;float:left;padding:1px 5px;width: 60px;"
                           href="?page={$page}">
                            <span alt="Publish" style="display:block;float:none;height:32px;margin:0 auto;width:32px;background: url('style/images/admin/icon-products-home.png') top left no-repeat;" ></span>
                            Home</a>
                    </td>
                    <td class="form_title_button">
                        <a style="color:#025A8D;text-align: center;text-decoration: none;border:1px solid #FBFBFB;cursor:pointer;display:block;float:left;padding:1px 5px;width: 60px;"
                           href="javascript:void(0);" onclick="document.NewForm.act.value = 'publishAll'; checkform();">
                            <span alt="Publish" style="display:block;float:none;height:32px;margin:0 auto;width:32px;background: url('style/images/admin/icon-32-publish.png') top left no-repeat;" ></span>
                            Hiện</a>
                    </td>
                    <td class="form_title_button">
                        <a style="color:#025A8D;text-align: center;text-decoration: none;border:1px solid #FBFBFB;cursor:pointer;display:block;float:left;padding:1px 5px;width: 60px;"
                           href="javascript:void(0);" onclick="document.NewForm.act.value = 'unpublishAll';checkform();">
                            <span alt="UnPublish" style="display:block;float:none;height:32px;margin:0 auto;width:32px;background: url('style/images/admin/icon-32-unpublish.png') top left no-repeat;" ></span>
                            Ẩn</a>
                    </td>
                    <td class="form_title_button">
                        <a style="color:#025A8D;text-align: center;text-decoration: none;border:1px solid #FBFBFB;cursor:pointer;display:block;float:left;padding:1px 5px;width: 60px;" href="?page={$page}&act=add">
                            <span alt="New" style="display:block;float:none;height:32px;margin:0 auto;width:32px;background: url('style/images/admin/icon-32-new.png') top left no-repeat;" ></span>
                            Thêm</a>
                    </td>
                    <td class="form_title_button" >
                        <a style="color:#025A8D;text-align: center;text-decoration: none;border:1px solid #FBFBFB;cursor:pointer;display:block;float:left;padding:1px 5px;width: 60px;"
                           href="javascript:void(0);" onclick="confirmDelete();">
                            <span alt="Delete" style="display:block;float:none;height:32px;margin:0 auto;width:32px;background: url('style/images/admin/icon-32-delete.png') top left no-repeat;" ></span>
                            Xóa</a>
                    </td>
                </tr>
            </table>

            {*Vùng tìm kiếm*}
            <div class="clear paddingBottom10"></div>
            <div style="float:left;width:100%">
                <div id="area_content_select_search" style="border:solid 1px #ccc; width:100%;float:right; padding: 3px">
                    <div class="col-lg-12 padding-top-1">
                        <label for="" style="font-size:16px">Vùng điều kiện lọc </label>
                    </div>
                    <div class="clear paddingBottom5"></div>

                    <div class="box">
                        <div id="div-4" class="body">
                            <div class="form-group">
                                <div class="col-lg-4 padding-top-1">
                                    <div>
                                        <label for="product_id" class="control-label">Tiêu đề tin</label>
                                        <div><input type="text" id="product_id" name="product_id" class="form-control" value="{$search.title_news}"></div>
                                    </div>
                                    <div>
                                        <label for="product_id" class="control-label">Trạng thái</label>
                                        <div><input type="text" id="product_name" name="product_name" class="form-control" value="{$search.title_news}"></div>
                                    </div>
                                </div>

                                <div class="col-lg-4 padding-top-1">
                                    <div>
                                        <label for="product_type" class="control-label">Loại sản phẩm</label>
                                        <div>
                                            <select name="product_type" class="form-control input-sm">{$search.type_new}</select>
                                        </div>
                                    </div>

                                    <div>
                                        <label for="supplier_id" class="control-label">Nhà cung cấp</label>
                                        <div>
                                            <select name="supplier_id" id="supplier_id" class="form-control input-sm chosen-select-deselect" tabindex="12" data-placeholder="Chọn nhà cung cấp">
                                                {$search.type_new}
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 padding-top-1">
                                    <div>
                                        <label for="product_status" class="control-label">Trạng thái</label>
                                        <div><select name="product_status" class="form-control input-sm">{$search.type_new}</select></div>
                                    </div>
                                    <div>
                                        <label class="control-label">Danh mục sản phẩm</label>
                                        <div><select name="category_id" class="form-control input-sm">{$search.hots_new}</select></div>
                                    </div>
                                    <div>
                                        <label for="product_id" class="control-label">&nbsp;</label>
                                        <div>
                                            <button class="btn btn-primary" name="search_product" value="1" onclick="document.NewForm.act.value = '';
            javascript:document.NewForm.submit();">Tìm kiếm</button>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- /.form-group -->
                        </div>
                    </div>
                </div>
            </div>

            {*Vùng hiển thị kết quả*}
            <div style="clear:both;" class="paddingBottom10"></div>
            <div class="form_content">
                <a name="top_anchor"></a>
                <div style="border:2px solid #FFFFFF;">
                    <table width="100%" class="table_page_setting">
                        <tr>
                            <td class="paging_block">{$paging}</td>
                            <td class="gotopage_block"></td>
                        </tr>
                    </table>
                    <table id="adminContent" width="100%" cellpadding="5" cellspacing="1" border="1" style="border-collapse:collapse" bordercolor="#C3C3C3">
                        <thead>
                        <tr bgcolor="#E6E6E6" style="line-height:20px">
                            <th width="3%" class="text-center">STT</th>
                            <th width="3%" title="check_all" class="text-center"><input type="checkbox" value="1" id="ItemType_all_checkbox" onclick="isChecked(this.checked,{$total_row});	selectAllCheckbox(this.form, 'ItemType', this.checked, '#FFFFEC', 'white');"></th>
                            <th width="3%" class="text-center">Ảnh</th>
                            <th width="40%" class="text-center">Tiêu đề tin</th>
                            <th width="20%" class="text-center">Tin thuộc</th>
                            <th width="6%" class="text-center">Tin host</th>
                            <th width="2%" class="text-center">Ẩn/ Hiện</th>
                            <th width="2%" class="text-center">Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                        {foreach from=$items item=i_items name=list_item}
                            <tr bgcolor="{cycle values='#f0f0f0,#ffffff'}" {$hover} id="ItemType_tr_{$i_items.id}">
                                <td align="center">{$stt+$smarty.foreach.list_item.index+1}</td>
                                <td align="center">
                                    <input name="selected_ids[]" type="checkbox" value="{$i_items.id}" onclick="isChecked(this.checked, 0);select_checkbox(this.form, 'ItemType', this, '#FFFFEC', 'white');">
                                </td>
                                <td align="center">
                                    <div style="position: relative;">
                                        <div style="position: relative; z-index: 10">
                                            <img src="{$i_items.images}" class='imge_hover' id='{$i_items.id}'/>
                                        </div>
                                        <div id='div_hover_{$i_items.id}'style="position: absolute; bottom: 30px; left: 40px; border: 2px solid #ccc; padding: 5px; background: #F4F9FF; z-index: 1000; display: none">
                                            <img src="{$i_items.images_big}"/>
                                            <br/>Ngày tạo: {$i_items.create_time|date_format:"%d-%m-%Y"}
                                            <br/>Ngày sửa: {$i_items.modify_time|date_format:"%d-%m-%Y"}
                                        </div>
                                    </div>
                                </td>
                                <td align="left">
                                    <b style='color: green'>[{$i_items.id}]</b> <a href="?page={$page}&act=edit&id={$i_items.id}"><b>{$i_items.name}</b></a>
                                </td>
                                <td align="center">{$i_items.cat_news_name}</td>
                                <td align="center">{if $i_items.hot_news == 1} Có {else} Không {/if}</td>
                                <td align="center">
                                    {if $i_items.status ==1}
                                        <a href="?page={$page}&act=status&id={$i_items.id}&status={$i_items.status}" title="Click để ẩn">
                                            <img src="style/images/admin/tick.png" width="16" height="16">
                                        </a>
                                    {else}
                                        <a href="?page={$page}&act=status&id={$i_items.id}&status={$i_items.status}" title="Click để hiện">
                                            <img src="style/images/admin/publish_x.png" width="16" height="16">
                                        </a>
                                    {/if}
                                </td>
                                <td align="center"><a href="?page={$page}&act=edit&id={$i_items.id}" title="Edit item"><img src="style/images/admin/b_edit.png"></a> </td>
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
            </div>

            <input type="hidden" name="act" value="{$smarty.request.act}" />
            <input type="hidden" value="0" name="boxchecked">
        </div>




            <div class="form_bound" style="width=100%">
                <table cellpadding="0" cellspacing="1" width="100%" bgcolor="#D3E1F1">
                    <tr>
                        <td width="70%" class="enbac-form-title"><a href="?page={$page}">LIST BANNER QUANG CAO TREN SIMLEMAT.COM</a></td>
                        <td width="6%" class="form_title_button"><a href="?page={$page}&cmd=add"><img alt="" src="style/images/admin/new_f2.png" style="text-align:center" class="icon_cmd"/><br>Th&ecirc;m</a></td>
                    </tr>
                </table>

                <div class="form_content">
                <table cellspacing="0" width="100%">
                <tr bgcolor="#EFEFEF" valign="top">
                    <td width="100%" align="right" style="padding:10px">
                        <div id="id" style="padding-right:120px">
                            <select name="position" id="position"style="width:135px;">
                                {$optionPosition}
                            </select>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="submit" value="Tìm kiếm" name="submit_button">
                        </div>
                        {if $paging}
                          <div class="product-list-paging" id="phan_trang">{$paging}</div>
                         {/if}

                    <table cellspacing="0" width="100%">
                    <tr>
                        <td width="100%">
                            {if $items}
                            <div style="border:2px solid #FFFFFF;padding-left:10px">
                            <table id="adminContent" width="100%%" cellpadding="5" cellspacing="1" border="1" style="border-collapse:collapse" bordercolor="#C3C3C3">
                                <thead>
                                <tr valign="middle" bgcolor="#E6E6E6" style="line-height:20px">
                                    <th width="5%"align="center">Id</th>
                                    <th width="10%"align="center">Tên banner</th>
                                    <th width="20%"align="center">link view</th>
                                    <th width="20%"align="center">Image</th>
                                    <th width="5%" align="center">Vị trí</th>
                                    <th width="5%" align="center">Order</th>
                                    <th width="3%" align="center">Ẩn/Hiện</th>
                                    <th width="6%" align="center">Thao tác</th>
                                </tr>
                                </thead>
                                <tbody>
                                {foreach from=$items item=i_items}
                                      <tr bgcolor="{cycle values='#f0f0f0,#ffffff'}" {$hover}>
                                        <td align="center">{$i_items.id}</td>
                                        <td align="center"><a href="?page={$page}&cmd=edit&id={$i_items.id}">{$i_items.title}</a></td>
                                        <td align="center"><a href="?page={$page}&cmd=edit&id={$i_items.id}">{$i_items.link_view}</a></td>
                                        <td align="center">	<img src="{$i_items.image}"/></a></td>
                                        <td align="center">{$i_items.name_position}</td>
                                        <td align="center">{$i_items.order_item}</td>
                                        <td align="center">
                                            {if $i_items.status ==1}
                                                <a href="?page={$page}&cmd=status&id={$i_items.id}&status={$i_items.status}">
                                                    <img src="style/images/admin/tick.png" alt="hiển thị Solo.vn" width="16" height="16">
                                                </a>
                                             {else}
                                                <a href="?page={$page}&cmd=status&id={$i_items.id}&status={$i_items.status}">
                                                    <img src="style/images/admin/publish_x.png" alt="Không hiển thị Solo.vn" width="16" height="16">
                                                </a>
                                             {/if}
                                        </td>
                                        <td align="center">[ <a href="?page={$page}&cmd=edit&id={$i_items.id}">Sửa</a> ] [ <a href="?page={$page}&cmd=delete&id={$i_items.id}" onclick="return confirm('Bạn có chắc chắn muốn xoá không!')"><font color="red">Xoá</font></a> ]</td>
                                      </tr>
                                 {/foreach}
                                </tbody>
                            </table>
                            <table width="100%" class="table_page_setting">
                                <tr>
                                    <td class="paging_block">{$paging}</td>
                                    <td class="total_item"><strong>C&oacute; {$total_row} item</strong></td>
                                    <td class="gotopage_block"></td>
                                 </tr>
                            </table>
                            <input type="hidden" name="cmd" value="" id="cmd"/>
                        </div>
                        {/if}
                        <input type="hidden" name="cmd" value=""/>
                       </td>
                    </tr>
                    </table>

                </tr>
                </table>
                </div>

                <div class="clear"></div>
                <div id="sum_view_img">
                    <div id="infor_img" style="float:left"></div>
                </div>
            </div>

        </div>
    </section>
</div>


