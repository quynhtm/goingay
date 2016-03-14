<table cellpadding="4" cellspacing="0" width="100%">
	<tr>
	  <td colspan="4" style="padding:5px;font-size:18px"><strong>Thông tin thành viên</strong> <a href="?page=shop&user_name={$user.user_name}" target="_blank"><span style="color:#0066CC; font-weight:bold; font-size:15px">{$user.user_name}</span></a> [ <a href="?page=user">Quản lý thành viên</a> ]  </td>
  </tr>
	<tr>
	  <td width="27%" align="right"><span class="personal_style_form"> <span class="personal_laber"><strong>H&#7885; v&#224; t&#234;n: </strong></span></span></td>
	  <td width="2%">&nbsp;</td>
	  <td width="31%">{$user.full_name}</td>
	  <td width="40%" rowspan="5">{$user.avatar_url}</td>
  </tr>
	<tr>
	  <td align="right"><span class="personal_laber"><strong>&#272;&#7883;a ch&#7881;</strong></span></td>
	  <td>&nbsp;</td>
	  <td>{$user.address}</td>
  </tr>
	<tr>
	  <td align="right"><span class="personal_laber"><strong>Ng&#224;y sinh</strong></span></td>
	  <td>&nbsp;</td>
	  <td>{$user.birth_day}</td>
  </tr>
	<tr>
	  <td align="right"><span class="personal_laber"><strong>Số CMT</strong></span></td>
	  <td>&nbsp;</td>
	  <td>{$user.id_card}</td>
  </tr>
	<tr>
	  <td align="right"><span class="personal_laber"><strong>S&#7889; &#273;i&#7879;n tho&#7841;i</strong></span></td>
	  <td>&nbsp;</td>
	  <td>{$user.home_phone} {if $user.home_phone}{$user.show_home_phone} {if $user.phone_verify}Đã chứng thực{else}Chưa chứng thực{/if}{/if}</td>
  </tr>
	<tr>
	  <td align="right"><span class="personal_style_form clearfix"><span class="personal_laber"><strong>Di &#273;&#7897;ng</strong></span></span></td>
	  <td>&nbsp;</td>
	  <td colspan="2">{$user.mobile_phone}</td>
  </tr>
	<tr>
	  <td align="right"><span class="personal_laber"><strong>Fax</strong></span></td>
	  <td>&nbsp;</td>
	  <td colspan="2">{$user.fax}</td>
  </tr>
	<tr>
	  <td align="right"><span class="personal_laber"><strong>YahooID</strong></span></td>
	  <td>&nbsp;</td>
	  <td colspan="2">{$user.yahoo_id}</td>
  </tr>
	<tr>
	  <td align="right"><span class="personal_laber"><strong>SkypeID</strong></span></td>
	  <td>&nbsp;</td>
	  <td colspan="2">{$user.skype_id}</td>
  </tr>
	<tr>
	  <td align="right"><span class="personal_laber"><strong>Email</strong></span></td>
	  <td>&nbsp;</td>
	  <td colspan="2"><a href="mailto:{$user.email}">{$user.email}</a> {$user.show_email}  {$user.email_alert}</td>
  </tr>
	<tr>
	  <td align="right"><span class="personal_laber"><strong>Website</strong></span></td>
	  <td>&nbsp;</td>
	  <td colspan="2"><a href="{$user.website}" target="_blank">{$user.website}</a> </td>
  </tr>
	<tr>
	  <td align="right"><span class="personal_laber"><strong>Blast</strong></span></td>
	  <td>&nbsp;</td>
	  <td colspan="2">{$user.blast}</td>
  </tr>
	
	<tr>
	  <td align="right"><strong>Chữ ký</strong></td>
	  <td>&nbsp;</td>
	  <td colspan="2">{$user.signature}</td>
  </tr>
	<tr>
	  <td align="right"><strong>OpenID</strong></td>
	  <td>&nbsp;</td>
	  <td colspan="2">
           <div style="font-weight:bold;color:#3399FF;width:500px;float:left;line-height:15px">
           {foreach from=$openids item=openid}
                <span title="{$openid.openid_url}">{$openid.openid}</span><br />
           {/foreach}           </div>
           <div style="clear:left"><span></span></div>      </td>
  </tr>
    <tr>
      <td align="right"><strong>Tham gia</strong></td>
      <td>&nbsp;</td>
      <td colspan="2"><strong>{$user.create_time}</strong> {$user.reg_ip}</td>
    </tr>
    <tr>
      <td align="right"><strong>Tổng số Giao dịch</strong></td>
      <td>&nbsp;</td>
      <td colspan="2">{$user.total_transaction} [ <a href="?page=user&amp;cmd=item_list&amp;user_id={$user.id}">Danh sách các giao dịch</a> ]</td>
    </tr>
    <tr>
      <td align="right"><strong>Lượt up tin</strong></td>
      <td>&nbsp;</td>
      <td colspan="2">{$user.up_item}</td>
    </tr>
  <tr>
	  <td align="right"><strong>Tình trạng</strong></td>
	  <td>&nbsp;</td>
	  <td colspan="2"> {$user.status}</td>
  </tr>
</table>
