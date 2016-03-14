<div class="center_content">
	<div class="div_content">
	<!-- Box tim kiem -->
	{if $new}
		<div class="box_center">
			<div class="box_search">
				<div class="title_new">
					<h1>
						{$new.name}
						<div style="float:right; margin-left: 20px">
							<div class="fb-like fb-share-button" data-href="{$new.view}" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div>
						</div>
					</h1>
					<i>Ngày {$new.create_time|date_format:"%d/%m/%Y %H:%M"}</i>
				</div>
				<div class="content_new">
					{$new.content}
				</div>
			</div>

		{*List san pham cung loai*}
		{if $item_pro|@count gt 0}
			<div class="list_new">
			<div class="item_new" style="border-bottom:1px solid #ccc; font-size: 14px"><b>Tin liên quan</b></div>
				{foreach from=$item_pro key=key item=itemsPro name=list_itemPro}
					<div class="item_new">
						<a href="{$itemsPro.view}">{$itemsPro.name}</a>
					</div>
				{/foreach}	
			</div>		
		{/if}
		</div>
                
	{/if}
	</div>
</div>
{literal}
    <script type="text/javascript">
        function onclikShareFacebook(url_share){
            window.open(''+url_share+'', 'sharer', 'toolbar=0,status=0,width=548,height=325');
        }
    </script>
	<script src="https://cdn.jsdelivr.net/sharer.js/latest/sharer.min.js"></script>
 {/literal}       
<!-- end noi dung o giua -->