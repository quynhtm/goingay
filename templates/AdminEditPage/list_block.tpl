<table width="100%"  border="0" cellpadding="3" bgcolor="#FFFFFF" >
    <tr valign="top">
        <td>
            <div class="body">
                <div class="main">
        
                    <span style="color:#FF0000" title="Vùng [ {$name} ]">
                    	:: <b>{$name}</b> ::
                    </span>
                    <fieldset>
                        <table width="100%" cellpadding="5" cellspacing="0" >
                          <tr valign="top">
                            <td valign="top" bgcolor="#FFFFFF">
                            <table width="100%" border="0" cellpadding="3" cellspacing="0">
                                {foreach from=$items item=v_items}
                                <tr valign="top" {$hover}>
                                  <td align="left" valign="top" nowrap width="10">[ <strong>{$v_items.name}</strong> ]</td>
                                  <td align="left" valign="top" nowrap>
										{if $v_items.ajax_load eq 1}
											<a title="set hoặc unset ajaxload this module" href="?page=edit_page&cmd=unset_ajax_load&block_id={$v_items.id}&id={$id}">UnSetAjaxLoad</a>
										{else}
											<a title="set hoặc unset ajaxload this module" href="?page=edit_page&cmd=set_ajax_load&block_id={$v_items.id}&id={$id}">SetAjaxLoad</a>
										{/if}
										&nbsp;&nbsp;&nbsp;&nbsp;<a href="?page=edit_page&cmd=delete_block&block_id={$v_items.id}&id={$id}"><strong><img src="style/images/admin/delete_button.gif" width="12" height="12" border="0" ></strong></a>&nbsp;&nbsp;&nbsp;&nbsp;{$v_items.move_up}&nbsp;&nbsp;&nbsp;&nbsp;{$v_items.move_down}&nbsp;&nbsp;&nbsp;&nbsp;{$v_items.move_top}&nbsp;&nbsp;&nbsp;&nbsp;{$v_items.move_bottom}</td>
                                </tr>
                                {/foreach}
                              </table>
                            </td>
                          </tr>
                          <tr><td nowrap>
                          <a href="?page=module&page_id={$id}&region={$name}" title="Thêm modules vào [ {$name} ]">Thêm Module</a>
                          </td></tr>
                        </table>
                    </fieldset>
            	</div>
            </div>
        </td>
    </tr>
</table>
