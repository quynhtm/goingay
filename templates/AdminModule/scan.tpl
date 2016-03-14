<div class="form_bound">
    <table cellpadding="0" width="800">
    	<tr>
         	<td class="form_title_button"><a href="?page=module&cmd=scan"><strong>Auto Scan Modules</strong></a></td>
	        
        	<td  class="form_title"><b><a href="?page=module">Danh sách Modules</a></b></td>
           <td class="form_title_button"><a href="?page=modulecmd=delete_cache">Xoá cache Modules</a></td>
		</tr>
	</table>
                        
    <table cellspacing="0" width="800">
        <tr bgcolor="#EFEFEF" valign="top">
            <td>
                <table width="100%">
                    <tr>
                        <td bgcolor="#FFFFFF">
                            <input type="hidden" name="update_scan" value="1" />
                            <div style="padding:10px;">
                                {$list_scan}
                            </div>
                        </td>
                    </tr>
               </table>
            </td>
        </tr>
    </table>
</div>
