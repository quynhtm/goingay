<div class="content-wrapper marginTop_50">
    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="col-sm-12">
            <div class="form_bound">
                 <table cellpadding="4" width="100%" bgcolor="#D3E1F1">
                    <tr>
                        <td width="70%" align="center" class="save-form-title"><h2 class="title_form">{$mode} user</h2></td>
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
                        <input type="hidden" id="id_hiden" name="id" value="{$id}"/>

                        {*phần chọn option*}
                        <div class="clear"></div>
                        <div class="float_left width_25">
                            <div class="float_left width_100">
                                <label for="textName" class="control-label col-lg-12 marginTop_15">User name<span class="note">***</span></label>
                                <div class="col-lg-12">
                                    <input id="user_name" name="user_name" class="form-control" type="text" value="{$item.user_name}" {if $act_edit == 1} disabled {/if}>
                                </div>
                            </div>
                            <div class="float_left width_100">
                                <label for="textName" class="control-label col-lg-12 marginTop_15">Mật khẩu<span class="note">***</span></label>
                                <div class="col-lg-12">
                                    {if $is_root == 1 || $is_permit == 1}
                                        <input id="password" name="password" class="form-control" type="password" value="">
                                    {else}
                                        <input id="password" name="password" class="form-control" type="password" value="" {if $id_online != $id} disabled {/if}>
                                    {/if}
                                </div>
                            </div>
                            <div class="float_left width_100">
                                <label for="textName" class="control-label col-lg-12 marginTop_15">Full name</label>
                                <div class="col-lg-12">
                                    <input id="full_name" name="full_name" class="form-control" type="text" value="{$item.full_name}">
                                </div>
                            </div>

                        </div>

                        {*phần chọn option*}

                        <div class="float_left width_25">
                            <div class="float_left width_100">
                                <label for="textName" class="control-label col-lg-12 marginTop_15">Email<span class="note">***</span></label>
                                <div class="col-lg-12">
                                    <input id="email" name="email" class="form-control" type="text" value="{$item.email}">
                                </div>
                            </div>
                            <div class="float_left width_100">
                                <label for="textName" class="control-label col-lg-12 marginTop_15">Điện thoại</label>
                                <div class="col-lg-12">
                                    <input id="mobile_phone" name="mobile_phone" class="form-control" type="text" value="{$item.mobile_phone}">
                                </div>
                            </div>
                            <div class="float_left width_100">
                                <label for="textName" class="control-label col-lg-12 marginTop_15">Địa chỉ</label>
                                <div class="col-lg-12">
                                    <input id="address" name="address" class="form-control" type="text" value="{$item.address}">
                                </div>
                            </div>

                        </div>

                        {*phần chọn option*}
                        <div class="float_left width_25">
                            {if $is_root == 1}
                            <div class="float_left width_100">
                                <label for="textName" class="control-label col-lg-12 marginTop_15">Kiểu Account</label>
                                <div class="col-lg-12">
                                    <select name="is_shop" id="is_shop" class="form-control">
                                        {$optionTypeShop}
                                    </select>
                                </div>
                            </div>
                            <div class="float_left width_100">
                                <label for="textName" class="control-label col-lg-12 marginTop_15">Số lượng SP tối đa</label>
                                <div class="col-lg-12">
                                    <select name="limit_shop_product" id="limit_shop_product" class="form-control">
                                        {$optionLimitProduct}
                                    </select>
                                </div>
                            </div>
                            {/if}
                            <div class="float_left width_100">
                                <label for="shop_name" class="control-label col-lg-12 marginTop_15">Tên Shop</label>
                                <div class="col-lg-12">
                                    <input id="shop_name" name="shop_name" class="form-control" type="text" value="{$item.shop_name}">
                                </div>
                            </div>
                        </div>


                        <div class="clear"></div>
                        <div class="float_left width_100">
                            <div class="float_left width_100">
                                <label for="textName" class="control-label col-lg-12 marginTop_15">Ảnh trang chủ của shop</label>
                                <div class="col-lg-12">
                                    <input name="avatar" type="file" id="avatar"><br />
                                    <img src="{$avatar_src}" />
                                    <input name="old_avatar" type="hidden" id="old_avatar" value="{$avatar}">
                                </div>
                            </div>
                        </div>
                        <div class="clear"></div>
                        <div class="float_left width_100">
                            <div class="float_left width_100">
                                <label for="textName" class="control-label col-lg-12 marginTop_15">Giới thiệu của shop</label>
                                <div class="col-lg-12">
                                    {$editor_contact}
                                </div>
                            </div>
                        </div>

                        {*phần chọn quyền*}
                        {if $is_root == 1 || $is_permit == 1}
                        <div class="float_left width_100">
                            <div class="float_left width_100">
                                <label for="textName" class="control-label col-lg-12 marginTop_15">Phân quyền</label>
                                <div class="col-lg-12" >
                                    {foreach from=$arrPermit item=group_permit name=name_group_permit key=key_group_permit}
                                        <div class="clear"></div>
                                        <label for="textName" class="control-label col-lg-10 marginTop_15" style="border-bottom: 1px solid #ccc" >{$group_permit.name_group_permit}</label>
                                        <div class="clear"></div>
                                        {foreach from=$group_permit.group_permit item=permit name=name_permit key=id_permit}
                                            <div class="col-lg-2 marginTop_10">
                                                <input type="checkbox" name="permit[]" value="{$id_permit}" {if in_array($id_permit,$arr_permit_user) && isset($arr_permit_user) && count($arr_permit_user) > 0}checked{/if}> {$permit}
                                            </div>
                                        {/foreach}
                                    {/foreach}
                                </div>
                            </div>
                        </div>
                        {/if}
                        <input type="hidden" name="act" value="{$smarty.request.act}" />
                    </form>
                </div>
                <div class="clear"></div>
            </div>

        </div><!-- Small boxes (Stat box) -->
    </section>
</div>


<!--Popup upload ảnh-->
{literal}
	<script type="text/javascript">
        jQuery(document).ready(function() {

        });

	</script>
{/literal}

