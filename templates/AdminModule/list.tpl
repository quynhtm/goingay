{literal}
<script type="text/javascript">
function filter(v) {
	var str;
	if(v == '' || v == ' ') return;
	
	v = v.toLowerCase();
	jQuery('.rowItems').each(function(){
		str = jQuery(this).attr('name').toLowerCase();
		if(str.search(''+v+'') == -1) {
			jQuery(this).attr('style','display:none');
		}
		else {
			jQuery(this).attr('style','display:""');
		}
	});
}
</script>
{/literal}
<div class="content-wrapper marginTop_60" >
    <!-- Main content -->
    <section class="content">
        <div class="col-sm-12"><!-- Small boxes (Stat box) -->
        <div class="form_bound">
            <div class="float_left width_100 marginBottom_10">
                {*Vùng action*}
                <table cellpadding="0" cellspacing="1" width="100%" bgcolor="#D3E1F1">
                    <tr>
                        <td width="99%" align="center" class="save-form-title"><a href="?page={$page}"><h2 class="title_form">Danh sách Module</h2></a></td>
                        <td class="form_title_button">
                            <a class="icons_controll" href="?page={$page}"><span alt="Publish" class="icon_home" ></span>Home</a>
                        </td>
                        <td class="form_title_button">
                            <a class="icons_controll" href="?page=module&cmd=scan"><span alt="Publish" class="icon_load" ></span>Scan</a>
                        </td>
                        <td class="form_title_button" >
                            <a class="icons_controll" href="?page=module&cmd=delete_cache"><span alt="Delete" class="icon_delete" ></span>Xóa</a>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="clear marginBottom_10"></div>
            <div class="float_left width_100">
                <div class="area_content_select_search ">
                    <div class="col-lg-12 padding-top-1">
                        <label for="" style="font-size:16px">Vùng điều kiện lọc </label>
                    </div>
                    <div class="clear paddingBottom5"></div>
                    <div class="box">
                        <div id="div-4" class="body">
                            <div class="form-group">
                                <div class="col-lg-4 padding-top-1 marginBottom_10">
                                    <div>
                                        <label for="product_id" class="control-label">Tên Module</label>
                                        <div>
                                            <input name="name"  onkeyup="Common_admin.filter(this.value)" type="text" id="name" class="form-control"  value="{$name}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 padding-top-1 marginBottom_10">
                                    <div>
                                        <label for="product_id" class="control-label">&nbsp;</label>
                                        <div>
                                            <input type="submit" value="Tìm kiếm"  class="btn btn-primary">
                                        </div>
                                    </div>
                                </div>
                            </div><!-- /.form-group -->
                        </div>
                    </div>
                </div>
            </div>

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
                        <th width="5%" class="text_center">STT</th>
                        <th width="10%" class="text_center">Id</th>
                        <th width="20%" class="text_center">Module</th>
                        <th width="65%" class="text_center">Page</th>
                    </tr>
                    </thead>
                    <tbody>
                    {foreach from=$aryModules item=value name=list_item}
                        <tr class="rowItems" name="{$value.name}">
                            <td class="text_center text_middle">{$stt+$smarty.foreach.list_item.index+1}</td>
                            <td class="text_center text_middle">{$value.id}</td>
                            <td class="text_center text_middle" {$value.onclick}>{$value.name}</td>
                            <td class="text_left text_middle">
                                {foreach from=$value.pages item=page}
                                    <strong>[<a href="?page={$page.name}">{$page.name}</a>]&nbsp;&nbsp;&nbsp;</strong>
                                {/foreach}
                            </td>
                        </tr>
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
        </div><!-- Small boxes (Stat box) -->
    </section>
</div>
