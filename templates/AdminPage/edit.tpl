<div class="content-wrapper marginTop_50">
    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="col-sm-12">
        <div class="form_bound">
            <table cellpadding="4" width="100%" bgcolor="#D3E1F1">
                <tr>
                    <td width="80%" align="center" class="save-form-title"><h2 class="title_form">{$mode} page</h2></td>
                    <td width="10%" class="form_title_button">
                        <a class="icons_controll" href="javascript:void(0);" onclick="Common_admin.checkFormEdit();"><span alt="save" class="icon_save" ></span>Ghi lại</a>
                    </td>
                    <td width="10%" class="form_title_button">
                        <a class="icons_controll" href="?page={$page}"><span alt="save" class="icon_back" ></span>Quay lại</a>
                    </td>
                </tr>
            </table>

            <div class="form_content float_left border_road width_100">
            {$msg}
            <form name="EditForm" method="post" action="?{$server_string}">
                <div class="float_left width_100">
                    <label for="textName" class="control-label col-lg-12 marginTop_15">Tên trang<span style="color: red">(*)</span></label>
                    <div class="col-lg-6">
                        <input name="name" type="text" id="name" value="{$name}" class="form-control">
                    </div>
                </div>

                <div class="float_left width_100">
                    <label for="textName" class="control-label col-lg-12 marginTop_15">Tiêu đề<span style="color: red">(*)</span></label>
                    <div class="col-lg-6">
                        <input name="title" type="text" id="title" value="{$title}" class="form-control">
                    </div>
                </div>

                <div class="float_left width_100">
                    <label for="textName" class="control-label col-lg-12 marginTop_15">Chọn layout</label>
                    <div class="col-lg-6">
                        <select name="layout" id="layout" class="form-control">
                            {$option_layout}
                        </select>
                    </div>
                </div>

                <div class="float_left width_100">
                    <label for="textName" class="control-label col-lg-12 marginTop_15">Mô tả</label>
                    <div class="col-lg-8">
                        <textarea name="description" id="description" style="width:100%" rows="5" class="form-control">{$description}</textarea>
                    </div>
                </div>
                <input type="hidden" id="id_hiden" name="id" value="{$id}"/>
                <input type="hidden" name="act" value="{$smarty.request.act}" />
                <input type="hidden" name="cmd" value="{$smarty.request.cmd}" />
            </form>
            </div>
        </div>
        </div><!-- Small boxes (Stat box) -->
    </section>
</div>
