<div class="content-wrapper marginTop_50" >
    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="col-sm-12">
            <div class="save-bound">
                {*Vùng action*}
                <table cellpadding="0" cellspacing="1" width="100%" bgcolor="#D3E1F1">
                    <tr>
                        <td width="99%" align="center" class="save-form-title"><a href="?page={$page}"><h2 class="title_form">Quản lý đơn hàng</h2></a></td>
                        <td class="form_title_button">
                            <a class="icons_controll" href="?page={$page}"><span alt="Publish" class="icon_home" ></span>Home</a>
                        </td>
                    </tr>
                </table>

                {*Vùng tìm kiếm*}
                <div class="clear paddingBottom10"></div>
                <div class="form_content float_left border_road width_100" style="padding: 10px">
                    <div class="col-lg-12 padding-top-1">
                        <label for="" style="font-size:16px">Vùng điều kiện lọc </label>
                    </div>

                    <div class="clear marginBottom_10"></div>
                        <div class="float_left width_33 marginBottom_15">
                            <div class="float_left width_100">
                                <label for="customer_name" class="control-label col-lg-12">Tên khách hàng</label>
                                <div class="col-lg-10"><input type="text" id="customer_name" name="customer_name" class="form-control" value="{$search.customer_name}"></div>
                            </div>
                            <div class="float_left width_100">
                                <label for="mobile_phone" class="control-label col-lg-12 marginTop_10">Điện thoại khách hàng</label>
                                <div class="col-lg-10"><input type="text" id="mobile_phone" name="mobile_phone" class="form-control" value="{$search.mobile_phone}"></div>
                            </div>
                            <div class="float_left width_100">
                                <label class="control-label col-lg-12 marginTop_10">Trạng thái đơn hàng</label>
                                <div class="col-lg-10"><select name="status" class="form-control input-sm">{$search.status}</select></div>
                            </div>
                        </div>

                        <div class="float_left width_33">
                            <div class="float_left width_100">
                                <label for="product_name" class="control-label col-lg-12 ">Tên sản phẩm</label>
                                <div class="col-lg-10"><input type="text" id="product_name" name="product_name" class="form-control" value="{$search.product_name}"></div>
                            </div>
                            <div class="float_left width_100">
                                <label for="product_name" class="control-label col-lg-12 marginTop_10">Mã sản phẩm</label>
                                <div class="col-lg-10"><input type="text" id="product_id" name="product_id" class="form-control" value="{$search.product_id}"></div>
                            </div>
                            <div class="float_left width_100">
                                <label class="control-label col-lg-12 marginTop_10">Danh mục sản phẩm</label>
                                <div class="col-lg-10"><select name="category_id" class="form-control input-sm">{$search.category_id}</select></div>
                            </div>
                        </div>

                        <div class="float_left width_33">
                            <div class="float_left width_100">
                                <label for="product_status" class="control-label col-lg-12 ">Thời gian tạo đơn hàng từ ngày</label>
                                <div class="col-lg-10"><input id="start_time" name="start_time" class="form-control" type="text" value="{$search.start_time}"></div>
                            </div>

                            <div class="float_left width_100">
                                <label class="control-label col-lg-12 marginTop_10">Đến ngày</label>
                                <div class="col-lg-10"><input id="end_time" name="end_time" class="form-control" type="text" value="{$search.end_time}"></div>
                            </div>

                            <div class="float_left width_100">
                                <label for="product_id" class="control-label col-lg-12 marginTop_10">&nbsp;</label>
                                <div class="text_center col-lg-10">
                                    <button class="btn btn-primary" name="search_product" value="1" onclick="document.ListForm.act.value = ''; javascript:document.ListForm.submit();">Tìm kiếm</button>
                                </div>
                            </div>
                        </div>

                    <div class="float_left width_33">
                        <div class="float_left width_100">
                            <a title="Xuất excel theo đơn hàng, mỗi đơn hàng 1 file" style="color:#025A8D;text-align: center;text-decoration: none;border:1px solid #FBFBFB;cursor:pointer;display:block;float:left;padding:1px 5px;width: 85px;" href="javascript:void(0);" onclick="exportExcelNCC();">
                                <span alt="Xuất excel3" style="display:block;float:none;height:32px;margin:0 auto;width:32px;background: url('style/images/admin/excel.png') top left no-repeat;" ></span>
                                Xuất Excel<br />NCC
                            </a>
                        </div>
                    </div>
                </div>

                {*Vùng hiển thị kết quả*}
                {if $items}
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
                                <th width="35%" class="text_left">Thông tin sản phẩm</th>
                                <th width="20%" class="text_left">Thông tin đơn hàng</th>

                                <th width="20%" class="text_left">Thông tin Khách hàng</th>
                                <th width="20%" class="text_center">Ghi chú</th>

                                <th width="3%" class="text_center">Status</th>
                                <th width="10%" class="text_center">Xóa</th>
                            </tr>
                            </thead>
                            <tbody>
                            {foreach from=$items item=value name=list_item}
                                <tr id="ItemType_tr_{$value.id}">
                                    <td class="text_center text_middle">{$stt+$smarty.foreach.list_item.index+1}</td>
                                    <td class="text_left text_middle">
                                        <a href="{$value.link_detail}" target="_blank" title="xem chi tiết">{$value.product_name}</a><br/>
                                        Mã SP: <b>{$value.product_id}</b><br/>
                                        Danh mục: {$value.category_name}<br/>
                                    </td>

                                    <td class="text_left text_middle">
                                        SL: <span><b>{$value.num_item}</b></span><br/>
                                        Giá: <span><b>{$value.price|bm_money_format} đ</b></span><br/>
                                        Tổng: <span class="price"><b>{$value.total_price|bm_money_format} đ</b></span><br/>
                                        Ngày: {$value.date}
                                    </td>

                                    <td class="text_left text_middle">
                                        {if $value.customer_name != ''}{$value.customer_name}<br/>{/if}
                                        {if $value.mobile_phone != ''}{$value.mobile_phone}<br/>{/if}
                                        {if $value.address != ''}{$value.address}<br/>{/if}
                                    </td>

                                    <td class="text_left text_middle">
                                        {if $value.customer_note != ''} <b>Khách hàng:</b> <br/>{$value.customer_note}<br/>{/if}
                                        {if $value.shop_note != ''} <b>Shop ghi chú:</b> <br/>{$value.shop_note}{/if}
                                    </td>

                                    <td class="text_center text_middle">
                                        {if $value.status ==1}
                                            <a href="?page={$page}&act=status&id={$value.id}&status={$value.status}" title="Click để ẩn"><span class="icon_true"></span></a>
                                        {else}
                                            <a href="?page={$page}&act=status&id={$value.id}&status={$value.status}" title="Click để hiện"><span class="icon_fasle"></span></a>
                                        {/if}
                                    </td>
                                    <td class="text_center text_middle">
                                        {*<a href="?page={$page}&act=edit&id={$value.id}" title="Edit item" class="a_list_action"><span class="icon_edit"></span></a>*}
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
                {else}
                    <h2 class="note marginTop10 text_center"> Không có dữ liệu</h2>
                {/if}
                <input type="hidden" name="act" value="{$smarty.request.act}" />
                <input type="hidden" id="cmd" name="cmd" value="" />
                <input type="hidden" value="0" name="boxchecked">
            </div>
        </div> <!-- Small boxes (Stat box) -->
    </section>
</div>

{literal}
    <script type="text/javascript">
        jQuery(document).ready(function() {
            //set time
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
        function exportExcelNCC() {
            jQuery('#cmd').val('saveFileExcelNCC');
            document.forms[0].submit();
            jQuery('#cmd').val('');
        }
    </script>
{/literal}
