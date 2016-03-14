<script language="javascript">
{literal}
function submit_user(item_name){	
	document.ListUserAdminForm.hd_ac.value = item_name;	
}
jQuery(document).ready(function() {
	jQuery("#created_time_from").datepicker();
	jQuery("#created_time_to").datepicker();
  });
</script>
{/literal}
<table width="100%" cellpadding="10" border="0">	
	<tr><td colspan="8"><div class="product-list-paging" style="margin: 0px; padding: 0px;">{$paging}</div></td></tr>
	<tr>
		<td colspan="8" bgcolor="#f0f0f0">
			<table cellpadding="5" border="0" width="100%">
				<tr>
					<td><font style="font-family:Verdana, Arial, Helvetica, sans-serif; color:#0000CC; font-size:14px"><strong>Các tin của thành viên: <a target="_blank" href="?page=shop&user_name={$user_info.user_name}">{$user_info.user_name} ({$total_item})</a></strong></font></td>
					<td width="40%" align="right">
						<strong>Thời gian (dd-mm-yyyy)</strong> từ ngày:
						<input type="text" name="created_time_from" id="created_time_from" value="{$created_time_from}" /> 
							tới 
						<input type="text" name="created_time_to" id="created_time_to" value="{$created_time_to}" />
					</td>
					<td align="right" width="7%"><input type="submit" name="search" value="Tìm kiếm" /></td>					
				</tr>
			</table>			
		</td>
	</tr>
	<tr>
		<td width="3%" align="center"><input onClick="selecte_all_checkbox('ItemListForm');" name="chk_ids" type="checkbox" id="list_item_0" value="1" title="Chọn tất cả"></td>
		<td width="5%" align="center">
			<span>
				<input onclick="if(!confirm('Bạn có chắc muốn xóa không?'))return false;" type="submit" name="del_all" id="del_all" value="Xóa bài viết" title="Xóa tất cả"/>
			</span>			
		</td>
		<td align="center"><strong>Tiêu đề</strong></td>
		<td width="9%" align="center"><strong>Ngày đăng tin</strong></td>
		<td width="9%" align="center"><strong>Lần up tin</strong></td>
		<td width="9%" align="center"><strong>Ngày up tin</strong></td>
		<td width="6%" align="center"><strong>Xử lý</strong></td>		
	</tr>
	{if $items}
	{foreach from=$items item=i_items}
	<tr bgcolor="{cycle values='#f0f0f0,#ffffff'}" id="{$i_items.id}">
		<td align="center"><input name="chk_id[]" type="checkbox" id="list_item_{$i_items.id}" value="{$i_items.id}"></td>
		<td colspan="2" align="left"><a href="?page=item_detail&id={$i_items.id}&ebname={$i_items.ebname}">{$i_items.name}</a><br /><br style="line-height:5px" /><span style="color:#FF0000;">{if $i_items.status==3}Tin theo dõi lừa đảo{elseif $i_items.status==2}Đang bị kiểm duyệt{elseif $i_items.status==-1}Tin đã bị xóa{/if}</span></td>
		<td align="center">{$i_items.created_time}</td>
		<td align="center">{$i_items.up_count}</td>
		<td align="center">{$i_items.up_time}</td>		
		<td align="center">
		 <a href="?page=post_item&cmd=edit&id={$i_items.id}">
			<img src="style/images/admin/edit.gif" width="16" title="sửa" />
		  </a>&nbsp;
		  <a onclick="if(!confirm('Bạn có chắc muốn xóa không?'))return false;" href="{$i_items.del_link}">
			<img src="style/images/admin/delete1.gif" title="Khóa nick" />
		  </a>
		</td>
	</tr>	
	{/foreach}	
	<tr><td colspan="8"><div class="product-list-paging" style="margin: 0px; padding: 0px;">{$paging}</div></td></tr>
	{else}
	<tr><td align="center" height="50" colspan="8" bgcolor="{cycle values='#f0f0f0,#ffffff'}"><strong>Chưa có thông tin nào cả</strong></td></tr>
	{/if}
</table>