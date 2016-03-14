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
                                    <input id="user_name" name="user_name" class="form-control" type="text" value="{$user_name}">
                                </div>
                            </div>
                            <div class="float_left width_100">
                                <label for="textName" class="control-label col-lg-12 marginTop_15">Mật khẩu<span class="note">***</span></label>
                                <div class="col-lg-12">
                                    <input id="password" name="password" class="form-control" type="password" value="">
                                </div>
                            </div>
                            <div class="float_left width_100">
                                <label for="textName" class="control-label col-lg-12 marginTop_15">Full name</label>
                                <div class="col-lg-12">
                                    <input id="full_name" name="full_name" class="form-control" type="text" value="{$full_name}">
                                </div>
                            </div>
                        </div>

                        {*phần chọn option*}
                        <div class="float_left width_25">
                            <div class="float_left width_100">
                                <label for="textName" class="control-label col-lg-12 marginTop_15">Email<span class="note">***</span></label>
                                <div class="col-lg-12">
                                    <input id="email" name="email" class="form-control" type="text" value="{$email}">
                                </div>
                            </div>
                            <div class="float_left width_100">
                                <label for="textName" class="control-label col-lg-12 marginTop_15">Điện thoại</label>
                                <div class="col-lg-12">
                                    <input id="mobile_phone" name="mobile_phone" class="form-control" type="text" value="{$mobile_phone}">
                                </div>
                            </div>
                            <div class="float_left width_100">
                                <label for="textName" class="control-label col-lg-12 marginTop_15">Địa chỉ</label>
                                <div class="col-lg-12">
                                    <input id="address" name="address" class="form-control" type="text" value="{$address}">
                                </div>
                            </div>

                        </div>

                        {*phần chọn giá*}
                        <div class="float_left width_50">
                            <div class="float_left width_100">
                                <label for="textName" class="control-label col-lg-12 marginTop_15">Phân quyền</label>
                                <div class="col-lg-12 border_road" >
                                    {foreach from=$arrPermit item=permit name=name_permit key=id_permit}
                                        <div class="col-lg-4 marginTop_10">
                                            <input type="checkbox" name="permit[]" value="{$id_permit}" {if in_array($id_permit,$arr_permit_user) && isset($arr_permit_user) && count($arr_permit_user) > 0}checked{/if}> {$permit}
                                        </div>
                                    {/foreach}
                                </div>
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
{literal}
    <script type="text/javascript">
        jQuery(document).ready(function() {

        });

    </script>
{/literal}

