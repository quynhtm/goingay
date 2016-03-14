
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


