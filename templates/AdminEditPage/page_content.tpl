<div class="content-wrapper marginTop_60" >
    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="col-sm-12">
            <div class="save-bound">
                <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="white">
                <tr>
                    <td style="padding-left:10px;">
                        <table cellpadding="5px" align="left">
                        <tr>
                        <td><a href="?page={$name}">Tới trang - {$name}</a> &nbsp;|&nbsp;
                          <a href="?page=page&cmd=edit&id={$id}">Sửa page</a> &nbsp;|&nbsp;<a href="?page=page">PAGES list</a>	  </td>
                        </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="padding-left:10px;">
                        <table width="100%"><tr>
                            <td><b>Layout:</b></td>
                            <td width="100%" align="left">
                                <div class="col-lg-2 padding-top-1">
                                    <select name="layout" id="layout" class="form-control" onchange="change_layout(this.value);">{$option_layout}</select>
                                </div>
                                <script type="text/javascript">
                                    {literal}
                                    function change_layout(id){
                                        location='?page=edit_page&id={/literal}{$id}{literal}&cmd=change_layout&new_layout='+id;
                                    }
                                    {/literal}
                                </script>
                            </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td align="center" style="border:1px solid #00FF00; padding-top: 10px">
                        {$regions}
                    </td>
                </tr>
                </table>
            </div>
        </div> <!-- Small boxes (Stat box) -->
    </section>
</div>
