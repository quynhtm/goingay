<center>
	<div class="form_bound" style="margin: 0 auto; width:90%;text-align:left;">
	     <table cellpadding="4" width="100%" bgcolor="#D3E1F1">
		        <tr>
		            <td width="69%"  class="enbac-form-title"><b>{$mode} một Banner quảng cáo</b></td>
		            <td width="11%" class="form_title_button"><a href="javascript:void(0);" onclick="EditSimAdvarForm.submit();"><img alt="" src="style/images/admin/download_f2.png" class="icon_cmd"/><br>
		            Ghi l&#7841;i</a></td>
		            <td width="10%" class="form_title_button"><a href="?page={$page}"><img alt="" src="style/images/admin/back_f2.png" class="icon_cmd"/><br>
		            Quay l&#7841;i</a></td>
		        </tr>
			</table>
		<div class="form_content" style="float:left;width:100%;">
			{$msg}
			<form name="EditSimAdvarForm" method="post" action="?{$server_string}" enctype="multipart/form-data">
				<div class="form_input_label"><font color="blue">Tên banner</font></div>
				<div class="form_input">
					<input name="name_banner" type="text" id="name_banner" value="{$name_banner}" style="width:400px ">
				</div>
				<br/>
				<table>
					<tr>
						<td>
							<div class="form_input_label"><font color="blue">Ẩn / Hiện</font></div>
							<div class="form_input">
								<select name="status" id="status"style="width:140px;">
									{$optionStatus}
								</select>
							</div>
						</td>
						<td width="300">
							<div class="form_input_label" style="text-align: center"><font color="blue">Vị trí của banner</font></div>
							<div class="form_input" style="text-align: center">
								{$radioPosition}		
							</div>
						</td>
					</tr>
				</table>
				<br/>
				<div class="form_input_label"><font color="blue">Ảnh minh họa</font></div>
				<div class="form_input">
					<input name="image_product" type="file" id="image_product"><br />
					<img src="{$image_product_src}" />
					<input name="old_image" type="hidden" id="old_image" value="{$image_product}">
				</div>
				<br/>
				<div class="form_input_label"><font color="blue">Vị trí hiển thị</font></div>
				<div class="form_input" style="padding-bottom: 20px">
					<input name="order_item" type="text" id="order_item" value="{$order_item}" style="width:90px ">
				</div>
				<br/>
				<div class="form_input_label"><font color="blue">Link view</font></div>
				<div class="form_input" style="padding-bottom: 20px">
					<input name="link_view_product" type="text" id="link_view_product" value="{$link_detail}" style="width:400px ">
				</div>
		</form>
		</div>	
	</div>
</center>

