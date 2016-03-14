{if $user}
    <table width="100%" cellpadding="10" border="0">	
<tr>
          <td colspan="9" style="padding:5px;font-size:18px"><strong>Xem lỗi thành viên</strong> <a href="?page=shop&user_name={$user.user_name}" target="_blank"><span style="color:#0066CC; font-weight:bold; font-size:15px">{$user.user_name}</span></a> [ <a href="?page=user">Quản lý thành viên</a> ]  </td>
      </tr>
        <tr><td colspan="9"><div class="product-list-paging" style="margin: 0px; padding: 0px;">Tổng số lỗi: {$total}</div></td></tr>
        
        <tr>
            <td width="10%" rowspan="2" align="center" bgcolor="#FFC6FF"><strong>Loại lỗi</strong></td>
          <td  rowspan="2" align="center" bgcolor="#FFC6FF"><strong>Lý do</strong></td>
          <td colspan="2" align="center" bgcolor="#FFC6FF"><strong>Thời gian khoá (kiểm duyệt)</strong></td>
          <td width="17%" rowspan="2" align="center" bgcolor="#FFC6FF"><strong>Người khoá (kiểm duyệt)</strong></td>
          <td width="17%" rowspan="2" align="center" bgcolor="#FFC6FF"><strong>Người Thả</strong></td>
      </tr>
        <tr>
          <td width="18%" align="center" bgcolor="#FFC6FF"><strong>từ</strong></td>
          <td width="18%" align="center" bgcolor="#FFC6FF"><strong>đến</strong></td>
      </tr>
        {if $items}
        {foreach from=$items item=i_items}
        <tr bgcolor="{cycle values='#f0f0f0,#ffffff'}" id="{$i_items.id}">
            <td align="center">{if $i_items.type == 2} Kiểm duyệt {else} <span style="color:#0000FF;font-weight:bold">Khoá {if $i_items.type == 1}vĩnh viễn{elseif $i_items.type == 3}vĩnh viễn + cookies{else} theo ngày{/if}</span>{/if}</td>
            <td  align="left">{$i_items.note}</td>
            <td align="center">{$i_items.time}</td>
            <td align="center">{$i_items.time_expire}</td>
            <td align="center"><strong><a href="?page=shop&user_name={$i_items.admin_name}" target="_blank">{$i_items.admin_name}</a></strong></td>
            <td align="right"><strong>{if $i_items.unlock_time}{if $i_items.unlock_user}<a href="?page=shop&user_name={$i_items.unlock_user}" target="_blank">{$i_items.unlock_user}</a>{else}Hệ thống {/if} <font style="font-weight:normal">({$i_items.unlock_time})</font>{/if}</strong></td>
      </tr>	
        {/foreach}	
        {else}
        <tr><td align="center" height="50" colspan="9" bgcolor="{cycle values='#f0f0f0,#ffffff'}"><strong>Thành viên này chưa có lỗi nào hết</strong></td></tr>
        {/if}
    </table>
{else}   
	<table width="100%" cellpadding="10" border="0">	
        <tr>
          <td colspan="9" style="padding:5px;font-size:18px"><strong>Xem lỗi thành viên</strong> [ <a href="?page=user">Quản lý thành viên</a> ]  </td>
      </tr>
        <tr><td colspan="9">Thành viên không tồn tại</td></tr>
    </table>
{/if}